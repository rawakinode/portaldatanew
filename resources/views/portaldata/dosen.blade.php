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
                    <h1 style="color:aliceblue">Data Dosen</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Dosen tetap adalah dosen yang memiliki NIDN / NIDK.
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
                        <div class="card-body" id="kelamin_chart">
                            <canvas id="canvas_kelamin_chart" style="height:40vh;"></canvas>
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
                <h1 style="font-weight: 600;">Pendidikan Terakhir</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Pendidikan</h4>
                        </div>
                        <div class="card-body" id="pendidikan_chart">
                            <canvas id="canvas_pendidikan_chart" style="height:30vh;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pendidikan</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Pendidikan</th>
                                        <th scope="col">Laki-Laki</th>
                                        <th scope="col">Perempuan</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="pendidikan">

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
                <h1 style="font-weight: 600;">Jabatan Fungsional</h1>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Fungsional</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col">Laki-Laki</th>
                                        <th scope="col">Perempuan</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="fungsional">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Fungsional</h4>
                        </div>
                        <div class="card-body" id="fungsional_chart">
                            <canvas id="canvas_fungsional_chart" style="height:65vh; width:80vw"></canvas>
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
                <h1 style="font-weight: 600;">Golongan</h1>
            </div>
            <div class="row mt-5">

                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Golongan</h4>
                        </div>
                        <div class="card-body" id="golongan_chart">
                            <canvas id="canvas_golongan_chart" style="height:40vh;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Golongan</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #e7ecff">
                                    <tr>
                                        <th scope="col">Golongan</th>
                                        <th scope="col">Laki-laki</th>
                                        <th scope="col">Perempuan</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="golongan">

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
                                            <th>NIDN</th>
                                            <th>Kelamin</th>
                                            <th>Pendidikan</th>
                                            <th>Golongan</th>
                                            <th>Fungsional</th>
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

            $('#pendidikan').empty();
            $('#pendidikan_chart').empty();

            $('#kelamin').empty();
            $('#kelamin_chart').empty();

            $('#fungsional').empty();
            $('#fungsional_chart').empty();

            $('#golongan').empty();
            $('#golongan_chart').empty();

            $('#chart_utama').append('<canvas id="myChart"></canvas>');
            $('#pendidikan_chart').append('<canvas id="canvas_pendidikan_chart" style="height:30vh;"></canvas>');
            $('#kelamin_chart').append('<canvas id="canvas_kelamin_chart" style="height:40vh;"></canvas>');
            $('#fungsional_chart').append('<canvas id="canvas_fungsional_chart" style="height:65vh; width:80vw"></canvas>');
            $('#golongan_chart').append('<canvas id="canvas_golongan_chart" style="height:40vh;"></canvas>');

            var fakultas = $("select[name=fakultas]").val();
            var token = $("input[name=_token]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('dosen_get') }}",
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

            let label_kelamin = ['Laki-laki', 'Perempuan'];
            let dataset_kelamin = [];

            let label_pendidikan = ['S1', 'S2', 'S3'];
            let dataset_pendidikan = [];

            let label_fungsional = [];
            let dataset_fungsional = [];

            let label_golongan = [];
            let dataset_golongan = [];

            var totalstatus = 0;

            //Mengelola Chart Utama
            for (let i = 0; i < m.length; i++) {
                const fakultas = m[i].name;
                label.push(fakultas);
                dataset.push(m[i].total_dosen);
                totalstatus += m[i].total_dosen;
            }

            //Mengelola Jenis Kelamin
            for (let i = 0; i < m.length; i++) {
                const fc = m[i];
                $('#kelamin').append('<tr><td>' + fc.name + '</td><td>' + fc.jenis_kelamin.pria + '</td><td>' + fc
                    .jenis_kelamin.wanita + '</td><td>' + fc.jenis_kelamin.total + '</td></tr>');
            }
            dataset_kelamin.push(s.jenis_kelamin.pria);
            dataset_kelamin.push(s.jenis_kelamin.wanita);

            //Mengelola Pendidikan
            const levels = ['S1', 'S2', 'S3'];

            for (let i = 0; i < levels.length; i++) {
                const level = levels[i];
                $('#pendidikan').append(`
                <tr>
                  <td>${level}</td>
                  <td>${s.pendidikan[level].pria}</td>
                  <td>${s.pendidikan[level].wanita}</td>
                  <td>${s.pendidikan[level].total}</td>
                </tr>
              `);
            }
            dataset_pendidikan.push(s.pendidikan.S1.total);
            dataset_pendidikan.push(s.pendidikan.S2.total);
            dataset_pendidikan.push(s.pendidikan.S3.total);

            //Mengelola Fungsional
            const fungsionals = ['tenaga_pengajar', 'asisten_ahli', 'lektor', 'lektor_kepala', 'guru_besar'];
            for (let i = 0; i < fungsionals.length; i++) {
                const value = fungsionals[i];
                $('#fungsional').append(`
                <tr>
                  <td>${s.fungsional[value].nama}</td>
                  <td>${s.fungsional[value].pria}</td>
                  <td>${s.fungsional[value].wanita}</td>
                  <td>${s.fungsional[value].total}</td>
                </tr>
              `);
                label_fungsional.push(s.fungsional[value].nama);
                dataset_fungsional.push(s.fungsional[value].total);
            }

            //Mengelola Golongan
            var golongans = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm'];
            for (let i = 0; i < golongans.length; i++) {
                const value = golongans[i];
                $('#golongan').append(`
                <tr>
                  <td>${s.golongan[value].nama}</td>
                  <td>${s.golongan[value].pria}</td>
                  <td>${s.golongan[value].wanita}</td>
                  <td>${s.golongan[value].total}</td>
                </tr>
              `);
                label_golongan.push(s.golongan[value].nama);
                dataset_golongan.push(s.golongan[value].total);
            }

            //Data Tabular
            for (let i = 0; i < m.length; i++) {
                const t = m[i].prodi;

                for (let x = 0; x < t.length; x++) {
                    const r = t[x].dosen_homebase;

                    for (let y = 0; y < r.length; y++) {
                        const z = r[y];

                        var gender = '';
                        if (z.kelamin == 0) {
                            gender = 'LK';
                        } else if (z.kelamin == 1) {
                            gender = 'PR';
                        }

                        var pnddkn = '';
                        if (z.pendidikan == 1) {
                            pnddkn = 'S1';
                        } else if (z.pendidikan == 2) {
                            pnddkn = 'S2';
                        } else if (z.pendidikan == 3) {
                            pnddkn = 'S3';
                        }

                        var fung = '';
                        if (z.fungsional == 1) {
                            fung = 'Asisten Ahli';
                        } else if (z.fungsional == 2) {
                            fung = 'Lektor';
                        } else if (z.fungsional == 3) {
                            fung = 'Lektor Kepala';
                        } else if (z.fungsional == 4) {
                            fung = 'Guru Besar';
                        } else if (z.fungsional == 5) {
                            fung = 'Tenaga Pengajar';
                        }

                        var html = '<tr><td>' + m[i].singkatan + '</td><td style="text-transform:uppercase">' + z.nama +
                            '</td><td>' + z.nidn + '</td><td>' + gender + '</td><td>' + pnddkn +
                            '</td><td style="text-transform:uppercase">' + z.golongan + '</td><td>' + fung +
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
            chart_fungsional(label_fungsional, dataset_fungsional);
            chart_pendidikan(label_pendidikan, dataset_pendidikan);
            chart_jenis_kelamin(label_kelamin, dataset_kelamin);
            chart_golongan(label_golongan, dataset_golongan);
        }
    </script>

    <script src="{{ asset('assets/javascript/dosen/chart.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
