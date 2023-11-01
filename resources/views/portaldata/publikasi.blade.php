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
                    <h1 style="color:aliceblue">Data Publikasi</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Menampilkan daftar publikasi yang telah terbit.
                    </p>

                </div>
                <form>
                    @csrf
                    <div class="row mt-4">
                        <div class="col-12">
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
                <h1 style="font-weight: 600;">Tahun Terbit</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tahun Terbit</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Tahun Terbit</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="tahun">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Tahun Terbit</h4>
                        </div>
                        <div class="card-body" id="tahun_chart">
                            <canvas id="canvas_tahun_chart" style="height:65vh; width:80vw"></canvas>
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
                <h1 style="font-weight: 600;">Kategori Publikasi</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Kategori</h4>
                        </div>
                        <div class="card-body" id="kategori_chart">
                            <canvas id="canvas_kategori_chart" style="height:30vh;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Kategori</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Jurnal</th>
                                        <th scope="col">Seminar</th>
                                        <th scope="col">Media</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="kategori">

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
                <h1 style="font-weight: 600;">Jenis Publikasi</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Jenis</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Jenis Publikasi</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="jenis">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Jenis Publikasi</h4>
                        </div>
                        <div class="card-body" id="jenis_chart">
                            <canvas id="canvas_jenis_chart" style="height:50vh"></canvas>
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
                                            <th>Unit</th>
                                            <th>Judul Publikasi</th>
                                            <th>Tahun</th>
                                            <th>Penulis Pertama</th>
                                            <th>Anggota</th>
                                            <th>Kategori</th>
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
            getData();
        });

        //Fungsi untuk meload data berdasarkan fakultas yang di pilih
        function selectFakultas() {
            getData();
        }

        //AJAX Untuk mendapatkan data
        function getData() {

            $('#datatabular').empty();
            $('#chart_utama').empty();

            $('#tahun').empty();
            $('#tahun_chart').empty();

            $('#kategori').empty();
            $('#kategori_chart').empty();

            $('#jenis').empty();
            $('#jenis_chart').empty();

            $('#chart_utama').append('<canvas id="myChart"></canvas>');
            $('#tahun_chart').append('<canvas id="canvas_tahun_chart" style="height:65vh; width:80vw"></canvas>');
            $('#kategori_chart').append('<canvas id="canvas_kategori_chart" style="height:30vh;"></canvas>');
            $('#jenis_chart').append('<canvas id="canvas_jenis_chart" style="height:50vh"></canvas>');

            var fakultas = $("select[name=fakultas]").val();
            var token = $("input[name=_token]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('publikasi_get') }}",
                data: {
                    fakultas: fakultas,
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

            let s = e.status;
            let m = e.data;

            if (b != 0) {
                s = m[0];
            }

            let label = [];
            let dataset = [];

            let label_tahun = [];
            let dataset_tahun = [];

            let label_kategori = [];
            let dataset_kategori = [];

            let label_jenis = [];
            let dataset_jenis = [];

            var totalstatus = 0;

            //Mengelola Chart Utama
            for (let i = 0; i < m.length; i++) {
                const fakultas = m[i].name;
                label.push(fakultas);
                dataset.push(m[i].total_publikasi);
                totalstatus += m[i].total_publikasi;
            }

            //Mengelola Tahun
            const keysArray = Object.keys(s.tahun);
            for (let i = 0; i < keysArray.length; i++) {
                const e = keysArray[i];
                $('#tahun').append(`
                    <tr>
                    <td>${e}</td>
                    <td>${s.tahun[e]}</td>
                    </tr>
                `);
                label_tahun.push(e);
                dataset_tahun.push(s.tahun[e]);
            }

            //Mengelola Kategori
            var var_temp = [];
            if (b == 0) {
                var_temp.push(...m);
            } else {
                var_temp.push(...m[0].prodi);
            }

            for (let i = 0; i < var_temp.length; i++) {
                const fc = var_temp[i];
                var name = '';
                if (b == 0) {
                    name = fc.name;
                } else {
                    name = fc.nama;
                }
                var totals = fc.kategori.a.jumlah + fc.kategori.b.jumlah + fc.kategori.c.jumlah;
                $('#kategori').append('<tr><td style="text-transform:capitalize;">' + name + '</td><td>' + fc.kategori.a
                    .jumlah + '</td><td>' + fc.kategori.b
                    .jumlah + '</td><td>' + fc.kategori.c.jumlah + '</td><td>' + totals + '</td></tr>');
            }
            var kat = ['a', 'b', 'c'];
            for (let i = 0; i < kat.length; i++) {
                const e = kat[i];
                label_kategori.push(s.kategori[e].nama);
                dataset_kategori.push(s.kategori[e].jumlah);
            }

            //Mengelola Jenis Publikasi
            const keys_jenis = Object.keys(s.jenis);
            for (let i = 0; i < keys_jenis.length; i++) {
                const e = keys_jenis[i];
                $('#jenis').append(`
                    <tr>
                    <td>${s.jenis[e].nama}</td>
                    <td>${s.jenis[e].jumlah}</td>
                    </tr>
                `);
                label_jenis.push(s.jenis[e].nama);
                dataset_jenis.push(s.jenis[e].jumlah);
            }

            //Data Tabular
            for (let i = 0; i < m.length; i++) {
                const t = m[i].prodi;

                for (let x = 0; x < t.length; x++) {
                    const r = t[x].publikasi;

                    for (let y = 0; y < r.length; y++) {
                        const z = r[y];

                        let anggota = JSON.parse(z.anggota);

                        let daftarAnggota = '';

                        anggota.forEach(function(item) {
                            daftarAnggota += '<li>' + item.dosen + '</li>';
                        });

                        var html = '<tr><td style="text-transform:capitalize">' + t[x].nama +
                            '</td><td style="text-transform:capitalize">' + z.judul +
                            '</td><td>' + z.tahun + '</td><td>' + z.penulis_dosen + '</td><td>' + daftarAnggota +
                            '</td><td style="text-transform:capitalize">' + z.jenis +
                            '</td><td style="text-transform:capitalize">' + z.sub_jenis +
                            '</td></tr>';

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
            chart_tahun(label_tahun, dataset_tahun);
            chart_kategori(label_kategori, dataset_kategori);
            chart_jenis(label_jenis, dataset_jenis);

        }
    </script>

    <script src="{{ asset('assets/javascript/dosen/chart_publikasi.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
