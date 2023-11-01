@extends('admin.layout.layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Publikasi</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk edit publikasi.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Publikasi</li>
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
                <a href="/prodi/data/publikasi" class="float-end"><button class="btn btn-primary"><i class="bi bi-card-list"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/data/publikasi/{{ $publikasi['ids'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="judul" class="form-label">Judul Publikasi</label>
                                <input class="form-control @error('judul') is-invalid @enderror" type="text"
                                    name="judul" value="{{ old('judul') ?? $publikasi['judul'] }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="publikasi" class="form-label">Nama Jurnal Publikasi</label>
                                <input class="form-control @error('publikasi') is-invalid @enderror" type="text"
                                    name="publikasi" value="{{ old('publikasi') ?? $publikasi['publikasi'] }}" required>
                                @error('publikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Terbit</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') ?? $publikasi['tahun'] }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="jenis" class="form-label">Jenis Publikasi</label>
                                <select class="form-select @error('jenis') is-invalid @enderror" name="jenis"
                                    id="jenis" onchange="selectJenisPublikasi()" required>
                                    <option value="">Pilih...</option>
                                    <option value="jurnal"
                                        {{ old('jenis') ?? $publikasi['jenis'] == 'jurnal' ? 'selected' : '' }}>Jurnal
                                    </option>
                                    <option value="seminar"
                                        {{ old('jenis') ?? $publikasi['jenis'] == 'seminar' ? 'selected' : '' }}>Seminar
                                    </option>
                                    <option value="media massa"
                                        {{ old('jenis') ?? $publikasi['jenis'] == 'media massa' ? 'selected' : '' }}>Media
                                        Massa</option>
                                        <option value="pagelaran pameran presentasi"
                                        {{ old('jenis') ?? $publikasi['jenis'] == 'pagelaran pameran presentasi' ? 'selected' : '' }}>Pagelaran Pameran Presentasi</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="sub_jenis" class="form-label">Terpublikasi (Jurnal / Seminar / Tulisan)</label>
                                <select class="form-select @error('sub_jenis') is-invalid @enderror" name="sub_jenis"
                                    id="sub_jenis" required>
                                    @if (old('jenis') == 'jurnal' || $publikasi['jenis'] == 'jurnal')
                                        <option value="nasional tidak terakreditasi"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'nasional tidak terakreditasi' ? 'selected' : '' }}>
                                            Nasional Tidak Terakreditasi </option>
                                        <option value="nasional terakreditasi"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'nasional terakreditasi' ? 'selected' : '' }}>
                                            Nasional
                                            Terakreditasi</option>
                                        <option value="internasional"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'internasional' ? 'selected' : '' }}>
                                            Internasional
                                        </option>
                                        <option value="internasional bereputasi"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'internasional bereputasi' ? 'selected' : '' }}>
                                            Internasional Bereputasi</option>
                                    @elseif(old('jenis') == 'seminar' || $publikasi['jenis'] == 'seminar')
                                        <option value="wilayah / lokal / PT"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'wilayah / lokal / PT' ? 'selected' : '' }}>
                                            Wilayah /
                                            Lokal / PT</option>
                                        <option value="nasional"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'nasional' ? 'selected' : '' }}>
                                            Nasional</option>
                                        <option value="internasional"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'internasional' ? 'selected' : '' }}>
                                            Internasional
                                        </option>
                                    @elseif(old('jenis') == 'media massa' || $publikasi['jenis'] == 'media massa')
                                        <option value="wilayah"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'wilayah' ? 'selected' : '' }}>
                                            Wilayah</option>
                                        <option value="nasional"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'nasional' ? 'selected' : '' }}>
                                            Nasional</option>
                                        <option value="internasional"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'internasional' ? 'selected' : '' }}>
                                            Internasional
                                        </option>
                                    @elseif(old('jenis') == 'pagelaran pameran presentasi' || $publikasi['jenis'] == 'pagelaran pameran presentasi')
                                        <option value="wilayah"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'wilayah' ? 'selected' : '' }}>
                                            Wilayah</option>
                                        <option value="nasional"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'nasional' ? 'selected' : '' }}>
                                            Nasional</option>
                                        <option value="internasional"
                                            {{ old('sub_jenis') ?? $publikasi['sub_jenis'] == 'internasional' ? 'selected' : '' }}>
                                            Internasional
                                        </option>
                                    @endif
                                </select>
                                @error('sub_jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-group mandatory">
                                <label for="sitasi" class="form-label">Jumlah Sitasi</label>
                                <input class="form-control @error('sitasi') is-invalid @enderror" type="number"
                                    name="sitasi" value="{{ old('sitasi') ?? $publikasi['sitasi'] }}" required>
                                @error('sitasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Penulis Pertama</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input class="form-control @error('penulis_nidn') is-invalid @enderror"
                                            type="text" name="penulis_nidn"
                                            value="{{ old('penulis_nidn') ?? $publikasi['penulis_nidn'] }}"
                                            placeholder="NIDN / NIDK (Jika ada)">
                                    </div>
                                    @error('penulis_nidn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="form-group mandatory">
                                        <input class="form-control @error('penulis_dosen') is-invalid @enderror"
                                            type="text" name="penulis_dosen"
                                            value="{{ old('penulis_dosen') ?? $publikasi['penulis_dosen'] }}"
                                            placeholder="Nama Dosen / Peneliti" required>
                                    </div>
                                    @error('penulis_dosen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="row" style="margin-bottom: -20px">
                            <div class="col-7">
                                <div class="card-header">
                                    <h4>Penulis Lainnya</h4>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="card-header">
                                    <button type="button" class="btn btn-sm btn-primary float-end"
                                        onclick="tambah_penulis()">Tambah Penulis</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="list_penulis_lain">
                            @if ($publikasi['anggota'])
                                @foreach (json_decode($publikasi['anggota']) as $item)
                                    <div class="row mb-3" id="{{ 'abcd12345'.$loop->iteration }}">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="nidn_lain[]" value="{{ $item->nidn }}"
                                                    placeholder="NIDN / NIDK (Jika ada)">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="dosen_lain[]"
                                                    value="{{ $item->dosen }}" placeholder="Nama Dosen / Peneliti" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button
                                                value="{{ 'abcd12345'.$loop->iteration }}" type="button" onclick="hapus_list(this.value)"
                                                class="btn btn-sm btn-danger float-end" style="margin-left: 5px">
                                                <i class="bi bi-trash-fill" style="position: relative;top: -1px;"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach    
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <input type="submit" value="" id="submit" hidden>
        </form>
    </section>

    <script>
        function tambah_penulis() {
            var random = Math.random().toString(36).substring(2, 10);
            var element = '<div class="row mb-3" id="' + random +
                '"> <div class="col-12"> <div class="form-group"> <input class="form-control" type="text" name="nidn_lain[]" value="" placeholder="NIDN / NIDK (Jika ada)"> </div> </div> <div class="col-12"> <div class="form-group"> <input class="form-control" type="text" name="dosen_lain[]" value="" placeholder="Nama Dosen / Peneliti" required> </div> </div> <div class="col-12"> <button value="' +
                random +
                '" type="button" onclick="hapus_list(this.value)" class="btn btn-sm btn-danger float-end" style="margin-left: 5px"><i class="bi bi-trash-fill" style="position: relative;top: -1px;"></i></button> </div> </div>';

            $('#list_penulis_lain').append(element);
        }

        function hapus_list(e) {
            $('#' + e).remove();
        }

        function selectJenisPublikasi() {
            var selected = document.getElementById('jenis').value;

            var option_null = '<option value="">Pilih...</option>';

            var jurnal =
                '<option value="nasional tidak terakreditasi" {{ old('sub_jenis') == 'nasional tidak terakreditasi' ? 'selected' : '' }}>Nasional Tidak Terakreditasi </option> <option value="nasional terakreditasi" {{ old('sub_jenis') == 'nasional terakreditasi' ? 'selected' : '' }}>Nasional Terakreditasi</option> <option value="internasional" {{ old('sub_jenis') == 'internasional' ? 'selected' : '' }}>Internasional</option> <option value="internasional bereputasi" {{ old('sub_jenis') == 'internasional bereputasi' ? 'selected' : '' }}>Internasional Bereputasi</option>';

            var seminar =
                '<option value="wilayah / lokal / PT" {{ old('sub_jenis') == 'wilayah / lokal / PT' ? 'selected' : '' }}>Wilayah / Lokal / PT</option> <option value="nasional" {{ old('sub_jenis') == 'nasional' ? 'selected' : '' }}>Nasional</option> <option value="internasional" {{ old('sub_jenis') == 'internasional' ? 'selected' : '' }}>Internasional</option>';

            var tulisan =
                '<option value="wilayah" {{ old('sub_jenis') == 'wilayah' ? 'selected' : '' }}>Wilayah</option> <option value="nasional" {{ old('sub_jenis') == 'nasional' ? 'selected' : '' }}>Nasional</option> <option value="internasional" {{ old('sub_jenis') == 'internasional' ? 'selected' : '' }}>Internasional</option>';

            var pagelaran = '<option value="wilayah" {{ old('sub_jenis') == 'wilayah' ? 'selected' : '' }}>Wilayah</option> <option value="nasional" {{ old('sub_jenis') == 'nasional' ? 'selected' : '' }}>Nasional</option> <option value="internasional" {{ old('sub_jenis') == 'internasional' ? 'selected' : '' }}>Internasional</option>';

            $('#sub_jenis').empty();

            if (selected == 'jurnal') {
                $('#sub_jenis').append(option_null);
                $('#sub_jenis').append(jurnal);
            } else if (selected == 'seminar') {
                $('#sub_jenis').append(option_null);
                $('#sub_jenis').append(seminar);
            } else if (selected == 'media massa') {
                $('#sub_jenis').append(option_null);
                $('#sub_jenis').append(tulisan);
            } else if(selected == 'pagelaran pameran presentasi'){
                $('#sub_jenis').append(option_null);
                $('#sub_jenis').append(pagelaran);
            }

        }
    </script>
@endsection
