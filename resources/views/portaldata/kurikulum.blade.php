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
                    <h1 style="color:aliceblue">Data Kurikulum</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Kurikulum program studi adalah distribusi mata kuliah di suatu program studi.
                    </p>

                </div>
                <form>
                    @csrf
                    <div class="row mt-4">
                        <div class="col-12 col-md-4">
                            <label for="">Jenjang</label>
                            <select class="form-select" aria-label="jenjang studi" name="jenjang" onchange="getListProdi()">
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1" selected>S1</option>
                                <option value="PROF">PROFESI</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                                <option value="SPES">SPESIALIS</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="">Unit Pengelola Prodi</label>
                            <select class="form-select" aria-label="fakultas" name="fakultas" onchange="getListProdi()">
                                <option value="1">Fakultas Keguruan dan Ilmu Pendidikan</option>
                                <option value="2">Fakultas Ilmu Sosial dan Ilmu Politik</option>
                                <option value="3">Fakultas Ekonomi</option>
                                <option value="4">Fakultas Hukum</option>
                                <option value="5">Fakultas Pertanian</option>
                                <option value="6">Fakultas Teknik</option>
                                <option value="7">Fakultas Matematika dan Ilmu Pengetahuan Alam</option>
                                <option value="8">Fakultas Kehutanan</option>
                                <option value="9">Fakultas Kedokteran</option>
                                <option value="10">Fakultas Peternakan dan Perikanan</option>
                                <option value="11">Fakultas Kesehatan Masyarakat</option>
                                <option value="12">Pasca Sarjana</option>
                                <option value="13">PSDKU Morowali</option>
                                <option value="14">PSDKU Tojo Una-Una</option>

                            </select>
                        </div>
                        <div class="col-12 col-md-4" id="form-prodi">
                            <label for="">Prodi</label>
                            <select class="form-select" aria-label="program studi" name="prodi" id="prodi"
                                onchange="getData()">
                            </select>
                        </div>
                        <button type="button" name="submit" id="submit" hidden>SUBMIT</button>
                    </div>

                </form>
                <div class="row mt-5" id="maindata">
                    <div class="col-12 col-md-4 text-center">
                        <h1 style="font-size: 50pt;color:aliceblue" id="totaldata">0</h1>
                        <h3 style="color:aliceblue">Total Mata Kuliah</h3>
                    </div>
                    <div class="col-12 col-md-8" id="chart_utama">
                        <canvas id="myChart" style="height:65vh; width:100vw"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="text-dark" style="background-color: #f2f7ff;padding-top:4rem;">
        <div class="container">
            <div class="text-center">
                <p class="text-muted">Data Berdasarkan</p>
                <h1 style="font-weight: 600;">Semester</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Semester</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Mata Kuliah</th>
                                        <th scope="col">SKS</th>
                                        <th scope="col">SKS Praktikum</th>
                                    </tr>
                                </thead>
                                <tbody id="semester">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Semester</h4>
                        </div>
                        <div class="card-body" id="semester_chart">
                            <canvas id="canvas_semester_chart" style="height:65vh; width:80vw"></canvas>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="text-dark" style="background-color: #f2f7ff;padding-top:4rem;">
        <div class="container">
            <div class="text-center">
                <p class="text-muted">Data Berdasarkan</p>
                <h1 style="font-weight: 600;">Jenis</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Jenis</h4>
                        </div>
                        <div class="card-body" id="jenis_chart">
                            <canvas id="canvas_jenis_chart" style="height:30vh;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Jenis</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Jenis MK</th>
                                        <th scope="col">Mata Kuliah</th>
                                        <th scope="col">SKS</th>
                                        <th scope="col">SKS Praktikum</th>
                                    </tr>
                                </thead>
                                <tbody id="jenis">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="text-dark" style="background-color: #f2f7ff; padding-top:4rem;">
        <div class="container">
            <div class="text-center">
                <p class="text-muted">Data Berdasarkan</p>
                <h1 style="font-weight: 600;">Matakuliah Wajib</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Wajib</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Wajib</th>
                                        <th scope="col">Mata Kuliah</th>
                                        <th scope="col">SKS</th>
                                        <th scope="col">SKS Praktikum</th>
                                    </tr>
                                </thead>
                                <tbody id="wajib">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Wajib</h4>
                        </div>
                        <div class="card-body" id="wajib_chart">
                            <canvas id="canvas_wajib_chart" style="height:50vh"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="text-dark" style="background-color: #f2f7ff; padding-top:4rem; padding-bottom:4rem">
        <div class="container">
            <div class="text-center">
                <p class="text-muted">Data Berdasarkan</p>
                <h1 style="font-weight: 600;">Data Tabular</h1>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive text-wrap">
                                <table class="table" id="tabel_tabular">
                                    <thead>
                                        <tr>
                                            <th>Semester</th>
                                            <th>Kode MK</th>
                                            <th>Nama MK</th>
                                            <th>SKS</th>
                                            <th>Wajib ?</th>
                                            <th>Jenis</th>
                                        </tr>
                                    </thead>
                                    <tbody id="datatabular">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script type="text/javascript">
        $(document).ready(function() {
            getListProdi();
        });

        //AJAX Untuk mendapatkan data prodi list
        function getListProdi() {

            var fakultas = $("select[name=fakultas]").val();
            var token = $("input[name=_token]").val();
            var jenjang = $("select[name=jenjang]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('kurikulum_prodi_get') }}",
                data: {
                    fakultas: fakultas,
                    jenjang: jenjang,
                    _token: token
                },
                dataType: 'json',
                success: function(data) {
                    $('#prodi').empty();
                    tampilkanListProdi(data);
                }
            });
        }

        //Fungsi untuk menambahkan daftar prodi ke form
        function tampilkanListProdi(m) {

            for (let o = 0; o < m.length; o++) {

                const nama = m[o].nama;
                const id = m[o].id;

                var h = '<option value="' + id + '">' + nama + '</option>';
                $('#prodi').append(h);

            }
            getData();

        }

        //AJAX Untuk mendapatkan data
        function getData() {

            $('#datatabular').empty();
            $('#chart_utama').empty();

            $('#semester').empty();
            $('#semester_chart').empty();

            $('#jenis').empty();
            $('#jenis_chart').empty();

            $('#wajib').empty();
            $('#wajib_chart').empty();

            $('#chart_utama').append('<canvas id="myChart"></canvas>');
            $('#semester_chart').append('<canvas id="canvas_semester_chart" style="height:65vh; width:80vw"></canvas>');
            $('#jenis_chart').append('<canvas id="canvas_jenis_chart" style="height:30vh;"></canvas>');
            $('#wajib_chart').append('<canvas id="canvas_wajib_chart" style="height:50vh"></canvas>');

            var prodi = $("select[name=prodi]").val();
            var token = $("input[name=_token]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('kurikulum_get') }}",
                data: {
                    prodi: prodi,
                    _token: token
                },
                dataType: 'json',
                success: function(data) {
                    prosesData(data);
                }
            });
        }

        //Fungsi untuk memproses data yang telah didapatkan dari AJAX dan menampilkan dalam grafik
        function prosesData(e) {

            var data = e.data;

            let label_semester = [];
            let dataset_semester = [];

            let label_wajib = [];
            let dataset_wajib = [];

            //Menampilkan total Matakuliah
            var jumlah_total = data.matakuliah.length;
            document.getElementById('totaldata').innerText = jumlah_total;

            //Mengelola Chart Utama
            let label = [data.nama];
            let dataset = [jumlah_total];

            let mks = data.matakuliah;
            mks.sort((a, b) => a.semester - b.semester)

            //Mengelola Semester
            var sem = data.data_semester;
            for (let i = 0; i < sem.length; i++) {
                const s = sem[i];
                label_semester.push(s.nama);
                dataset_semester.push(s.jumlah_mk);

                var sem_html = '<tr style="text-align:center"><td>'+ s.nama +'</td><td>'+s.jumlah_mk+'</td><td>'+s.jumlah_sks+'</td><td>'+s.jumlah_sks_praktikum+'</td></tr>';
                $('#semester').append(sem_html);
            }

            //Mengelola Jenis
            var jen = data.data_jenis;

            label_jenis = [jen.inti.nama, jen.mku.nama, jen.pilihan.nama];
            dataset_jenis = [jen.inti.jumlah_mk, jen.mku.jumlah_mk, jen.pilihan.jumlah_mk];

            $('#jenis').append('<tr style="text-align:center"><td>'+ jen.inti.nama +'</td><td>'+jen.inti.jumlah_mk+'</td><td>'+jen.inti.jumlah_sks+'</td><td>'+jen.inti.jumlah_sks_praktikum+'</td></tr>');

            $('#jenis').append('<tr style="text-align:center"><td>'+ jen.mku.nama +'</td><td>'+jen.mku.jumlah_mk+'</td><td>'+jen.mku.jumlah_sks+'</td><td>'+jen.mku.jumlah_sks_praktikum+'</td></tr>');

            $('#jenis').append('<tr style="text-align:center"><td>'+ jen.pilihan.nama +'</td><td>'+jen.pilihan.jumlah_mk+'</td><td>'+jen.pilihan.jumlah_sks+'</td><td>'+jen.pilihan.jumlah_sks_praktikum+'</td></tr>');

            //Mengelola Jenis
            var waj = data.data_wajib;

            label_wajib = [waj.wajib.nama, waj.tidak_wajib.nama];
            dataset_wajib = [waj.wajib.jumlah_mk, waj.tidak_wajib.jumlah_mk];

            $('#wajib').append('<tr style="text-align:center"><td>'+ waj.wajib.nama +'</td><td>'+waj.wajib.jumlah_mk+'</td><td>'+waj.wajib.jumlah_sks+'</td><td>'+waj.wajib.jumlah_sks_praktikum+'</td></tr>');

            $('#wajib').append('<tr style="text-align:center"><td>'+ waj.tidak_wajib.nama +'</td><td>'+waj.tidak_wajib.jumlah_mk+'</td><td>'+waj.tidak_wajib.jumlah_sks+'</td><td>'+waj.tidak_wajib.jumlah_sks_praktikum+'</td></tr>');

            //Data Tabular
            for (let i = 0; i < mks.length; i++) {
                const t = mks[i];

                var waj = 0;
                if (t.status == 1) {
                    waj = 'Ya';
                } else {
                    waj = 'Tidak';
                }

                var html = '<tr><td>' + t.semester + '</td><td>' + t.kode + '</td><td style="text-transform:capitalize">' + t.nama + '</td><td>' + t.sks + '</td><td>' + waj + '</td><td style="text-transform:capitalize">' + t.jenis + '</td></tr>';

                $('#datatabular').append(html);

            }

            //menampilkan total data
            tampilkan_chart(dataset, label);
            chart_semester(label_semester, dataset_semester);
            chart_jenis(label_jenis, dataset_jenis);
            chart_wajib(label_wajib, dataset_wajib);

        }

    </script>

    <script src="{{ asset('assets/javascript/akademik/chart_kurikulum.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
