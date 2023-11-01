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
                    <h1 style="color:aliceblue">Mahasiswa Bidikmisi</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Menampilkan mahasiswa penerima beasiswa Bidikmisi.
                    </p>

                </div>
                <form>
                    @csrf
                    <div class="row mt-4">
                        <div class="col-12 col-md-4">
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
                        <div class="col-12 col-md-4">
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
                        <div class="col-12 col-md-4" id="form-prodi">
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

    <section class="text-dark" style="background-color: #f2f7ff;padding-top:4rem;">
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
                                            <th>Unit</th>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Angkatan</th>
                                            <th>Kelamin</th>
                                            <th>Jalur</th>
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
            $('#jalurmasuk').empty();
            $('#kelamin').empty();
            $('#datatabular').empty();
            $('#chart_utama').append('<canvas id="myChart"></canvas>');
            $('#id_chart_3').empty();
            $('#id_chart_4').empty();
            $('#id_chart_3').append('<canvas id="jalur_chart" style="height:30vh;"></canvas>');
            $('#id_chart_4').append('<canvas id="kelamin_chart" style="height:40vh;"></canvas>');

            var jenjang = $("select[name=jenjang]").val();
            var fakultas = $("select[name=fakultas]").val();
            var prodi = $("select[name=prodi]").val();
            var token = $("input[name=_token]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('mahasiswa_bidikmisi_get') }}",
                data: {
                    prodi: prodi,
                    fakultas: fakultas,
                    jenjang: jenjang,
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
            let label = [];
            let dataset = [];
            var totalstatus = 0;
            let label_jalur = [];
            let dataset_jalur = [];
            let dataset_kelamin = [];


            if (b == 0) {

                for (let i = 0; i < m.length; i++) {
                    const fak = m[i].name;
                    label.push(fak);
                    dataset.push(m[i].total_mahasiswa);
                    totalstatus += m[i].total_mahasiswa;
                }

                //Chart dan Tabel 2 Jalur masuk
                add_tabel_jalur_masuk(s.jalur_masuk);
                label_jalur.push((s.jalur_masuk.snmptn.jalur).toUpperCase());
                label_jalur.push((s.jalur_masuk.sbmptn.jalur).toUpperCase());
                label_jalur.push((s.jalur_masuk.smmptn.jalur).toUpperCase());
                label_jalur.push((s.jalur_masuk.lainnya.jalur).toUpperCase());
                dataset_jalur.push(s.jalur_masuk.snmptn.total);
                dataset_jalur.push(s.jalur_masuk.sbmptn.total);
                dataset_jalur.push(s.jalur_masuk.smmptn.total);
                dataset_jalur.push(s.jalur_masuk.lainnya.total);

                //Chart dan Tabel Kelamin
                for (let i = 0; i < m.length; i++) {
                    const fc = m[i];
                    $('#kelamin').append('<tr><td>' + fc.name + '</td><td>' + fc.jenis_kelamin.pria + '</td><td>' + fc
                        .jenis_kelamin.wanita + '</td><td>' + fc.jenis_kelamin.total + '</td></tr>');
                }
                dataset_kelamin.push(s.jenis_kelamin.pria);
                dataset_kelamin.push(s.jenis_kelamin.wanita);

            } else {

                let n = m[0].prodi;
                let fak = m[0];
                let prodi_terpilih = [];

                var prodi = document.querySelector('#prodi').value;

                if (prodi != '') {
                    for (let i = 0; i < n.length; i++) {
                        const element = n[i];
                        if (element.id == prodi) {
                            prodi_terpilih.push(element);
                        }
                    }
                    n = prodi_terpilih;

                    //Chart dan Tabel Jalur Masuk
                    add_tabel_jalur_masuk(n[0].jalur_masuk);
                    label_jalur.push((n[0].jalur_masuk.snmptn.jalur).toUpperCase());
                    label_jalur.push((n[0].jalur_masuk.sbmptn.jalur).toUpperCase());
                    label_jalur.push((n[0].jalur_masuk.smmptn.jalur).toUpperCase());
                    label_jalur.push((n[0].jalur_masuk.lainnya.jalur).toUpperCase());
                    dataset_jalur.push(n[0].jalur_masuk.snmptn.total);
                    dataset_jalur.push(n[0].jalur_masuk.sbmptn.total);
                    dataset_jalur.push(n[0].jalur_masuk.smmptn.total);
                    dataset_jalur.push(n[0].jalur_masuk.lainnya.total);

                    //Chart dan Tabel Jenis Kelamin
                    var pr = 0;
                    var wn = 0;
                    for (let i = 0; i < n.length; i++) {
                        const fc = n[i];
                        $('#kelamin').append('<tr><td style="text-transform:capitalize;">' + fc.nama + '</td><td>' + fc
                            .jenis_kelamin.pria +
                            '</td><td>' + fc.jenis_kelamin.wanita + '</td><td>' + fc.jenis_kelamin.total +
                            '</td></tr>');
                        pr += fc.jenis_kelamin.pria;
                        wn += fc.jenis_kelamin.wanita;
                    }
                    dataset_kelamin.push(pr);
                    dataset_kelamin.push(wn);

                }

                //chart dan total data 1
                for (let c = 0; c < n.length; c++) {
                    label.push(n[c].nama);
                    dataset.push(n[c].total_mahasiswa);
                    totalstatus += n[c].total_mahasiswa;
                }

                //chart dan tabel 3 Jalurmasuk
                if (prodi == '') {
                    add_tabel_jalur_masuk(fak.jalur_masuk);
                    label_jalur.push((fak.jalur_masuk.snmptn.jalur).toUpperCase());
                    label_jalur.push((fak.jalur_masuk.sbmptn.jalur).toUpperCase());
                    label_jalur.push((fak.jalur_masuk.smmptn.jalur).toUpperCase());
                    label_jalur.push((fak.jalur_masuk.lainnya.jalur).toUpperCase());
                    dataset_jalur.push(fak.jalur_masuk.snmptn.total);
                    dataset_jalur.push(fak.jalur_masuk.sbmptn.total);
                    dataset_jalur.push(fak.jalur_masuk.smmptn.total);
                    dataset_jalur.push(fak.jalur_masuk.lainnya.total);
                }

                if (prodi == '') {
                    //Chart dan Tabel Jenis Kelamin
                    var pr = 0;
                    var wn = 0;
                    for (let i = 0; i < n.length; i++) {
                        const fc = n[i];
                        $('#kelamin').append('<tr><td style="text-transform:capitalize;">' + fc.nama + '</td><td>' + fc
                            .jenis_kelamin.pria +
                            '</td><td>' + fc.jenis_kelamin.wanita + '</td><td>' + fc.jenis_kelamin.total +
                            '</td></tr>');
                        pr += fc.jenis_kelamin.pria;
                        wn += fc.jenis_kelamin.wanita;
                    }
                    dataset_kelamin.push(pr);
                    dataset_kelamin.push(wn);
                }

            }

            //Data Tabular
            for (let i = 0; i < m.length; i++) {
                const t = m[i].prodi;

                for (let x = 0; x < t.length; x++) {
                    const r = t[x].mahasiswa;

                    for (let y = 0; y < r.length; y++) {
                        const z = r[y];

                        var gender = '';
                        if (z.kelamin == 0) {
                            gender = 'PR';
                        } else if (z.kelamin == 1) {
                            gender = 'LK';
                        }


                        var html = '<tr><td>' + m[i].singkatan + '</td><td style="text-transform:uppercase">' + z.nama +
                            '</td><td>' + z.nim + '</td><td>' + z.tahun_masuk + '</td><td>' + gender +
                            '</td><td style="text-transform:uppercase">' + z.jalur_masuk + '</td></tr>';

                        $('#datatabular').append(html);
                    }
                }

            }

            $(document).ready(function() {
                $.fn.dataTable.ext.errMode = 'none'; //ignore error pop up
                $('#tabel_tabular').DataTable(); //show data tabel 
            });

            //menampilkan total data
            tampilkan_chart(dataset, label, totalstatus);
            tampilkan_chart_kedua(label_jalur, dataset_jalur);
            tampilkan_chart_ketiga(dataset_kelamin);
        }

        function add_tabel_jalur_masuk(e) {
            $('#jalurmasuk').append('<tr><td style="text-transform: uppercase;">' + e.snmptn.jalur +
                '</td><td>' + e.snmptn.cowo + '</td><td>' + e.snmptn.cewe + '</td><td>' + e.snmptn.total + '</td></tr>');
            $('#jalurmasuk').append('<tr><td style="text-transform: uppercase;">' + e.sbmptn.jalur +
                '</td><td>' + e.sbmptn.cowo + '</td><td>' + e.sbmptn.cewe + '</td><td>' + e.sbmptn.total + '</td></tr>');
            $('#jalurmasuk').append('<tr><td style="text-transform: uppercase;">' + e.smmptn.jalur +
                '</td><td>' + e.smmptn.cowo + '</td><td>' + e.smmptn.cewe + '</td><td>' + e.smmptn.total + '</td></tr>');
            $('#jalurmasuk').append('<tr><td style="text-transform: uppercase;">' + e.lainnya.jalur +
                '</td><td>' + e.lainnya.cowo + '</td><td>' + e.lainnya.cewe + '</td><td>' + e.lainnya.total +
                '</td></tr>');
        }
    </script>

    <script src="{{ asset('assets/javascript/mahasiswa/chart_mahasiswa_bidikmisi.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
