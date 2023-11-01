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
                    <h1 style="color:aliceblue">Data Penelitian</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Menampilkan daftar penelitian yang telah dilaksanakan.
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
                <h1 style="font-weight: 600;">Tahun Penelitian</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tahun Penelitian</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Tahun Penelitian</th>
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
                            <h4>Grafik Tahun Penelitian</h4>
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
                <h1 style="font-weight: 600;">Sumber Dana</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Sumber Dana</h4>
                        </div>
                        <div class="card-body" id="sumberdana_chart">
                            <canvas id="canvas_sumberdana_chart" style="height:30vh;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Sumber Dana</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Sumber Dana</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="sumberdana">

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
                <h1 style="font-weight: 600;">Jumlah Dana</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Jumlah Dana</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Jenis Publikasi</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="jumlahdana">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Jumlah Dana</h4>
                        </div>
                        <div class="card-body" id="jumlahdana_chart">
                            <canvas id="canvas_jumlahdana_chart" style="height:50vh"></canvas>
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
                                            <th>Judul Penelitian</th>
                                            <th>Tahun</th>
                                            <th>Dosen Pelaksana</th>
                                            <th>Mahasiswa</th>
                                            <th>Sumber Dana</th>
                                            <th>Jumlah Dana</th>
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

            $('#sumberdana').empty();
            $('#sumberdana_chart').empty();

            $('#jumlahdana').empty();
            $('#jumlahdana_chart').empty();

            $('#chart_utama').append('<canvas id="myChart"></canvas>');
            $('#tahun_chart').append('<canvas id="canvas_tahun_chart" style="height:65vh; width:80vw"></canvas>');
            $('#sumberdana_chart').append('<canvas id="canvas_sumberdana_chart" style="height:30vh;"></canvas>');
            $('#jumlahdana_chart').append('<canvas id="canvas_jumlahdana_chart" style="height:50vh"></canvas>');

            var fakultas = $("select[name=fakultas]").val();
            var token = $("input[name=_token]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('penelitian_get') }}",
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

            let label_sumberdana = [];
            let dataset_sumberdana = [];

            let label_jumlahdana = [];
            let dataset_jumlahdana = [];

            var totalstatus = 0;

            //Mengelola Chart Utama
            for (let i = 0; i < m.length; i++) {
                const fakultas = m[i].name;
                label.push(fakultas);
                dataset.push(m[i].total_penelitian);
                totalstatus += m[i].total_penelitian;
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


            //Mengelola Jenis Sumber Dana
            const keys_sumberdana = Object.keys(s.sumber_dana);
            for (let i = 0; i < keys_sumberdana.length; i++) {
                const e = keys_sumberdana[i];
                $('#sumberdana').append(`
                <tr>
                <td>${s.sumber_dana[e].nama}</td>
                <td>${s.sumber_dana[e].jumlah}</td>
                </tr>
            `);
                label_sumberdana.push(s.sumber_dana[e].nama);
                dataset_sumberdana.push(s.sumber_dana[e].jumlah);
            }

            //Mengelola Jenis Jumlah Dana
            const keys_jumlahdana = Object.keys(s.jumlah_dana);
            for (let i = 0; i < keys_jumlahdana.length; i++) {
                const e = keys_jumlahdana[i];
                $('#jumlahdana').append(`
                <tr>
                <td>${s.jumlah_dana[e].nama}</td>
                <td>${s.jumlah_dana[e].jumlah}</td>
                </tr>
            `);
                label_jumlahdana.push(s.jumlah_dana[e].nama);
                dataset_jumlahdana.push(s.jumlah_dana[e].jumlah);
            }

            //Data Tabular
            for (let i = 0; i < m.length; i++) {
                const t = m[i].prodi;

                for (let x = 0; x < t.length; x++) {
                    const r = t[x].penelitian;

                    for (let y = 0; y < r.length; y++) {
                        const z = r[y];

                        let dosen = JSON.parse(z.dosen);
                        let mahasiswa = JSON.parse(z.mahasiswa);

                        let dosen_list = '';
                        let mahasiswa_list = '';

                        if (mahasiswa != null) {
                            mahasiswa.forEach(function(item) {
                                mahasiswa_list += '<li>' + item.mahasiswa + '</li>';
                            });
                        }

                        if (dosen != null) {
                            dosen.forEach(function(item) {
                                dosen_list += '<li>' + item.dosen + '</li>';
                            });
                        }

                        var html = '<tr><td style="text-transform:capitalize">' + t[x].nama +
                            '</td><td style="text-transform:capitalize">' + z.judul +
                            '</td><td>' + z.tahun + '</td><td>' + dosen_list + '</td><td>' + mahasiswa_list +
                            '</td><td style="text-transform:capitalize">' + z.sumber_dana +
                            '</td><td style="text-transform:capitalize">' + z.jumlah_dana +
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
            chart_sumberdana(label_sumberdana, dataset_sumberdana);
            chart_jumlahdana(label_jumlahdana, dataset_jumlahdana);

        }
    </script>

    <script src="{{ asset('assets/javascript/dosen/chart_penelitian.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
