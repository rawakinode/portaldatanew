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
                    <h1 style="color:aliceblue">Program Studi {{ ucwords($prodi['nama']) }}</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Data Tabel Instrumen Borang Akreditasi Progam Studi {{ ucwords($prodi['nama']) }}
                    </p>

                </div>
                
            </div>
        </div>
    </section>

    <section class="text-dark" style="background-color: #f2f7ff; padding-top: 4rem;">
        <div class="container">

            <div class="row mt-2">
                <div class="col-md-12">

                    @foreach ($instrumen as $item)

                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel {{ $item['nama'] }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="data_tabel" style="font-size: 0.9rem">
                                        <thead style="background-color: #e7ecff;color:#002f67">
                                            <tr>
                                                <th>#</th>
                                                @foreach ($item['tabel']['header'] as $tb)
                                                    <th>{{ $tb }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i < count($item['tabel']['data']); $i++)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    @for ($x = 0; $x < count($item['tabel']['urutan']); $x++)
                                                        
                                                        <td style="text-transform: uppercase">{{ $item['tabel']['data'][$i][$item['tabel']['urutan'][$x]] }}</td>
                                                    @endfor
                                                </tr>
                                            @endfor
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>           
                    
                    @endforeach

                </div>
            </div>

        </div>
    </section>


    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
