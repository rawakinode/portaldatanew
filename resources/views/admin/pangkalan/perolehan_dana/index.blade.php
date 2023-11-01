@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Perolehan Dana</h3>
            <p class="text-subtitle text-muted">Menampilkan daftar perolehan dana.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Perolehan Dana</li>
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
                <a href="/prodi/akreditasi/perolehan_dana/create"><button type="button" class="btn btn-primary"
                        style="margin-right: 15px"><i class="bi bi-plus-square"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Perolehan Dana</button></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">No</th>
                            <th>Nama / Judul</th>
                            <th>Tahun Perolehan</th>
                            <th>Sumber</th>
                            <th>Jenis</th>
                            <th>Jumlah Dana</th>
                            <th>Keterangan</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($perolehan_dana as $perdana)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td>{{ ucwords($perdana['judul']) }}</td>
                                <td>{{ $perdana['tahun'] }}</td>
                                <td>{{ ucwords($perdana['sumber']) }}</td>
                                <td>{{ ucwords($perdana['jenis']) }}</td>
                                <td>Rp. {{ $perdana['jumlah'] }}</td>
                                <td>{{ ucwords($perdana['keterangan']) }}</td>
                                <td>{{ $perdana['bukti'] }}</td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a href="/prodi/akreditasi/perolehan_dana/{{ $perdana->ids }}/edit"><button type="button"
                                                class="btn btn-sm btn-icon btn-primary" style="margin-left: 5px"><i
                                                    class="bi bi-pencil-fill"></i></button></a>
                                        <form action="/prodi/akreditasi/perolehan_dana" method="post" style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="ids" id="ids" value="{{ $perdana->ids }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus perolehan dana ini ?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($perolehan_dana) < 1)
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
