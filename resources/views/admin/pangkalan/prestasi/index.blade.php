@extends('admin.layout.layout')

@section('content')
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Prestasi Mahasiswa</h3>
            <p class="text-subtitle text-muted">Menampilkan prestasi mahasiswa.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Prestasi Mahasiswa</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--INCLUDE -->
    @include('trait._success')

    <div class="card">
        <div class="row">
            <div class="col-sm">
                <h5 class="card-header">Daftar</h5>
            </div>
            <div class="col-sm mt-3" style="text-align: right">
                <a
                    href="/prodi/data/prestasi/create"><button
                        type="button" class="btn btn-primary" style="margin-right: 15px"><i class="bi bi-plus-square"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Prestasi</button></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">No</th>
                            <th>Judul Prestasi</th>
                            <th>Prestasi Diraih</th>
                            <th>Mahasiswa</th>
                            <th>NIM</th>
                            <th>Tahun</th>
                            <th>Bidang</th>
                            <th>Tingkat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
    
                        @foreach ($prestasi as $pres)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td>{{ ucwords($pres['nama']) }}</td>
                                <td>{{ ucwords($pres['prestasi']) }}</td>
                                <td>{{ ucwords($pres['nama_mahasiswa']) }}</td>
                                <td>{{ $pres['nim'] }}</td>
                                <td>{{ $pres['tahun'] }}</td>
                                <td>{{ ucwords($pres['bidang']) }}</td>
                                <td>{{ ucwords($pres['tingkat']) }}</td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a
                                            href="/prodi/data/prestasi/{{ $pres->ids }}/edit"><button
                                                type="button" class="btn btn-sm btn-icon btn-primary"
                                                style="margin-left: 5px"><i class="bi bi-pencil-fill"></i></button></a>
                                        <form action="/prodi/data/prestasi" method="post" style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="ids" id="ids" value="{{ $pres->ids }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus prestasi mahasiswa ini ?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
    
                                    </div>
                                </td>
                            </tr>
                        @endforeach
    
                        @if (count($prestasi) < 1)
                            <tr>
                                <td colspan="9" class="text-center">
                                    Tidak ada prestasi.
                                </td>
                            </tr>
                        @endif
    
                    </tbody>
                </table>
            </div>
        </div>


    </div>


    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'none'; //ignore error pop up
            $('#example').DataTable(); //show data tabel 
        });
    </script>
@endsection
