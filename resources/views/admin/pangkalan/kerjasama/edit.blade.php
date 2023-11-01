@extends('admin.layout.layout')

@section('content')

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Kerjasama</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk edit kerjasama.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Kerjasama</li>
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
                        style="margin-right:7px;position: relative;top: -1px;"></i> Update</button>
                <a href="/prodi/data/kerjasama"
                    class="float-end"><button class="btn btn-primary"><i class="bi bi-card-list"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/data/kerjasama/{{ $kerjasama['ids'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="nama" class="form-label">Nama Mitra</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama"
                                    value="{{ old('nama') ?? $kerjasama['nama']}}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="judul" class="form-label">Judul / Ruang Lingkup</label>
                                <input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul"
                                    value="{{ old('judul') ?? $kerjasama['judul'] }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="output" class="form-label">Manfaat / Output</label>
                                <input class="form-control @error('output') is-invalid @enderror" type="text" name="output"
                                    value="{{ old('output') ?? $kerjasama['output'] }}" required>
                                @error('output')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="durasi" class="form-label">Waktu dan Durasi</label>
                                <input class="form-control @error('durasi') is-invalid @enderror" type="text" name="durasi"
                                    value="{{ old('durasi') ?? $kerjasama['durasi'] }}" required>
                                @error('durasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Kerjasama</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number" name="tahun"
                                    value="{{ old('tahun') ?? $kerjasama['tahun'] }}" required>
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
                                    <option value="pendidikan" {{ old('bidang') || $kerjasama['bidang'] == 'pendidikan' ? 'selected' : '' }}>Pendidikan
                                    </option>
                                    <option value="penelitian" {{ old('bidang') || $kerjasama['bidang'] == 'penelitian' ? 'selected' : '' }}>Penelitian</option>
                                    <option value="pengabdian kepada masyarakat" {{ old('bidang') || $kerjasama['bidang'] == 'pengabdian kepada masyarakat' ? 'selected' : '' }}>Pengabdian Kepada Masyarakat</option>
                                    <option value="pengembangan kelembagaan" {{ old('bidang') || $kerjasama['bidang'] == 'pengembangan kelembagaan' ? 'selected' : '' }}>Pengembangan Kelembagaan</option>
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
                                    <option value="internasional" {{ old('tingkat') || $kerjasama['tingkat'] == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                    <option value="nasional" {{ old('tingkat') || $kerjasama['tingkat'] == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="lokal" {{ old('tingkat') || $kerjasama['tingkat'] == 'lokal' ? 'selected' : '' }}>Lokal</option>
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
