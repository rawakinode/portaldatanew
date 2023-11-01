@extends('admin.layout.layout')

@section('content')
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Semua Mahasiswa Lulus</h3>
            <p class="text-subtitle text-muted">Menampilkan semua mahasiswa lulus.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Semua Mahasiswa Lulus</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--INCLUDE -->
    @include('trait._success')

    <div class="card">
        <div class="row">
            <div class="col-sm">
                <h5 class="card-header">Daftar Mahasiswa Lulus</h5>
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
                            <th>Angkatan</th>
                            <th>Kelamin</th>
                            <th>Tahun Lulus</th>
                            <th>IPK</th>
                            <th>Tanggal Yudisium</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
    
                        @foreach ($mahasiswa_lulus as $mhs)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td> {{ $mhs['nim'] }} </td>
                                <td>{{ ucwords($mhs['nama']) }}</td>
                                <td> {{ $mhs['tahun_masuk'] }} </td>
                                <td> {{ $mhs['kelamin'] == 1 ? 'Laki-laki' : 'Perempuan'}} </td>
                                <td> {{ $mhs['tahun_keluar'] }} </td>
                                <td> {{ $mhs['ipk'] }} </td>
                                <td> {{ $mhs['tanggal_yudisium'] }}</td>
                            </tr>
                        @endforeach
    
                        @if (count($mahasiswa_lulus) < 1)
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
