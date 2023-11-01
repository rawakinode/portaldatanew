@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Seleksi Mahasiswa Baru</h3>
            <p class="text-subtitle text-muted">Menampilkan daftar data seleksi mahasiswa baru berdasarkan tahun akademik.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Seleksi Mahasiswa Baru</li>
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
                <a href="/prodi/data/seleksi_mahasiswa_baru/create"><button type="button" class="btn btn-primary"
                        style="margin-right: 15px"><i class="bi bi-plus-square"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Data</button></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">No</th>
                            <th>Tahun</th>
                            <th>Daya Tampung</th>
                            <th>Mahasiswa Pendaftar</th>
                            <th>Mahasiswa Lulus Seleksi</th>
                            <th>Mahasiswa Baru Reguler</th>
                            <th>Mahasiswa Baru Transfer</th>
                            <th>Mahasiswa Aktif Reguler</th>
                            <th>Mahasiswa Aktif Transfer</th>
                            <th>Mahasiswa Aktif Luar Provinsi</th>
                            <th>Mahasiswa Aktif Luar Negeri</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($seleksi_mahasiswa_baru as $seleksi_mb)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td>{{ $seleksi_mb['tahun'] }}</td>
                                <td>{{ $seleksi_mb['daya_tampung'] }}</td>
                                <td>{{ $seleksi_mb['mahasiswa_mendaftar'] }}</td>
                                <td>{{ $seleksi_mb['mahasiswa_lulus_seleksi'] }}</td>
                                <td>{{ $seleksi_mb['mahasiswa_baru_reguler'] }}</td>
                                <td>{{ $seleksi_mb['mahasiswa_baru_transfer'] }}</td>
                                <td>{{ $seleksi_mb['mahasiswa_aktif_reguler'] }}</td>
                                <td>{{ $seleksi_mb['mahasiswa_aktif_transfer'] }}</td>
                                <td>{{ $seleksi_mb['mahasiswa_aktif_luar_provinsi'] }}</td>
                                <td>{{ $seleksi_mb['mahasiswa_aktif_luar_negeri'] }}</td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a href="/prodi/data/seleksi_mahasiswa_baru/{{ $seleksi_mb->ids }}/edit"><button type="button"
                                                class="btn btn-sm btn-icon btn-primary" style="margin-left: 5px"><i
                                                    class="bi bi-pencil-fill"></i></button></a>
                                        <form action="/prodi/data/seleksi_mahasiswa_baru" method="post" style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="ids" id="ids" value="{{ $seleksi_mb->ids }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus data ini ?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($seleksi_mahasiswa_baru) < 1)
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
