@extends('admin.layout.layout')

@section('content')
    <style>
        .floating-list {
            position: absolute;
            width: 100%;
            z-index: 1000;
            /* Untuk memastikan daftar melayang di atas elemen lain */
            background-color: white;
            color: inherit;
            border: 1px solid #ccc;
            max-height: 200px;
            /* Sesuaikan tinggi sesuai kebutuhan Anda */
            overflow-y: auto;
            /* Menambahkan scroll jika daftar terlalu panjang */
        }

        .list-group-item {
            cursor: pointer;
        }

        .list-group-item:hover {
            background-color: rgb(233, 233, 233);
        }

        .floating-list.hidden {
            display: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Dosen</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir tambah dosen</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Dosen</li>
                </ol>
            </nav>
        </div>
    </div>

    @include('trait._error')
    @include('trait._success')

    <section class="mb-3">
        <div class="row">
            <div class="col">
                <button onclick="document.getElementById('submit').click();" class="btn btn-success float-end"
                    style="margin-left: 5px"><i class="bi bi-check-square-fill"
                        style="margin-right:7px;position: relative;top: -1px;"></i> Simpan</button>
                <a href="/portaldata/dosen" class="float-end"><button class="btn btn-primary"><i class="bi bi-card-list"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/portaldata/dosen" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mandatory">
                                <label for="nidn" class="form-label">Nomor NIDN / NIDK</label>
                                <input class="form-control @error('nidn') is-invalid @enderror" type="text"
                                    name="nidn" id="nidn" value="{{ old('nidn') }}" required>
                                @error('nidn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mandatory">
                                <label class="form-label" for="nama">Nama Dosen</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                    name="nama" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mandatory">
                                <label class="form-label" for="kelamin">Jenis Kelamin</label>
                                <select class="form-select @error('kelamin') is-invalid @enderror" name="kelamin"
                                    id="kelamin">
                                    <option value="">Pilih...</option>
                                    <option value="0" {{ old('kelamin') == '0' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="1" {{ old('kelamin') == '1' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="fungsional">Jabatan</label>
                                <select class="form-select @error('fungsional') is-invalid @enderror" name="fungsional"
                                    id="fungsional">
                                    <option value="">- Tidak Ada -</option>
                                    <option value="1" {{ old('fungsional') == '1' ? 'selected' : '' }}>Asisten Ahli
                                    </option>
                                    <option value="2" {{ old('fungsional') == '2' ? 'selected' : '' }}>Lektor</option>
                                    <option value="3" {{ old('fungsional') == '3' ? 'selected' : '' }}>Lektor Kepala
                                    </option>
                                    <option value="4" {{ old('fungsional') == '4' ? 'selected' : '' }}>Guru Besar
                                    </option>
                                    <option value="5" {{ old('fungsional') == '5' ? 'selected' : '' }}>Tenaga Pengajar
                                    </option>
                                </select>
                                @error('fungsional')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="golongan">Golongan</label>
                                <select class="form-select @error('golongan') is-invalid @enderror" name="golongan"
                                    id="golongan">
                                    <option value="">- Tidak Ada -</option>
                                    <option value="II/a" {{ old('golongan') == 'II/a' ? 'selected' : '' }}>II/a</option>
                                    <option value="II/b" {{ old('golongan') == 'II/b' ? 'selected' : '' }}>II/b</option>
                                    <option value="II/c" {{ old('golongan') == 'II/c' ? 'selected' : '' }}>II/c</option>
                                    <option value="II/d" {{ old('golongan') == 'II/d' ? 'selected' : '' }}>II/d</option>
                                    <option value="III/a" {{ old('golongan') == 'III/a' ? 'selected' : '' }}>III/a
                                    </option>
                                    <option value="III/b" {{ old('golongan') == 'III/b' ? 'selected' : '' }}>III/b
                                    </option>
                                    <option value="III/c" {{ old('golongan') == 'III/c' ? 'selected' : '' }}>III/c
                                    </option>
                                    <option value="III/d" {{ old('golongan') == 'III/d' ? 'selected' : '' }}>III/d
                                    </option>
                                    <option value="IV/a" {{ old('golongan') == 'IV/a' ? 'selected' : '' }}>IV/a</option>
                                    <option value="IV/b" {{ old('golongan') == 'IV/b' ? 'selected' : '' }}>IV/b</option>
                                    <option value="IV/c" {{ old('golongan') == 'IV/c' ? 'selected' : '' }}>IV/c</option>
                                    <option value="IV/d" {{ old('golongan') == 'IV/d' ? 'selected' : '' }}>IV/d</option>
                                    <option value="IV/e" {{ old('golongan') == 'IV/e' ? 'selected' : '' }}>IV/e</option>
                                </select>
                                @error('golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mandatory">
                                <label class="form-label" for="bidang_keahlian">Bidang Keahlian</label>
                                <input class="form-control @error('bidang_keahlian') is-invalid @enderror" type="text"
                                    name="bidang_keahlian" id="bidang_keahlian" value="{{ old('bidang_keahlian') }}"
                                    required>
                                @error('bidang_keahlian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mandatory">
                                <label class="form-label" for="kesesuaian_kompetensi">Kesesuaian dengan Kompetensi Inti
                                    Prodi</label>
                                <select class="form-select @error('kesesuaian_kompetensi') is-invalid @enderror"
                                    name="kesesuaian_kompetensi" id="kesesuaian_kompetensi">
                                    <option value="">Pilih...</option>
                                    <option value="1" {{ old('kesesuaian_kompetensi') == '1' ? 'selected' : '' }}>Ya
                                    </option>
                                    <option value="0" {{ old('kesesuaian_kompetensi') == '0' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                                @error('kesesuaian_kompetensi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="matakuliah_prodi">Matakuliah yang Diampu di Prodi</label>
                                <input class="form-control @error('matakuliah_prodi') is-invalid @enderror" type="text"
                                    name="matakuliah_prodi" id="matakuliah_prodi"
                                    placeholder="Pisahkan dengan tanda koma dan spasi"
                                    value="{{ old('matakuliah_prodi') }}">
                                @error('matakuliah_prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mandatory">
                                <label class="form-label" for="kesesuaian_matakuliah">Kesesuaian Bidang Keahlian dengan
                                    Mata Kuliah yang Diampu</label>
                                <select class="form-select @error('kesesuaian_matakuliah') is-invalid @enderror"
                                    name="kesesuaian_matakuliah" id="kesesuaian_matakuliah">
                                    <option value="">Pilih...</option>
                                    <option value="1" {{ old('kesesuaian_matakuliah') == '1' ? 'selected' : '' }}>Ya
                                    </option>
                                    <option value="0" {{ old('kesesuaian_matakuliah') == '0' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                                @error('kesesuaian_matakuliah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="matakuliah_prodi_lain">Matakuliah yang Diampu pada Prodi
                                    Lain</label>
                                <input class="form-control @error('matakuliah_prodi_lain') is-invalid @enderror"
                                    type="text" name="matakuliah_prodi_lain" id="matakuliah_prodi_lain"
                                    placeholder="Pisahkan dengan tanda koma dan spasi"
                                    value="{{ old('matakuliah_prodi_lain') }}">
                                @error('matakuliah_prodi_lain')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mandatory">
                                <label class="form-label" for="homebase">Homebase</label>
                                <input onkeyup="cari_prodi(this)"
                                    class="form-control @error('homebase') is-invalid @enderror" type="text" id="homebase_show"
                                    placeholder="Ketikkan home base" required>
                                <input type="hidden" name="homebase" id="homebase" name="homebase" value="{{ old('homebase') }}" required>
                                @error('homebase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!-- Daftar Hasil Pencarian -->
                                <div class="position-relative">
                                    <ul class="list-group mt-2 floating-list" id="list_prodi" style="display: none">

                                    </ul>
                                </div>
                            </div>
                            <div class="form-group mandatory">
                                <label class="form-label" for="pendidikan">Pendidikan Terakhir</label>
                                <select class="form-select @error('pendidikan') is-invalid @enderror" name="pendidikan"
                                    id="pendidikan">
                                    <option value="">Pilih...</option>
                                    <option value="1" {{ old('pendidikan') == '1' ? 'selected' : '' }}>S1</option>
                                    <option value="2" {{ old('pendidikan') == '2' ? 'selected' : '' }}>S2</option>
                                    <option value="3" {{ old('pendidikan') == '3' ? 'selected' : '' }}>S3</option>
                                    <option value="4" {{ old('pendidikan') == '4' ? 'selected' : '' }}>Profesi
                                    </option>
                                </select>
                                @error('pendidikan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="pendidikan_magister">Pendidikan Magister</label>
                                <input class="form-control @error('pendidikan_magister') is-invalid @enderror"
                                    type="text" name="pendidikan_magister" id="pendidikan_magister"
                                    value="{{ old('pendidikan_magister') }}" placeholder="Cont: Universitas Indonesia">
                                @error('pendidikan_magister')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="pendidikan_doctoral">Pendidikan Doctoral</label>
                                <input class="form-control @error('pendidikan_doctoral') is-invalid @enderror"
                                    type="text" name="pendidikan_doctoral" id="pendidikan_doctoral"
                                    value="{{ old('pendidikan_doctoral') }}" placeholder="Cont: Universitas Indonesia">
                                @error('pendidikan_doctoral')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="nomor_sertifikasi">Nomor Sertifikasi Pendidik Profesional
                                    (Jika Ada)</label>
                                <input class="form-control @error('nomor_sertifikasi') is-invalid @enderror"
                                    type="text" name="nomor_sertifikasi" id="nomor_sertifikasi"
                                    value="{{ old('nomor_sertifikasi') }}">
                                @error('nomor_sertifikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="nomor_sertifikasi_profesi_industri">Nomor Sertifikasi
                                    Profesi / Industri / Kompetensi (Jika Ada)</label>
                                <input
                                    class="form-control @error('nomor_sertifikasi_profesi_industri') is-invalid @enderror"
                                    type="text" name="nomor_sertifikasi_profesi_industri"
                                    id="nomor_sertifikasi_profesi_industri"
                                    value="{{ old('nomor_sertifikasi_profesi_industri') }}">
                                @error('nomor_sertifikasi_profesi_industri')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="perusahaan_industri">Perusahaan / Industri (Khusus Dosen
                                    Industri / Praktisi)</label>
                                <input class="form-control @error('perusahaan_industri') is-invalid @enderror"
                                    type="text" name="perusahaan_industri" id="perusahaan_industri"
                                    value="{{ old('perusahaan_industri') }}">
                                @error('perusahaan_industri')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="upload" class="form-label">Upload Dokumen / SK Dosen</label>
                                <input class="form-control @error('upload') is-invalid @enderror" type="file"
                                    accept="application/pdf" id="upload" name="upload">
                                @error('upload')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" value="" id="submit" hidden>
        </form>
    </section>

    <script>

        document.addEventListener("click", function() {
            $('#list_prodi').css('display', 'none');
        });

        let data_prodi = [];

        //Fungsi mencari prodi di API
        function cari_prodi(p) {

            document.getElementById('homebase').value = '';  

            try {
                search = p.value;

                var settings = {
                    "url": "{{ route('prodi') }}?search=" + search,
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
                            '<li onclick="select_prodi('+e.id+')" class="list-group-item" style="text-transform:uppercase;">' +
                            e.jenjang + ' ' + e.nama + '</li>';
                    }

                    $('#list_prodi').append(html_list);
                    $('#list_prodi').css('display', 'block');

                });
            } catch (error) {
                $('#list_prodi').empty();
                alert('Gagal menarik data homebase');
            }
        }

        function select_prodi(s) {

            $('#list_prodi').css('display', 'none');

            let filter_data = data_prodi.filter(function(item){
                return item.id == s;
            })[0];

            let f = filter_data;

            document.getElementById('homebase_show').value = (f.jenjang+' '+f.nama).toUpperCase();
            document.getElementById('homebase').value = f.kode;  
        }
    </script>
@endsection
