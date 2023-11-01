@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="{{ asset('/assets/extensions/jquery/jquery.min.js') }}"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Dosen</h3>
            <p class="text-subtitle text-muted">Menampilkan daftar dosen tetap program studi di Universitas Tadulako</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Portal data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dosen</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--INCLUDE -->
    @include('trait._error')
    @include('trait._success')

    {{-- menampilkan tabel dosen --}}
    <div class="card" id="card_dosen_tetap">
        <div class="col-sm">
            <h5 class="card-header">Daftar Dosen Tetap</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-9 col-sm-8">
                    @csrf
                    <input onkeyup="cari_dosen(this)" class="form-control" type="search" name="search" id="search"
                        placeholder="Cari berdasarkan nama, nidn, nidk, homebase ...">
                    <input type="hidden" name="dosen_kode" id="dosen_kode">
                    <div class="position-relative">
                        <ul class="list-group mt-2 floating-list" id="list_prodi" style="display: none">

                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <input onclick="kirim_dosen()" class="btn btn-primary w-100" id="tombol" type="button"
                        value="Tambahkan">
                </div>
            </div>

            <div class="table-responsive text-wrap">
                <table class="table table-striped" id="datatabel">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">Aksi</th>
                            <th>Nama</th>
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

        <h5 class="card-header">Edit</h5>

        <div class="card-body" id="data_edit">

        </div>

        <div class="card-footer">
            <button onclick="kembali()" class="btn btn-danger">Kembali</button>
            <button onclick="update_dosen()" class="btn btn-success" id="simpan_update">Simpan</button>
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
                    url: '{{ route('dosen_table_get') }}',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {

                            let dosen = data;
                            let tbody_all = '';

                            for (let i = 0; i < dosen.length; i++) {
                                const e = dosen[i];

                                let ds_pendidikan =
                                    (e.dosen_prodi.pendidikan == 1) ? 'S1' :
                                    (e.dosen_prodi.pendidikan == 2) ? 'S2' :
                                    (e.dosen_prodi.pendidikan == 3) ? 'S3' :
                                    (e.dosen_prodi.pendidikan == 4) ? 'PROFESI' : '';

                                let ds_kelamin =
                                    (e.dosen_prodi.kelamin == 0) ? 'LK' :
                                    (e.dosen_prodi.kelamin == 1) ? 'PR' : '';

                                let ds_fungsional =
                                    (e.dosen_prodi.fungsional === 1) ? "Asisten Ahli" :
                                    (e.dosen_prodi.fungsional === 2) ? "Lektor" :
                                    (e.dosen_prodi.fungsional === 3) ? "Lektor Kepala" :
                                    (e.dosen_prodi.fungsional === 4) ? "Guru Besar" :
                                    (e.dosen_prodi.fungsional === 5) ? "Tenaga Pengajar" : "";

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
                                                    <span class="fw-semibold">${e.dosen_prodi.nama}</span>
                                                    <small class="text-muted">${e.nidn}</small>
                                                    <div>
                                                    </div>
                                        </td>
                                        <td>${ds_pendidikan}</td>
                                        <td>${ds_kelamin}</td>
                                        <td>${ds_fungsional}</td>

                                        <td>${e.dosen_prodi.golongan}</td>
                                        <td>${e.dosen_prodi.bidang_keahlian}</td>

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

        //Fungsi mencari prodi di API
        function cari_dosen(p) {

            document.getElementById('dosen_kode').value = '';

            try {
                search = p.value;

                var settings = {
                    "url": "{{ route('dosen_homebase') }}?search=" + search,
                    "method": "GET",
                    "timeout": 0,
                };

                $('#list_prodi').empty();

                $.ajax(settings).then(function(response) {

                    data_prodi = response;

                    html_list = '';

                    for (let i = 0; i < response.length; i++) {
                        const e = response[i];
                        html_list +=
                            '<li onclick="select(' + e.id +
                            ')" class="list-group-item" style="text-transform:uppercase;">' +
                            e.nidn + ' - ' + e.nama + '</li>';
                    }

                    $('#list_prodi').append(html_list);
                    $('#list_prodi').css('display', 'block');

                });
            } catch (error) {
                $('#list_prodi').empty();
                alert('Gagal menarik data homebase');
            }
        }

        //Memproses dosen homebase yang di pilih
        function select(s) {

            $('#list_prodi').css('display', 'none');

            let filter_data = data_prodi.filter(function(item) {
                return item.id == s;
            })[0];

            let f = filter_data;

            document.getElementById('search').value = (f.nidn + ' - ' + f.nama).toUpperCase();
            document.getElementById('dosen_kode').value = f.nidn;
        }

        //Setelah di pilih, lalu dosen di kirim
        async function kirim_dosen() {

            document.getElementById('tombol').disabled = true;

            var dosen_kode = document.getElementById('dosen_kode').value;

            try {
                await $.ajax({
                    type: 'POST',
                    url: "{{ route('create_dosen_tetap') }}",
                    data: {
                        dosen_kode: dosen_kode,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(data) {
                        document.getElementById('search').value = '';
                        document.getElementById('dosen_kode').value = '';
                        document.getElementById('tombol').disabled = false;
                        alert(data.message);
                    },
                    error: function(xhr) {
                        document.getElementById('search').value = '';
                        document.getElementById('dosen_kode').value = '';
                        document.getElementById('tombol').disabled = false;
                        alert('Gagal melakukan pengiriman data dosen !');
                    }
                });

                await getDataDosen();

            } catch (error) {
                document.getElementById('tombol').disabled = false;
                alert('Server Error !');
            }
        }

        // Menampilkan Halaman Edit
        async function tampilkan_edit(p) {

            let id_for_edit = p;

            $('#card_dosen_tetap').css('display', 'none');

            try {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('edit_dosen_tetap') }}",
                    data: {
                        id: id_for_edit,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(data, message, response) {
                        if (response.status == 200) {

                            let dds = data;
                            let dds_hb = data.dosen_prodi;

                            let mk_prodi = (dds.matakuliah_prodi != null) ? dds.matakuliah_prodi : '';
                            let mk_prodi_lain = (dds.matakuliah_prodi_lain != null) ? dds.matakuliah_prodi_lain : '';

                            let e_kompetensi = (dds.kesesuaian_kompetensi == 0) ? `
                                <option value="">-- Pilih --</option>
                                <option value="1">Sesuai</option>
                                <option value="0" selected>Tidak Sesuai</option>` :
                                `<option value="">-- Pilih --</option>
                                <option value="1" selected>Sesuai</option>
                                <option value="0">Tidak Sesuai</option>`;
                            
                            let e_matakuliah = (dds.kesesuaian_matakuliah == 0) ? `
                                <option value="">-- Pilih --</option>
                                <option value="1">Sesuai</option>
                                <option value="0" selected>Tidak Sesuai</option>` :
                                `<option value="">-- Pilih --</option>
                                <option value="1" selected>Sesuai</option>
                                <option value="0">Tidak Sesuai</option>` ;
                            
                            let data_edit = `<div class="row">
                                <input type="hidden" name="u_id" id="u_id" value="${dds.id}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nama</label>
                                        <input class="form-control" type="text" id="edit_nama" value="${dds_hb.nama}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">NIDN</label>
                                        <input class="form-control" type="text" id="edit_nidn" value="${dds.nidn}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kesesuaian dengan Kompetensi Inti Program Studi</label>
                                        <select class="form-select" name="edit_kompetensi" id="edit_kompetensi">
                                            ${e_kompetensi}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kesesuaian dengan Mata Kuliah yang Diampu</label>
                                        <select class="form-select" name="edit_kesesuaian_mk" id="edit_kesesuaian_mk">
                                            ${e_matakuliah}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Mata Kuliah yang Diampu pada Program Studi yang Diakreditasi</label>
                                        <input class="form-control" type="text" id="edit_mk_prodi" value="${mk_prodi}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Mata Kuliah yang Diampu pada Prodi Studi lain</label>
                                        <input class="form-control" type="text" id="edit_mk_prodi_lain" value="${mk_prodi_lain}">
                                    </div>
                                </div>
                            </div>`;

                            $('#data_edit').append(data_edit);
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

            let u_id = $('#u_id').val();
            let u_kom = $('#edit_kompetensi').val();
            let u_kes = $('#edit_kesesuaian_mk').val();
            let u_mk_pr = $('#edit_mk_prodi').val();
            let u_mk_pr_ln = $('#edit_mk_prodi_lain').val();

            console.log(u_kes);

            try {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('update_dosen_tetap') }}",
                    data: {
                        id: u_id,
                        kes_kom: u_kom,
                        kes_mat: u_kes,
                        mk_prodi: u_mk_pr,
                        mk_prodi_lain: u_mk_pr_ln,
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
                alert('Gagal! Cek Koneksi Internet Anda !');
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
                        url: "{{ route('delete_dosen_tetap') }}",
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
