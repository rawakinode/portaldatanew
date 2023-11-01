@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Status Perkuliahan Mahasiswa</h3>
            <p class="text-subtitle text-muted">Menampilkan aktivitas perkuliahan dan status aktif mahasiswa</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Status Perkuliahan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--INCLUDE -->
    @include('trait._error')
    @include('trait._success')

    <section class="mt-2">
        <div class="card">
            <div class="card-body">
                <form action="/prodi/data/statusmahasiswa">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Ajaran</label>
                                <input class="form-control" type="number" name="tahun" value="{{ request('tahun') }}"
                                    placeholder="contoh: 2022" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select" name="semester" id="semester">
                                    <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Ganjil
                                    </option>
                                    <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="angkatan" class="form-label">Angkatan (Opsional)</label>
                                <input class="form-control" type="number" name="angkatan" value="{{ request('angkatan') }}"
                                    placeholder="contoh: 2020">
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="upload" class="form-label"></label>
                                <input class="form-control btn btn-primary mt-2" type="submit" value="Terapkan">
                            </div>
                        </div>
                        <div class="col-12">
                            <small>Masukkan tahun ajaran dan pilih semester untuk menampilkan mahasiswa.</small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- menampilkan tabel dosen --}}
    <div class="card">
        <div class="row">
            <div class="col-sm">
                <h5 class="card-header">Daftar Mahasiswa</h5>
            </div>
            <div class="col-sm mt-3" style="text-align: right">
                <button onclick="document.getElementById('submit').click()" type="button" class="btn btn-success" style="margin-right: 15px"><i class="bi bi-check-lg"
                        style="margin-right:7px;position: relative;top: -1px;"></i> Simpan Perubahan</button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-wrap">
                <form action="/prodi/data/statusmahasiswa" method="post">
                    @csrf
                    <table class="table table-striped" id="example">
                        <thead>
                            <tr>
                                <th style="padding-left: 20px">No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Angkatan</th>
                                <th>Status</th>
                                <th>IPK</th>
                                <th>SKS Total</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($mahasiswa as $mhs)
                                <tr>
                                    <input style="display:none" type="text" value="{{ $mhs['id'] }}" name="id[]">
                                    <input style="display:none" type="number" value="{{ request('tahun') }}" name="thn">
                                    <input style="display:none" type="number" value="{{ request('semester') }}" name="sms">
                                    <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                    <td> {{ $mhs['nim'] }} </td>
                                    <td>{{ ucwords($mhs['nama']) }}</td>
                                    <td> {{ $mhs['tahun_masuk'] }} </td>
                                    <td>
                                        <select class="form-select" name="status[]" id="status">
                                            <option value="">Pilih...</option>
                                            <option value="aktif" {{ optional($mhs['status_mahasiswa'])['status'] == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ optional($mhs['status_mahasiswa'])['status'] == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            <option value="cuti" {{ optional($mhs['status_mahasiswa'])['status'] == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                        </select>
                                        
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" step="any" name="ipk[]"
                                            value="{{ $mhs['status_mahasiswa']['ipk'] ?? '' }}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" name="sks[]" max="500"
                                            value="{{ $mhs['status_mahasiswa']['sks'] ?? '' }}">
                                    </td>

                                </tr>
                            @endforeach

                            @if (count($mahasiswa) < 1)
                                <tr>
                                    <td colspan="9" class="text-center">
                                        Tidak ada mahasiswa.
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    <input type="submit" value="" id="submit" hidden>
                </form>
            </div>
        </div>
    </div>


    <script>
        // // $(document).ready(function() {
        // //     $.fn.dataTable.ext.errMode = 'none'; //ignore error pop up
        // //     $('#example').DataTable(); //show data tabel 
        // // });

        // var tabel = document.getElementById('example');
        // var baris = tabel.rows;

        // var data = [];

        // for (let i = 1; i < baris.length; i++) {
        //     const e = baris[i];

        //     const nama = e.children[2].innerHTML;
        //     const nim = e.children[2].innerHTML;

        //     let arr = [
        //         e.children[0].innerHTML,
        //         e.children[1].innerHTML,
        //         e.children[2].innerHTML,
        //         e.children[3].innerHTML,
        //         e.children[4].innerHTML,
        //         e.children[5].innerHTML
        //     ];

        //     var p = e.children[5].innerHTML;
        //     console.log(p);

        //     // console.log(e.children[1].innerHTML);

        //     data.push(arr);


        //     // for (let m = 0; m < e.children.length; m++) {
        //     //     const n = e.children[m];
        //     //     console.log(n.innerHTML);
        //     // }
        // }

        // console.log(data);
    </script>
@endsection
