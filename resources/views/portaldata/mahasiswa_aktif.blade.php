@extends('portaldata.template')

@section('content')
    <section class="text-light p-5" style="background-color: #002f67">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 text-center">

                    <!-- Heading -->
                    <h1 style="color:aliceblue">Data Mahasiswa Aktif</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Menampilkan mahasiswa aktif, nonaktif, atau mahasiswa sedang cuti.
                    </p>

                </div>
                <form>
                    @csrf
                    <div class="row mt-4">
                        <div class="col-12 col-md-6 col-lg 3">
                            <label for="">Status Aktif</label>
                            <select class="form-select" aria-label="status aktif" name="status"
                                onchange="getDataMahasiswa();">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                                <option value="cuti">Cuti</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg 3">
                            <label for="">Semester</label>
                            <select class="form-select" aria-label="tahun periode" name="tahun" onchange="selectTahun()">
                                <option value="20222">Genap 2022/2023</option>
                                <option value="20221">Ganjil 2022/2023</option>
                                <option value="20212">Genap 2021/2022</option>
                                <option value="20211">Ganjil 2021/2022</option>
                                <option value="20202">Genap 2020/2021</option>
                                <option value="20201">Ganjil 2020/2021</option>
                                <option value="20192">Genap 2019/2021</option>
                                <option value="20191">Ganjil 2019/2021</option>
                                <option value="20182">Genap 2018/2021</option>
                                <option value="20181">Ganjil 2018/2021</option>
                                <option value="20172">Genap 2017/2021</option>
                                <option value="20171">Ganjil 2017/2021</option>

                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg 3">
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
                        <div class="col-12 col-md-6 col-lg 3">
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
                        <div class="col-12 col-md-6 col-lg 3" id="form-prodi">
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
                        <h3 style="color:aliceblue">Total data</h3>
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
                <h1 style="font-weight: 600;">Angkatan</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Angkatan</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Angkatan</th>
                                        <th scope="col">Laki-Laki</th>
                                        <th scope="col">Perempuan</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="angkatan">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Angkatan</h4>
                        </div>
                        <div class="card-body" id="id_chart_2">
                            <canvas id="angkatan_chart" style="height:65vh; width:80vw"></canvas>
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
                <h1 style="font-weight: 600;">Jalur Masuk</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Jalur Masuk</h4>
                        </div>
                        <div class="card-body" id="id_chart_3">
                            <canvas id="jalur_chart" style="height:30vh;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jalur Masuk</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Jalur</th>
                                        <th scope="col">Laki-Laki</th>
                                        <th scope="col">Perempuan</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="jalurmasuk">

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
                <h1 style="font-weight: 600;">Jenis Kelamin</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jenis Kelamin</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Laki-Laki</th>
                                        <th scope="col">Perempuan</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="kelamin">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Jenis Kelamin</h4>
                        </div>
                        <div class="card-body" id="id_chart_4">
                            <canvas id="kelamin_chart" style="height:40vh;"></canvas>
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
                <h1 style="font-weight: 600;">IPK</h1>
            </div>
            <div class="row mt-5">

                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik IPK</h4>
                        </div>
                        <div class="card-body" id="id_chart_5">
                            <canvas id="ipk_chart" style="height:40vh;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Indeks Prestasi Kumulatif</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Kategori IPK</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="ipk">

                                </tbody>
                            </table>
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
            $('#angkatan').empty();
            $('#jalurmasuk').empty();
            $('#kelamin').empty();
            $('#ipk').empty();
            $('#chart_utama').append('<canvas id="myChart"></canvas>');
            $('#id_chart_2').empty();
            $('#id_chart_3').empty();
            $('#id_chart_4').empty();
            $('#id_chart_5').empty();
            $('#id_chart_2').append('<canvas id="angkatan_chart" style="height:65vh; width:80vw"></canvas>');
            $('#id_chart_3').append('<canvas id="jalur_chart" style="height:30vh;"></canvas>');
            $('#id_chart_4').append('<canvas id="kelamin_chart" style="height:40vh;"></canvas>');
            $('#id_chart_5').append('<canvas id="ipk_chart" style="height:40vh;"></canvas>');

            var status = $("select[name=status]").val();
            var tahun = $("select[name=tahun]").val();
            var jenjang = $("select[name=jenjang]").val();
            var fakultas = $("select[name=fakultas]").val();
            var prodi = $("select[name=prodi]").val();
            var token = $("input[name=_token]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('get_mahasiswa_aktif') }}",
                data: {
                    status: status,
                    prodi: prodi,
                    fakultas: fakultas,
                    jenjang: jenjang,
                    tahun: tahun,
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

            let data = e.data;
            let chart = e.chart;

            //Tampilkan Chart
            tampilkan_chart(chart.label, chart.value, chart.total);
            tampilkan_chart_pertama(data.tahun_masuk.chart.label, data.tahun_masuk.chart.value);
            tampilkan_chart_kedua(data.jalur_masuk.chart.label, data.jalur_masuk.chart.value);
            tampilkan_chart_ketiga(data.jenis_kelamin.chart.label, data.jenis_kelamin.chart.value);
            tampilkan_chart_keempat(data.ipk.chart.label, data.ipk.chart.value);
    

            for (let i = 0; i < data.tahun_masuk.tabel.length; i++) {
                const e = data.tahun_masuk.tabel[i];
                $('#angkatan').append('<tr><td>' + e.tahun + '</td><td>' + e.pria + '</td><td>' + e.wanita +
                '</td><td>' + e.total + '</td></tr>');
            }

            for (let i = 0; i < data.jalur_masuk.tabel.length; i++) {
                const e = data.jalur_masuk.tabel[i];
                $('#jalurmasuk').append('<tr><td style="text-transform: uppercase;">' + e.jalur +
                '</td><td>' + e.cowo + '</td><td>' + e.cewe + '</td><td>' + e.total + '</td></tr>');
                
            }

            for (let i = 0; i < data.jenis_kelamin.tabel.length; i++) {
                const e = data.jenis_kelamin.tabel[i];
                $('#kelamin').append('<tr><td>' + e.unit + '</td><td>' + e.pria + '</td><td>' + e.wanita + '</td><td>' + e.total + '</td></tr>');
            }

            let ipks = data.ipk.tabel;
            $('#ipk').append('<tr><td>0.00 - 2.00</td><td>' + ipks[0] + '</td></tr>');
            $('#ipk').append('<tr><td>2.01 - 2.50</td><td>' + ipks[1] + '</td></tr>');
            $('#ipk').append('<tr><td>2.51 - 3.00</td><td>' + ipks[2] + '</td></tr>');
            $('#ipk').append('<tr><td>3.01 - 3.50</td><td>' + ipks[3] + '</td></tr>');
            $('#ipk').append('<tr><td>3.51 - 4.00</td><td>' + ipks[4] + '</td></tr>');

        }

    </script>

    <script src="{{ asset('assets/javascript/mahasiswa/chart.js') }}"></script>
@endsection
