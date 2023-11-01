@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Kepuasan Pengguna Lulusan</h3>
            <p class="text-subtitle text-muted">Menampilkan daftar kepuasan pengguna lulusan.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kepuasan Pengguna Lulusan</li>
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
                <a href="/prodi/akreditasi/pengguna_lulusan/create"><button type="button" class="btn btn-primary"
                        style="margin-right: 15px"><i class="bi bi-plus-square"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Kepuasan Pengguna</button></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Tahun</th>
                            <th>Penilai</th>
                            <th>Jabatan Penilai</th>
                            <th>Instansi</th>
                            <th>Etika</th>
                            <th>Kompetensi Utama</th>
                            <th>Bahasa Asing</th>
                            <th>Penerapan Teknologi</th>
                            <th>Komunikasi</th>
                            <th>Kerjasama</th>
                            <th>Pengembangan Diri</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($pengguna_lulusan as $peng)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td>{{ ucwords($peng['nim']) }}</td>
                                <td>{{ ucwords($peng['mahasiswa']['nama']) }}</td>
                                <td>{{ $peng['tahun'] }}</td>
                                <td>{{ $peng['nama_penilai'] }}</td>
                                <td>{{ $peng['jabatan_penilai'] }}</td>
                                <td>{{ ucwords($peng['instansi']) }}</td>
                                <td>{{ ucwords($peng['etika']) }}</td>
                                <td>{{ ucwords($peng['kompetensi_utama']) }}</td>
                                <td>{{ ucwords($peng['bahasa_asing']) }}</td>
                                <td>{{ ucwords($peng['teknologi_informasi']) }}</td>
                                <td>{{ ucwords($peng['komunikasi']) }}</td>
                                <td>{{ ucwords($peng['kerjasama']) }}</td>
                                <td>{{ ucwords($peng['pengembangan_diri']) }}</td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a href="/prodi/akreditasi/pengguna_lulusan/{{ $peng->ids }}/edit"><button type="button"
                                                class="btn btn-sm btn-icon btn-primary" style="margin-left: 5px"><i
                                                    class="bi bi-pencil-fill"></i></button></a>
                                        <form action="/prodi/akreditasi/pengguna_lulusan" method="post" style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="ids" id="ids" value="{{ $peng->ids }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus tracer study ini ?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($pengguna_lulusan) < 1)
                            <tr>
                                <td colspan="15" class="text-center">
                                    Tidak ada data.
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
