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
                    <h1 style="color:aliceblue">Data Jadwal Pengajar Mata Kuliah</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Jadwal pengajar mata kuliah yang terdaftar.
                    </p>

                </div>
                <form>
                    @csrf
                    <div class="row mt-4">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="">Semester</label>
                            <select class="form-select" aria-label="tahun periode" name="tahun" onchange="selectTahun()">
                                <option value="20221">Ganjil 2022/2023</option>
                                <option value="20212">Genap 2021/2022</option>
                                <option value="20211">Ganjil 2021/2022</option>
                                <option value="20202">Genap 2020/2021</option>
                                <option value="20201">Ganjil 2020/2021</option>

                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="">Jenjang</label>
                            <select class="form-select" aria-label="jenjang studi" name="jenjang"
                                onchange="selectJenjang()">
                                <option value="">- Semua -</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="PROF">PROFESI</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                                <option value="SPES">SPESIALIS</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="">Unit Pengelola Prodi</label>
                            <select class="form-select" aria-label="fakultas" name="fakultas" onchange="selectFakultas()">
                                <option value="0">- Semua -</option>
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
                        <div class="col-12 col-md-6 col-lg-3" id="form-prodi">
                            <label for="">Prodi</label>
                            <select class="form-select" aria-label="program studi" name="prodi" id="prodi"
                                onchange="selectProdi()">
                                <option value="" selected>- Semua -</option>
                            </select>
                        </div>
                        <button type="button" name="submit" id="submit" hidden>SUBMIT</button>
                    </div>
                </form>
                <div class="row mt-5" id="maindata">
                    <div class="col-12 col-md-4 text-center">
                        <h1 style="font-size: 50pt;color:aliceblue" id="totaldata">0</h1>
                        <h3 style="color:aliceblue">Total kelas</h3>
                    </div>
                    <div class="col-12 col-md-8" id="chart_utama">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="text-dark" style="background-color: #f2f7ff; padding-top:4rem;">
        <div class="container">
            <div class="text-center">
                <p class="text-muted">Data Berdasarkan</p>
                <h1 style="font-weight: 600;">Jumlah Kelas</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Jumlah Kelas Pengajar</h4>
                        </div>
                        <div class="card-body">
                            <table class="table" id="tabel_kelas">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Dosen</th>
                                        <th scope="col">Jumlah Kelas</th>
                                    </tr>
                                </thead>
                                <tbody id="kelas">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Jumlah Kelas</h4>
                        </div>
                        <div class="card-body" id="id_chart_2">
                            <canvas id="kelas_chart" style="height:65vh; width:80vw"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="text-dark p-3" style="background-color: #f2f7ff;">
        <div class="container">
            <div class="text-center">
                <p class="text-muted">Data Berdasarkan</p>
                <h1 style="font-weight: 600;">Hari Perkuliahan</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Hari Perkuliahan</h4>
                        </div>
                        <div class="card-body" id="id_chart_3">
                            <canvas id="hari_chart" style="height:30vh;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Hari Perkuliahan</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Hari</th>
                                        <th scope="col">Jumlah Kelas</th>
                                    </tr>
                                </thead>
                                <tbody id="hari">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="text-dark p-3" style="background-color: #f2f7ff;">
        <div class="container">
            <div class="text-center">
                <p class="text-muted">Data Berdasarkan</p>
                <h1 style="font-weight: 600;">Jam Perkuliahan</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jam Perkuliahan</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Jumlah Kelas</th>
                                    </tr>
                                </thead>
                                <tbody id="jam">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Waktu Perkuliahan</h4>
                        </div>
                        <div class="card-body" id="id_chart_4">
                            <canvas id="jam_chart" style="height:40vh;"></canvas>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <script type="text/javascript">
        $(document).ready(function() {
            getDataMahasiswa();
        });

        function selectTahun() {
            document.querySelector("select[name=jenjang]").value = '';
            document.querySelector("select[name=fakultas]").value = '0';

            reloadProdi();

            $("#maindata").load(window.location.href + " #maindata>*", "");

            //Jalankan fungsi
            getDataMahasiswa();

        }

        //Fungsi untuk meload data berdasarkan jenjang yang di pilih
        function selectJenjang() {
            document.querySelector("select[name=fakultas]").value = '0';

            reloadProdi();

            //Reload div
            $("#maindata").load(window.location.href + " #maindata>*", "");

            //Jalankan fungsi
            getDataMahasiswa();

        }

        //Fungsi untuk meload data berdasarkan fakultas yang di pilih
        function selectFakultas() {
            document.querySelector("select[name=prodi]").value = '0';

            //Reload div
            $("#maindata").load(window.location.href + " #maindata>*", "");

            reloadProdi();

            //Menambahkan list prodi
            getListProdi();

            //Jalankan fungsi
            getDataMahasiswa();

        }

        //Fungsi untuk meload data berdasarkan prodi yang di pilih
        function selectProdi() {

            //Reload div
            $("#maindata").load(window.location.href + " #maindata>*", "");

            //Jalankan fungsi
            getDataMahasiswa();

        }

        //AJAX Untuk mendapatkan data prodi list
        function getListProdi() {

            var fakultas = $("select[name=fakultas]").val();
            var token = $("input[name=_token]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('get-prodi-list') }}",
                data: {
                    fakultas: fakultas,
                    _token: token
                },
                dataType: 'json',
                success: function(data) {
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

        }

        //Fungsi mereload list prodi
        function reloadProdi() {
            //Mengosongkan elemen
            $("#form-prodi").empty();

            //menambahkan elemen
            $('#form-prodi').append(
                '<label for="">Prodi</label><select class="form-select" aria-label="program studi" name="prodi" id="prodi" onchange="selectProdi()"><option value="">- Semua -</option></select>'
            );
        }

        //AJAX Untuk mendapatkan data
        function getDataMahasiswa() {

            $('#chart_utama').empty();
            $('#kelas').empty();
            $('#hari').empty();
            $('#jam').empty();
            $('#chart_utama').append('<canvas id="myChart"></canvas>');
            $('#id_chart_2').empty();
            $('#id_chart_3').empty();
            $('#id_chart_4').empty();
            $('#id_chart_2').append('<canvas id="kelas_chart" style="height:65vh; width:80vw"></canvas>');
            $('#id_chart_3').append('<canvas id="hari_chart" style="height:30vh;"></canvas>');
            $('#id_chart_4').append('<canvas id="jam_chart" style="height:40vh;"></canvas>');

            var tahun = $("select[name=tahun]").val();
            var jenjang = $("select[name=jenjang]").val();
            var fakultas = $("select[name=fakultas]").val();
            var prodi = $("select[name=prodi]").val();
            var token = $("input[name=_token]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('jadwalpengajar_get') }}",
                data: {
                    prodi: prodi,
                    fakultas: fakultas,
                    jenjang: jenjang,
                    tahun: tahun,
                    _token: token
                },
                dataType: 'json',
                success: function(data) {
                    prosesData(data, fakultas);
                }
            });
        }

        //Fungsi untuk memproses data yang telah didapatkan dari AJAX dan menampilkan dalam grafik
        function prosesData(e, b) {

            let m = e.data;
            let s = e.status;
            let f = e.data[0];

            var totalkelas = 0;

            if (b != 0) {
                s = m[0];
            }

            let label = [];
            let dataset = [];

            let label_kelas = [];
            let dataset_kelas = [];

            let label_hari = [];
            let dataset_hari = [];

            let label_jam = [];
            let dataset_jam = [];

            var prd = document.getElementById("prodi").value;

            //Menampilkan chart utama dan Total kelas
            let x = (b == 0) ? m : f.prodi;
            totalkelas = (b == 0) ? s.total_kelas : f.total_kelas;

            if (b != 0 && prd != '') {
                const items = x.findIndex(item => item.id == prd);
                x = x.filter((_, i) => i === items);
                totalkelas = x[0].total_kelas;
            }

            for (let i = 0; i < x.length; i++) {
                const e = x[i];
                label.push((b == 0) ? e.name : e.nama);
                dataset.push(e.total_kelas);
            }
            document.getElementById("totaldata").innerText = totalkelas;

            //Menampilkan data kelas perkuliahan
            let y = (b == 0) ? s : f;
            if (b != 0 && prd != '') {
                const items = y.prodi.findIndex(item => item.id == prd);
                y = y.prodi.filter((_, i) => i === items);
                y = y[0];
                
            }

            let kp = y.jumlah_kelas_pengajar;
            let kp_sort = kp.sort((a, b) => b.jumlah - a.jumlah);

            for (let i = 0; i < kp_sort.length; i++) {
                const e = kp_sort[i];
                $('#kelas').append('<tr><td>' + e.nama + '</td><td>' + e.jumlah + '</td></tr>');
            }

            for (let i = 0; i < kp_sort.length; i++) {
                if (i === 10) {
                    break;
                }
                const e = kp_sort[i];
                label_kelas.push(e.nama);
                dataset_kelas.push(e.jumlah);
            }

            $(document).ready(function() {
                $.fn.dataTable.ext.errMode = 'none'; 
                $('#tabel_kelas').DataTable({
                    "order": [
                        [1, "desc"]
                    ]
                });
            });

            //Menampilkan data hari perkuliahan
            let hr = y.hari_perkuliahan;

            for (let i = 0; i < hr.length; i++) {
                const e = hr[i];
                $('#hari').append('<tr><td>' + e.nama + '</td><td>' + e.jumlah + '</td></tr>');
                label_hari.push(e.nama);
                dataset_hari.push(e.jumlah);
            }

            //Menampilkan data jam perkuliahan
            let jm = y.jam_perkuliahan;
            for (let i = 0; i < jm.length; i++) {
                const e = jm[i];
                $('#jam').append('<tr><td>' + e.nama + '</td><td>' + e.jumlah + '</td></tr>');
                label_jam.push(e.nama);
                dataset_jam.push(e.jumlah);
            }

            //menampilkan total data
            tampilkan_chart(dataset, label);
            tampilkan_chart_pertama(label_kelas, dataset_kelas);
            tampilkan_chart_kedua(label_hari, dataset_hari);
            tampilkan_chart_ketiga(label_jam, dataset_jam);
        }
    </script>

    <script src="{{ asset('assets/javascript/akademik/chart_jadwal.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
