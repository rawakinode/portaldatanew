@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="{{ asset('/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Buku</h3>
            <p class="text-subtitle text-muted">Menampilkan daftar buku ber-ISBN yang di hasilkan oleh dosen atau mahasiswa.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Buku</li>
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
                <a href="/prodi/akreditasi/buku/create"><button type="button" class="btn btn-primary"
                        style="margin-right: 15px"><i class="bi bi-plus-square"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Buku</button></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">No</th>
                            <th>ISBN</th>
                            <th>Dosen</th>
                            <th>Mahasiswa</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Kota</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($buku as $data)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td>{{ $data['isbn'] }}</td>
                                <td>{{ ucwords($data['dosen_homebase']['nama']) }} <br> {{ ucwords($data['nidn']) }}</td>
                                <td>{{ ucwords($data['mahasiswa']['nama']) }} <br> {{ ucwords($data['nim']) }}</td>
                                <td>{{ ucwords($data['judul']) }}</td>
                                <td>{{ ucwords($data['deskripsi']) }}</td>
                                <td>{{ ucwords($data['penerbit']) }}</td>
                                <td>{{ $data['tahun'] }}</td>
                                <td>{{ ucwords($data['kota']) }}</td>
                                <td>{{ ucwords($data['kategori']) }}</td>
                                <td>{{ ucwords($data['keterangan']) }}</td>
                                <td>{{ ucwords($data['bukti']) }}</td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a href="/prodi/akreditasi/buku/{{ $data->ids }}/edit"><button type="button"
                                                class="btn btn-sm btn-icon btn-primary" style="margin-left: 5px"><i
                                                    class="bi bi-pencil-fill"></i></button></a>
                                        <form action="/prodi/akreditasi/buku" method="post" style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="ids" id="ids" value="{{ $data->ids }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus buku ini ?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($buku) < 1)
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
