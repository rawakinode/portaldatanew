@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Instrumen Akreditasi</h3>
            <p class="text-subtitle text-muted">Halaman pengaturan tabel instrumen yang akan tampil pada halaman portal data.
            </p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Instrumen Akreditasi</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--INCLUDE -->
    @include('trait._success')
    <form action="/prodi/akreditasi/instrumen" method="post">
        @csrf
        <section>
            <div class="row mb-3">
                <div class="col">
                    <a class="btn btn-success" style="float: right;margin-left:5px;" target="_blank"
                        href="/data/instrumen/{{ auth()->user()->prodi['kode'] }}">Lihat Instrumen</a>
                    <input type="submit" class="btn btn-primary" style="float: right" value="Simpan">
                </div>
            </div>
        </section>
        <div class="card">

            <div class="card-body">
                <div class="table-responsive text-wrap">
                    <table class="table table-striped" id="example">
                        <thead>
                            <tr>
                                <th style="padding-left: 20px">No</th>
                                <th>Tabel Instrumen</th>
                                <th style="text-align: center;"><input class="form-check-input" type="checkbox"
                                        name="centang" id="centang" onchange="ceentangUncentang()"></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($instrumen as $data)
                                <tr>
                                    <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                    <td>{{ ucwords($data['nama']) }}</td>
                                    <td width="100">
                                        <div class="d-flex text-nowrap justify-content-center">
                                            <input class="form-check-input" type="checkbox" name="instrumen[]"
                                                value="{{ $data['slug'] }}"
                                                @if ($data['instrumen_terpilih'] && $data['instrumen_terpilih']['status'] == 1) checked @endif>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if (count($instrumen) < 1)
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
    </form>

    <script>
        function ceentangUncentang() {

            let a = document.getElementById('centang').checked;
            let checkboxes = document.querySelectorAll("input[name='instrumen[]']");

            checkboxes.forEach(function(c) {
                if (a == true) {
                    c.checked = true;
                } else {
                    c.checked = false;
                }
            });
        }
    </script>
    
@endsection
