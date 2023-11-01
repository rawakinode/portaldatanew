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
                    <h1 style="color:aliceblue">Data Kerjasama</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Menampilkan daftar kerjasama Program Studi.
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
                <h1 style="font-weight: 600;">Tahun Kerjasama</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tahun Kerjasama</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Tahun Kerjasama</th>
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
                            <h4>Grafik Tahun Kerjasama</h4>
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
                <h1 style="font-weight: 600;">Bidang</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Bidang</h4>
                        </div>
                        <div class="card-body" id="bidang_chart">
                            <canvas id="canvas_bidang_chart" style="height:30vh;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Bidang</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Bidang</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="bidang">

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
                <h1 style="font-weight: 600;">Tingkat</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Tingkat</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Tingkat</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="tingkat">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Tingkat</h4>
                        </div>
                        <div class="card-body" id="tingkat_chart">
                            <canvas id="canvas_tingkat_chart" style="height:50vh"></canvas>
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
                                            <th>Mitra Kerjasama</th>
                                            <th>Tahun</th>
                                            <th>Bidang</th>
                                            <th>Tingkat</th>
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

            $('#bidang').empty();
            $('#bidang_chart').empty();

            $('#tingkat').empty();
            $('#tingkat_chart').empty();

            $('#chart_utama').append('<canvas id="myChart"></canvas>');
            $('#tahun_chart').append('<canvas id="canvas_tahun_chart" style="height:65vh; width:80vw"></canvas>');
            $('#bidang_chart').append('<canvas id="canvas_bidang_chart" style="height:30vh;"></canvas>');
            $('#tingkat_chart').append('<canvas id="canvas_tingkat_chart" style="height:50vh"></canvas>');

            var fakultas = $("select[name=fakultas]").val();
            var token = $("input[name=_token]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('kerjasama_get') }}",
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

            let label_bidang = [];
            let dataset_bidang = [];

            let label_tingkat = [];
            let dataset_tingkat = [];

            var totalstatus = 0;

            //Mengelola Chart Utama
            for (let i = 0; i < m.length; i++) {
                const fakultas = m[i].name;
                label.push(fakultas);
                dataset.push(m[i].total_kerjasama);
                totalstatus += m[i].total_kerjasama;
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


            //Mengelola Jenis Bidang
            const keys_bidang = Object.keys(s.bidang);
            for (let i = 0; i < keys_bidang.length; i++) {
                const e = keys_bidang[i];
                $('#bidang').append(`
                <tr>
                <td>${s.bidang[e].nama}</td>
                <td>${s.bidang[e].jumlah}</td>
                </tr>
            `);
                label_bidang.push(s.bidang[e].nama);
                dataset_bidang.push(s.bidang[e].jumlah);
            }

            //Mengelola Tingkat
            const keys_tingkat = Object.keys(s.tingkat);
            for (let i = 0; i < keys_tingkat.length; i++) {
                const e = keys_tingkat[i];
                $('#tingkat').append(`
                <tr>
                <td>${s.tingkat[e].nama}</td>
                <td>${s.tingkat[e].jumlah}</td>
                </tr>
            `);
                label_tingkat.push(s.tingkat[e].nama);
                dataset_tingkat.push(s.tingkat[e].jumlah);
            }

            //Data Tabular
            for (let i = 0; i < m.length; i++) {
                const t = m[i].prodi;

                for (let x = 0; x < t.length; x++) {
                    const r = t[x].kerjasama;

                    for (let y = 0; y < r.length; y++) {
                        const z = r[y];

                        var html = '<tr><td style="text-transform:capitalize">' + t[x].nama +
                            '</td><td style="text-transform:capitalize">' + z.nama +
                            '</td><td>' + z.tahun + '</td><td style="text-transform:capitalize">' + z.bidang + '</td><td style="text-transform:capitalize">' + z.tingkat +
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
            chart_bidang(label_bidang, dataset_bidang);
            chart_tingkat(label_tingkat, dataset_tingkat);

        }
    </script>

    <script src="{{ asset('assets/javascript/dosen/chart_kerjasama.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
