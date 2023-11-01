@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tracer Study</h3>
            <p class="text-subtitle text-muted">Menampilkan daftar tracer study mahasiswa.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tracer Study</li>
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
                <a href="/prodi/akreditasi/tracer_study/create"><button type="button" class="btn btn-primary"
                        style="margin-right: 15px"><i class="bi bi-plus-square"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Tracer Study</button></a>
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
                            <th>Masa Studi</th>
                            <th>Waktu Tunggu Kerja</th>
                            <th>Kesesuaian Bidang Ilmu</th>
                            <th>Tingkat</th>
                            <th>Gaji UMR</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($tracer_study as $t_study)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td>{{ ucwords($t_study['nim']) }}</td>
                                <td>{{ ucwords($t_study['mahasiswa']['nama']) }}</td>
                                <td>{{ $t_study['tahun'] }}</td>
                                <td>{{ $t_study['masa_studi'] }} Bulan</td>
                                <td>{{ $t_study['waktu_tunggu_kerja'] }} Bulan</td>
                                <td>{{ ucwords($t_study['kesesuaian_bidang_ilmu']) }}</td>
                                <td>{{ ucwords($t_study['tingkat']) }}</td>
                                <td>{{ ucwords($t_study['umr'] == 1 ? 'Diatas UMR' : 'Dibawah UMR') }}</td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a href="/prodi/akreditasi/tracer_study/{{ $t_study->ids }}/edit"><button type="button"
                                                class="btn btn-sm btn-icon btn-primary" style="margin-left: 5px"><i
                                                    class="bi bi-pencil-fill"></i></button></a>
                                        <form action="/prodi/akreditasi/tracer_study" method="post" style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="ids" id="ids" value="{{ $t_study->ids }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus tracer study ini ?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($tracer_study) < 1)
                            <tr>
                                <td colspan="9" class="text-center">
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
