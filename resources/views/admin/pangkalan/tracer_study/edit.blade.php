@extends('admin.layout.layout')

@section('content')
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Tracer Study</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk edit tracer study.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Tracer Study</li>
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
                <a href="/prodi/akreditasi/tracer_study" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/akreditasi/tracer_study/{{ $tracer_study['ids'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="nim" class="form-label">NIM Mahasiswa</label>
                                <input class="form-control @error('nim') is-invalid @enderror" type="text"
                                    name="nim" value="{{ old('nim') ?? $tracer_study['nim'] }}">
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="masa_studi" class="form-label">Lama Studi (Jumlah Bulan)</label>
                                <input class="form-control @error('masa_studi') is-invalid @enderror" type="number"
                                    name="masa_studi" id="masa_studi" value="{{ old('masa_studi') ?? $tracer_study['masa_studi'] }}" placeholder="Contoh: 48" required>
                                @error('masa_studi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="waktu_tunggu_kerja" class="form-label">Waktu Tunggu Mendapatkan Pekerjaan (Bulan)</label>
                                <input class="form-control @error('waktu_tunggu_kerja') is-invalid @enderror" type="number"
                                    name="waktu_tunggu_kerja" id="waktu_tunggu_kerja" value="{{ old('waktu_tunggu_kerja') ?? $tracer_study['waktu_tunggu_kerja']}}" placeholder="Contoh: 12" required>
                                @error('waktu_tunggu_kerja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Data Tahun</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') ?? $tracer_study['tahun'] }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="penghasilan" class="form-label">Rata-rata Penghasilan Tahun Pertama</label>
                                <input class="form-control @error('penghasilan') is-invalid @enderror" type="number"
                                    name="penghasilan" value="{{ old('penghasilan') ?? $tracer_study['penghasilan']}}" required>
                                @error('penghasilan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="kesesuaian_bidang_ilmu" class="form-label">Kesesuaian Bidang Ilmu</label>
                                <select class="form-select" name="kesesuaian_bidang_ilmu" id="kesesuaian_bidang_ilmu">
                                    <option value="">Pilih ...</option>
                                    <option value="sesuai" {{ $tracer_study['kesesuaian_bidang_ilmu'] == 'sesuai' ? 'selected' : '' }}>Sesuai
                                    </option>
                                    <option value="kurang sesuai" {{ $tracer_study['kesesuaian_bidang_ilmu'] == 'kurang sesuai' ? 'selected' : '' }}>Kurang Sesuai
                                    </option>
                                    <option value="tidak sesuai" {{ $tracer_study['kesesuaian_bidang_ilmu'] == 'tidak sesuai' ? 'selected' : '' }}>Tidak Sesuai
                                    </option>
                                    
                                </select>
                                @error('kesesuaian_bidang_ilmu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="tingkat" class="form-label">Tingkat</label>
                                <select class="form-select" name="tingkat" id="tingkat">
                                    <option value="">Pilih ...</option>
                                    <option value="lokal / wilayah / berwirausaha tidak berbadan hukum" {{ $tracer_study['tingkat'] == 'lokal / wilayah / berwirausaha tidak berbadan hukum' ? 'selected' : '' }}>Lokal / Wilayah / Berwirausaha Tidak Berbadan Hukum
                                    </option>
                                    <option value="nasional / berwirausaha berbadan hukum" {{ $tracer_study['tingkat'] == 'nasional / berwirausaha berbadan hukum' ? 'selected' : '' }}>Nasional / Berwirausaha berbadan hukum
                                    </option>
                                    <option value="multinasional / internasional" {{ $tracer_study['tingkat'] == 'multinasional / internasional' ? 'selected' : '' }}>Multinasional / Internasional
                                    </option>
                                    <option value="melanjutkan studi" {{ $tracer_study['tingkat'] == 'melanjutkan studi' ? 'selected' : '' }}>Melanjutkan Studi
                                    </option>
                                </select>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="umr" class="form-label">Penghasilan diatas UMR Setempat ?</label>
                                <select class="form-select" name="umr" id="umr">
                                    <option value="">Pilih ...</option>
                                    <option value="1" {{ $tracer_study['umr'] == '1' ? 'selected' : '' }}>Diatas atau sama dengan UMR</option>
                                    <option value="0" {{ $tracer_study['umr'] == '0' ? 'selected' : '' }}>Dibawah UMR</option>
                                </select>
                                @error('umr')
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
