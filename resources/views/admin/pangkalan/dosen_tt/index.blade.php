@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Dosen Tidak Tetap</h3>
            <p class="text-subtitle text-muted">Menampilkan daftar dosen tidak tetap program studi.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Portal data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dosen Tidak Tetap</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--INCLUDE -->
    @include('trait._error')
    @include('trait._success')

    @csrf

    {{-- menampilkan tabel dosen --}}
    <div class="card" id="card_dosen_tetap">
        
        <div class="card-body">
            <h5>Daftar</h5>
            <button onclick="tampilkan_create()" class="btn btn-primary" style="position: absolute;top:15px;right:15px">Tambah</button>
            <div class="table-responsive text-wrap" style="margin-top: 1rem">
                <table class="table table-striped" id="datatabel">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">Aksi</th>
                            <th>Nama & NIDN/NIDK</th>
                            <th>Pendidikan</th>
                            <th>Kelamin</th>
                            <th>Jab. Akademik</th>
                            <th>Golongan</th>
                            <th>Bidang Keahlian</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="tabeldosen">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" id="card_edit" style="display: none">
        <h5 class="card-header" id="card_header_create">Edit</h5>
        <div class="card-body" id="data_edit">

        </div>

        <div class="card-footer">
            <button onclick="kembali()" class="btn btn-danger">Kembali</button>
            <span id="button_send"></span>
        </div>
    </div>

    <script>
        document.addEventListener("click", function() {
            $('#list_prodi').css('display', 'none');
        });

        var token = $("input[name=_token]").val();

        getDataDosen();

        //Mengambil data tabel dosen tetap prodi
        async function getDataDosen() {
            try {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('dosen_tt_table_get') }}',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {

                            let dosen = data;
                            let tbody_all = '';

                            for (let i = 0; i < dosen.length; i++) {
                                const e = dosen[i];

                                let ds_pendidikan =
                                    (e.pendidikan == 1) ? 'S1' :
                                    (e.pendidikan == 2) ? 'S2' :
                                    (e.pendidikan == 3) ? 'S3' :
                                    (e.pendidikan == 4) ? 'PROFESI' : '';

                                let ds_kelamin =
                                    (e.kelamin == 0) ? 'LK' :
                                    (e.kelamin == 1) ? 'PR' : '';

                                let ds_fungsional =
                                    (e.fungsional === 1) ? "Asisten Ahli" :
                                    (e.fungsional === 2) ? "Lektor" :
                                    (e.fungsional === 3) ? "Lektor Kepala" :
                                    (e.fungsional === 4) ? "Guru Besar" :
                                    (e.fungsional === 5) ? "Tenaga Pengajar" : "";

                                let ds_golongan = (e.golongan != null) ? e.golongan : '';
                                let ds_bidang_keahlian = (e.bidang_keahlian != null) ?e.bidang_keahlian : '';

                                let tbody_data = `
                                    <tr>
                                        <td width="100">
                                            <div class="d-flex text-nowrap">
                                               <button type="button" onclick="tampilkan_edit(${e.id})"
                                                    class="btn btn-sm btn-icon btn-primary" style="margin-left: 5px"><i
                                                        class="bi bi-pencil-fill"></i></button>
                                                <button style="margin-left: 5px" type="submit" class="btn btn-sm btn-icon btn-danger" onclick="deleteDataDosen(${e.id})"><i class="bi bi-trash"></i></button>

                                            </div>
                                        </td>
                                        <td style="padding-left: 10px">
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-3">
                                                        <img src="/images/no-profile-picture-icon-1.png" alt="Avatar"
                                                            class="rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold" style="text-transform:uppercase;">${e.nama}</span>
                                                    <small class="text-muted">${e.nidn}</small>
                                                    <div>
                                                    </div>
                                        </td>
                                        <td>${ds_pendidikan}</td>
                                        <td>${ds_kelamin}</td>
                                        <td>${ds_fungsional}</td>
                                        <td>${ds_golongan}</td>
                                        <td>${ds_bidang_keahlian}</td>

                                    </tr>
                                `;

                                tbody_all += tbody_data;
                            }

                            $('#tabeldosen').empty();
                            $('#tabeldosen').append(tbody_all);

                            console.log('data berhasil di append');

                        } else {
                            $('#tabeldosen').empty();
                            $('#tabeldosen').append(`
                                <tr>
                                    <td colspan="10" class="text-center">
                                        Tidak ada dosen.
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }

                });
            } catch (error) {
                alert('Gagal mengambil data dosen !');
            }
        }

        let data_prodi = [];

        //Fungsi untuk menampilkan form create / tambah
        function tampilkan_create() {
            
            document.getElementById('card_header_create').innerText = 'Tambah';
            $('#button_send').empty();
            $('#button_send').append('<button onclick="kirim_dosen()" class="btn btn-success" id="simpan_update">Simpan</button>');
            $('#card_dosen_tetap').css('display', 'none');

            $('#data_edit').empty();

            let data_create = `<div class="row">
                <div class="col-md-6">
                    <div class="form-group mandatory">
                        <label class="form-label">Nama</label>
                        <input class="form-control" type="text" id="edit_nama" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mandatory">
                        <label class="form-label">NIDN / NIDK</label>
                        <input class="form-control" type="text" id="edit_nidn" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mandatory">
                        <label class="form-label" for="kelamin">Jenis Kelamin</label>
                        <select class="form-select" name="kelamin" id="edit_kelamin">
                            <option value="">Pilih...</option>
                            <option value="0">Laki-Laki</option>
                            <option value="1">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mandatory">
                        <label class="form-label" for="pendidikan">Pendidikan Terakhir</label>
                        <select class="form-select" name="pendidikan"
                            id="edit_pendidikan">
                            <option value="">Pilih...</option>
                            <option value="1">S1</option>
                            <option value="2">S2</option>
                            <option value="3">S3</option>
                            <option value="4">Profesi
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Pasca Sarjana</label>
                        <input class="form-control" type="text" id="edit_pascasarjana">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="industri_praktisi">Dosen Industri / Praktisi</label>
                        <select class="form-select" name="industri_praktisi"
                            id="edit_industri_praktisi">
                            <option value="">Tidak</option>
                            <option value="industri">Industri</option>
                            <option value="praktisi">Praktisi</option>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Nomor Sertifikasi Pendidik Profesional (Jika Ada)</label>
                        <input class="form-control" type="text" id="edit_nomor_sertifikasi">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Nomor Sertifikasi Profesi / Industri / Kompetensi (Jika Ada)</label>
                        <input class="form-control" type="text" id="edit_nomor_sertifikasi_profesi_industri">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Jabatan Akademik</label>
                        <select class="form-select" name="fungsional" id="edit_fungsional">
                            <option value="">- Tidak Ada -</option>
                            <option value="1">Asisten Ahli</option>
                            <option value="2">Lektor</option>
                            <option value="3">Lektor Kepala</option>
                            <option value="4">Guru Besar</option>
                            <option value="5">Tenaga Pengajar</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="golongan">Golongan</label>
                        <select class="form-select" name="edit_golongan"
                            id="edit_golongan">
                            <option value="">- Tidak Ada -</option>
                            <option value="II/a">II/a</option>
                            <option value="II/b">II/b</option>
                            <option value="II/c">II/c</option>
                            <option value="II/d">II/d</option>
                            <option value="III/a">III/a</option>
                            <option value="III/b">III/b</option>
                            <option value="III/c">III/c</option>
                            <option value="III/d">III/d</option>
                            <option value="IV/a">IV/a</option>
                            <option value="IV/b">IV/b</option>
                            <option value="IV/c">IV/c</option>
                            <option value="IV/d">IV/d</option>
                            <option value="IV/e">IV/e</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="bidang_keahlian">Bidang Keahlian</label>
                        <input class="form-control" type="text"
                            name="bidang_keahlian" id="edit_bidang_keahlian">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="matakuliah_prodi">Matakuliah yang Diampu di Prodi</label>
                        <input class="form-control"
                            type="text" name="matakuliah_prodi" id="edit_matakuliah_prodi"
                            placeholder="Pisahkan dengan tanda koma dan spasi">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="matakuliah_prodi_lain">Matakuliah yang Diampu di Prodi lain</label>
                        <input class="form-control"
                            type="text" name="matakuliah_prodi_lain" id="edit_matakuliah_prodi_lain"
                            placeholder="Pisahkan dengan tanda koma dan spasi">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mandatory">
                        <label class="form-label">Kesesuaian dengan Kompetensi Inti Program Studi</label>
                        <select class="form-select" name="edit_kompetensi" id="edit_kompetensi" required>
                            <option value="1">Sesuai</option>
                            <option value="0">Tidak Sesuai</option>
                        </select>
                    </div>
                </div>
            </div>`;

            $('#data_edit').append(data_create);
            $('#card_edit').css('display', 'block');
        }

        //Setelah di pilih, lalu dosen di kirim
        async function kirim_dosen() {

            let edit_nama = document.getElementById('edit_nama').value;
            let edit_nidn = document.getElementById('edit_nidn').value;
            let edit_kelamin = document.getElementById('edit_kelamin').value;
            let edit_pendidikan = document.getElementById('edit_pendidikan').value;
            let edit_industri_praktisi = document.getElementById('edit_industri_praktisi').value;
            let edit_pascasarjana = document.getElementById('edit_pascasarjana').value;
            let edit_nomor_sertifikasi = document.getElementById('edit_nomor_sertifikasi').value;
            let edit_nomor_ser_pro = document.getElementById('edit_nomor_sertifikasi_profesi_industri').value;
            let edit_fungsional = document.getElementById('edit_fungsional').value;
            let edit_golongan = document.getElementById('edit_golongan').value;
            let edit_bidang_keahlian = document.getElementById('edit_bidang_keahlian').value;
            let edit_matakuliah_prodi = document.getElementById('edit_matakuliah_prodi').value;
            let edit_matakuliah_prodi_lain = document.getElementById('edit_matakuliah_prodi_lain').value;
            let edit_kompetensi = document.getElementById('edit_kompetensi').value;

            try {
                await $.ajax({
                    type: 'POST',
                    url: "{{ route('create_dosen_tt') }}",
                    data: {
                        nama: edit_nama,
                        nidn : edit_nidn,
                        kelamin: edit_kelamin,
                        pendidikan: edit_pendidikan,
                        pascasarjana: edit_pascasarjana,
                        industri_praktisi: edit_industri_praktisi,
                        nomor_sertifikasi: edit_nomor_sertifikasi,
                        nomor_sertifikasi_profesi_industri: edit_nomor_ser_pro,
                        fungsional: edit_fungsional,
                        golongan: edit_golongan,
                        bidang_keahlian: edit_bidang_keahlian,
                        matakuliah_prodi: edit_matakuliah_prodi,
                        matakuliah_prodi_lain: edit_matakuliah_prodi_lain,
                        kesesuaian_kompetensi: edit_kompetensi,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(data, message, response) {
                        
                        if (response.status == 200) {
                            alert(data.message);
                            tampilkan_create()
                        }else if(response.status == 400){
                            alert('Dosen sudah ada di database !');
                            tampilkan_create()
                        }else{
                            alert('Gagal melakukan pengiriman data dosen !');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status == 422) {
                            alert('Harap lengkapi / perbaiki formulir yang akan di dikirim');
                        }else if(xhr.status == 402){
                            alert('Dosen sudah ada !');
                        }else{
                            alert('Gagal melakukan pengiriman data dosen !');
                        }
                        
                    }
                });

            } catch (error) {
                alert('Server Error !');
                console.log(error);
            }
        }

        // Menampilkan Halaman Edit
        async function tampilkan_edit(p) {

            document.getElementById('card_header_create').innerText = 'Edit';
            $('#button_send').empty();
            $('#button_send').append('<button onclick="update_dosen()" class="btn btn-success" id="simpan_update">Simpan</button>');
            
            let id_for_edit = p;

            $('#card_dosen_tetap').css('display', 'none');

            try {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('edit_dosen_tt') }}",
                    data: {
                        id: id_for_edit,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(data, message, response) {
                        if (response.status == 200) {

                            let data_create = `<div class="row">
                                <input type="hidden" id="edit_id" value="${data.id}">
                                <div class="col-md-6">
                                    <div class="form-group mandatory">
                                        <label class="form-label">Nama</label>
                                        <input class="form-control" type="text" id="edit_nama" value="${data.nama}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mandatory">
                                        <label class="form-label">NIDN / NIDK</label>
                                        <input class="form-control" type="text" id="edit_nidn" value="${data.nidn}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mandatory">
                                        <label class="form-label" for="kelamin">Jenis Kelamin</label>
                                        <select class="form-select" name="kelamin" id="edit_kelamin">
                                            <option value="" ${data.kelamin == '' ? 'selected' : ''}>Pilih...</option>
                                            <option value="0" ${data.kelamin == 0 ? 'selected' : ''}>Laki-Laki</option>
                                            <option value="1" ${data.kelamin == 1 ? 'selected' : ''}>Perempuan</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mandatory">
                                        <label class="form-label" for="pendidikan">Pendidikan Terakhir</label>
                                        <select class="form-select" name="pendidikan"
                                            id="edit_pendidikan">
                                            <option value="" ${data.pendidikan == '' ? 'selected' : ''}>Pilih...</option>
                                            <option value="1" ${data.pendidikan == '1' ? 'selected' : ''}>S1</option>
                                            <option value="2" ${data.pendidikan == '2' ? 'selected' : ''}>S2</option>
                                            <option value="3" ${data.pendidikan == '3' ? 'selected' : ''}>S3</option>
                                            <option value="4" ${data.pendidikan == '4' ? 'selected' : ''}>Profesi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Pasca Sarjana</label>
                                        <input class="form-control" type="text" id="edit_pascasarjana" value="${data.pascasarjana ?? ''}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="industri_praktisi">Dosen Industri / Praktisi</label>
                                        <select class="form-select" name="industri_praktisi"
                                            id="edit_industri_praktisi">
                                            <option value="" ${data.industri_praktisi == 'null' ? 'selected' : ""}>Tidak</option>
                                            <option value="industri" ${data.industri_praktisi == 'industri' ? 'selected' : ""}>Industri</option>
                                            <option value="praktisi" ${data.industri_praktisi == 'praktisi' ? 'selected' : ""}>Praktisi</option>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nomor Sertifikasi Pendidik Profesional (Jika Ada)</label>
                                        <input class="form-control" type="text" id="edit_nomor_sertifikasi" value="${data.nomor_sertifikasi ?? ''}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nomor Sertifikasi Profesi / Industri / Kompetensi (Jika Ada)</label>
                                        <input class="form-control" type="text" id="edit_nomor_sertifikasi_profesi_industri" value="${data.nomor_sertifikasi_profesi_industri ?? ''}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Jabatan Akademik</label>
                                        <select class="form-select" name="fungsional" id="edit_fungsional">
                                            <option value="" ${data.fungsional == '' ? 'selected' : ''}>- Tidak Ada -</option>
                                            <option value="1" ${data.fungsional == '1' ? 'selected' : ''}>Asisten Ahli</option>
                                            <option value="2" ${data.fungsional == '2' ? 'selected' : ''}>Lektor</option>
                                            <option value="3" ${data.fungsional == '3' ? 'selected' : ''}>Lektor Kepala</option>
                                            <option value="4" ${data.fungsional == '4' ? 'selected' : ''}>Guru Besar</option>
                                            <option value="5" ${data.fungsional == '5' ? 'selected' : ''}>Tenaga Pengajar</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="golongan">Golongan</label>
                                        <select class="form-select" name="edit_golongan"
                                            id="edit_golongan">
                                            <option value="" ${data.edit_golongan == '' ? 'selected' : ''}>- Tidak Ada -</option>
                                            <option value="II/a" ${data.edit_golongan == 'II/a' ? 'selected' : ''}>II/a</option>
                                            <option value="II/b" ${data.edit_golongan == 'II/b' ? 'selected' : ''}>II/b</option>
                                            <option value="II/c" ${data.edit_golongan == 'II/c' ? 'selected' : ''}>II/c</option>
                                            <option value="II/d" ${data.edit_golongan == 'II/d' ? 'selected' : ''}>II/d</option>
                                            <option value="III/a" ${data.edit_golongan == 'III/a' ? 'selected' : ''}>III/a</option>
                                            <option value="III/b" ${data.edit_golongan == 'III/b' ? 'selected' : ''}>III/b</option>
                                            <option value="III/c" ${data.edit_golongan == 'III/c' ? 'selected' : ''}>III/c</option>
                                            <option value="III/d" ${data.edit_golongan == 'III/d' ? 'selected' : ''}>III/d</option>
                                            <option value="IV/a" ${data.edit_golongan == 'IV/a' ? 'selected' : ''}>IV/a</option>
                                            <option value="IV/b" ${data.edit_golongan == 'IV/b' ? 'selected' : ''}>IV/b</option>
                                            <option value="IV/c" ${data.edit_golongan == 'IV/c' ? 'selected' : ''}>IV/c</option>
                                            <option value="IV/d" ${data.edit_golongan == 'IV/d' ? 'selected' : ''}>IV/d</option>
                                            <option value="IV/e" ${data.edit_golongan == 'IV/e' ? 'selected' : ''}>IV/e</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="bidang_keahlian">Bidang Keahlian</label>
                                        <input class="form-control" type="text"
                                            name="bidang_keahlian" id="edit_bidang_keahlian" value="${data.bidang_keahlian ?? ''}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="matakuliah_prodi">Matakuliah yang Diampu di Prodi</label>
                                        <input class="form-control"
                                            type="text" name="matakuliah_prodi" id="edit_matakuliah_prodi"
                                            placeholder="Pisahkan dengan tanda koma dan spasi" value="${data.matakuliah_prodi ?? ''}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="matakuliah_prodi_lain">Matakuliah yang Diampu di Prodi lain</label>
                                        <input class="form-control"
                                            type="text" name="matakuliah_prodi_lain" id="edit_matakuliah_prodi_lain"
                                            placeholder="Pisahkan dengan tanda koma dan spasi" value="${data.matakuliah_prodi_lain ?? ''}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mandatory">
                                        <label class="form-label">Kesesuaian dengan Kompetensi Inti Program Studi</label>
                                        <select class="form-select" name="edit_kompetensi" id="edit_kompetensi" required>
                                            <option value="1" ${data.kesesuaian_matakuliah == 1 ? 'selected' : ''}>Sesuai</option>
                                            <option value="0" ${data.kesesuaian_matakuliah == 0 ? 'selected' : ''}>Tidak Sesuai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>`

                            $('#data_edit').append(data_create);
                            $('#card_edit').css('display', 'block');

                        } else {
                            $('#card_dosen_tetap').css('display', 'block');
                        }
                    },
                    error: function(xhr) {
                        alert('Gagal Mengambil data !');
                        $('#card_dosen_tetap').css('display', 'block');
                    }
                });
            } catch (error) {
                alert("Gagal !");
                $('#card_dosen_tetap').css('display', 'block');
            }

        }

        //Tombol Kembali
        async function kembali() {

            $('#data_edit').empty();
            $('#card_edit').css('display', 'none');
            $('#card_dosen_tetap').css('display', 'block');
            getDataDosen();
        }

        //Tombol Simpan
        function update_dosen() {

            document.getElementById('simpan_update').disabled = true;

            let edit_id = document.getElementById('edit_id').value;
            let edit_nama = document.getElementById('edit_nama').value;
            let edit_nidn = document.getElementById('edit_nidn').value;
            let edit_kelamin = document.getElementById('edit_kelamin').value;
            let edit_pendidikan = document.getElementById('edit_pendidikan').value;
            let edit_pascasarjana = document.getElementById('edit_pascasarjana').value;
            let edit_industri_praktisi = document.getElementById('edit_industri_praktisi').value;
            let edit_nomor_sertifikasi = document.getElementById('edit_nomor_sertifikasi').value;
            let edit_nomor_ser_pro = document.getElementById('edit_nomor_sertifikasi_profesi_industri').value;
            let edit_fungsional = document.getElementById('edit_fungsional').value;
            let edit_golongan = document.getElementById('edit_golongan').value;
            let edit_bidang_keahlian = document.getElementById('edit_bidang_keahlian').value;
            let edit_matakuliah_prodi = document.getElementById('edit_matakuliah_prodi').value;
            let edit_matakuliah_prodi_lain = document.getElementById('edit_matakuliah_prodi_lain').value;
            let edit_kompetensi = document.getElementById('edit_kompetensi').value;

            try {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('update_dosen_tt') }}",
                    data: {
                        id: edit_id,
                        nama: edit_nama,
                        nidn : edit_nidn,
                        kelamin: edit_kelamin,
                        pendidikan: edit_pendidikan,
                        pascasarjana: edit_pascasarjana,
                        industri_praktisi: edit_industri_praktisi,
                        nomor_sertifikasi: edit_nomor_sertifikasi,
                        nomor_sertifikasi_profesi_industri: edit_nomor_ser_pro,
                        fungsional: edit_fungsional,
                        golongan: edit_golongan,
                        bidang_keahlian: edit_bidang_keahlian,
                        matakuliah_prodi: edit_matakuliah_prodi,
                        matakuliah_prodi_lain: edit_matakuliah_prodi_lain,
                        kesesuaian_kompetensi: edit_kompetensi,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(data, message, response) {
                        alert('Berhasil memperbarui data dosen .');
                        document.getElementById('simpan_update').disabled = false;
                    },
                    error: function(e) {
                        alert('Gagal memperbarui data .');
                        document.getElementById('simpan_update').disabled = false;
                    }
                });
            } catch (error) {
                if (xhr.status == 422) {
                    alert('Harap lengkapi / perbaiki formulir yang akan di dikirim');
                }else{
                    alert('Gagal melakukan pengiriman data dosen !');
                }
                
                document.getElementById('simpan_update').disabled = false;
            }

        }

        //Hapus data dosen
        async function deleteDataDosen(s) {

            let id = s;
            var konfirmasi = window.confirm("Apakah Anda yakin ingin menghapus dosen ?");

            if (konfirmasi) {
                try {
                    await $.ajax({
                        type: 'DELETE',
                        url: "{{ route('delete_dosen_tt') }}",
                        data: {
                            id: id,
                            _token: token
                        },
                        dataType: 'json',
                        success: function(data) {
                            alert(data.message);
                        },
                        error: function(xhr) {
                            alert('Gagal menghapus data dosen !');
                        }
                    });

                    await getDataDosen();

                } catch (error) {
                    alert('Server Error !');
                    console.log(error);
                }
            }
        }
    </script>
@endsection
