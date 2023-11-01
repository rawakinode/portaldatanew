@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Penelitian</h3>
            <p class="text-subtitle text-muted">Menampilkan daftar penelitian dosen.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Penelitian</li>
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
                <a href="/prodi/data/penelitian/create"><button type="button" class="btn btn-primary"
                        style="margin-right: 15px"><i class="bi bi-plus-square"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Penelitian</button></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">No</th>
                            <th>Judul Penelitian</th>
                            <th>Tema</th>
                            <th>Dosen Peneliti</th>
                            <th>Mhs Terlibat</th>
                            <th>Tahun</th>
                            <th>Sumber Dana</th>
                            <th>Jumlah Dana</th>
                            <th>Rujukan Tema Skripsi/Tesis</th>
                            <th>Integrasi dalam Pembelajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($penelitian as $pn)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td>{{ ucwords($pn['judul']) }}</td>
                                <td>{{ ucwords($pn['tema']) }}</td>
                                <td>
                                    @if ($pn['dosen'])
                                        @foreach (json_decode($pn['dosen']) as $item)
                                            {{ $item->dosen }} <br>
                                        @endforeach
                                    @endif

                                </td>
                                <td>
                                    @if ($pn['mahasiswa'])
                                        @foreach (json_decode($pn['mahasiswa']) as $item)
                                            {{ $item->mahasiswa }} <br>
                                        @endforeach
                                    @endif

                                </td>
                                <td>{{ $pn['tahun'] }}</td>
                                <td>{{ ucwords($pn['sumber_dana']) }}</td>
                                <td>{{ $pn['jumlah_dana'] }}</td>
                                <td>{{ ucwords($pn['rujukan_tema']) }}</td>
                                <td>{{ ucwords($pn['integrasi_pembelajaran']) }}</td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a href="/prodi/data/penelitian/{{ $pn->ids }}/edit"><button type="button"
                                                class="btn btn-sm btn-icon btn-primary" style="margin-left: 5px"><i
                                                    class="bi bi-pencil-fill"></i></button></a>
                                        <form action="/prodi/data/penelitian" method="post" style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="ids" id="ids" value="{{ $pn->ids }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus penelitian ini ?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($penelitian) < 1)
                            <tr>
                                <td colspan="10" class="text-center">
                                    Tidak ada penelitian.
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
