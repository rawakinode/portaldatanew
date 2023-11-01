@extends('admin.layout.layout')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Prestasi Mahasiswa</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk menambahkan prestasi mahasiswa.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Prestasi Mahasiswa</li>
                </ol>
            </nav>
        </div>
    </div>

    @include('trait._success')

    <section class="mb-3">
        <div class="row">
            <div class="col">
                <button onclick="document.getElementById('submit').click();" class="btn btn-success float-end"
                    style="margin-left: 5px"><i class="bi bi-check-square-fill"
                        style="margin-right:7px;position: relative;top: -1px;"></i> Simpan</button>
                <a href="/prodi/data/prestasi"
                    class="float-end"><button class="btn btn-primary"><i class="bi bi-card-list"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/data/prestasi" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="nama" class="form-label">Nama Kegiatan / Kompetisi</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama"
                                    value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="prestasi" class="form-label">Prestasi Diraih</label>
                                <input class="form-control @error('prestasi') is-invalid @enderror" type="text" name="prestasi"
                                    value="{{ old('prestasi') }}" required>
                                @error('prestasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="nim" class="form-label">NIM / Stambuk</label>
                                <input class="form-control @error('nim') is-invalid @enderror" type="text" name="nim"
                                    value="{{ old('nim') }}" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama_mahasiswa"
                                    value="{{ old('nama_mahasiswa') }}" required>
                                @error('nama_mahasiswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Prestasi</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number" name="tahun"
                                    value="{{ old('tahun') }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="bidang" class="form-label">Bidang</label>
                                <select class="form-select @error('bidang') is-invalid @enderror" name="bidang" id="bidang" required>
                                    <option value="">Pilih...</option>
                                    <option value="akademik" {{ old('bidang') == 'akademik' ? 'selected' : '' }}>Akademik
                                    </option>
                                    <option value="non-akademik" {{ old('bidang') == 'non-akademik' ? 'selected' : '' }}>Non-Akademik</option>
                                </select>
                                @error('bidang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="tingkat" class="form-label">Tingkat</label>
                                <select class="form-select @error('tingkat') is-invalid @enderror" name="tingkat" id="tingkat" required>
                                    <option value="">Pilih...</option>
                                    <option value="internasional" {{ old('tingkat') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                    <option value="nasional" {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="lokal" {{ old('tingkat') == 'lokal' ? 'selected' : '' }}>Lokal</option>
                                </select>
                                @error('tingkat')
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

@endsection
