@extends('portaldata.template')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <style>
        .dataTables_length label {
            color: #607080;
        }

        .dataTables_filter label {
            color: #607080;
        }

        .dataTables_info {
            color: #607080;
        }
    </style>
    <section class="text-light p-5" style="background-color: #002f67">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 text-center">

                    <!-- Heading -->
                    <h1 style="color:aliceblue">Instrumen Akreditasi</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Data Tabel Instrumen Borang Akreditasi
                    </p>

                </div>
                
            </div>
        </div>
    </section>

    <section class="text-dark" style="background-color: #f2f7ff; padding-top: 4rem;">
        <div class="container">

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Program Studi</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="for_tabel">
                                <table class="table" id="data_tabel">
                                    <thead style="background-color: #e7ecff">
                                        <tr>
                                            <th>#</th>
                                            <th scope="col">Fakultas</th>
                                            <th scope="col">Prodi</th>
                                            <th scope="col">Jenjang</th>
                                            <th scope="col">Jumlah Tabel</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="baris">    
                                        @foreach ($prodi as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['faculty']['name'] }}</td>
                                                <td>{{ strtoupper($item['nama']) }}</td>
                                                <td>{{ $item['jenjang'] }}</td>
                                                <td>{{ $item['tabel_instrumen']->count() }}</td>
                                                <td><a href="/data/instrumen/{{ $item['kode'] }}">Lihat Instrumen</a></td>
                                            </tr>
                                        @endforeach
                                                                                  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
