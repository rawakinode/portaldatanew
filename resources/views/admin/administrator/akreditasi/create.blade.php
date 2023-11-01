@extends('admin.layout.layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Akreditasi / Sertifikasi</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk menambahkan sertifikasi / akreditasi eksternal.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Akreditasi / Sertifikasi</li>
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
                <a href="/data/universitas/sertifikasi_akreditasi_eksternal" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/data/universitas/sertifikasi_akreditasi_eksternal" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="lembaga" class="form-label">Lembaga Sertifikasi / Akreditasi</label>
                                <input class="form-control @error('lembaga') is-invalid @enderror" type="text"
                                    name="lembaga" value="{{ old('lembaga') }}" required>
                                @error('lembaga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-group">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input class="form-control @error('keterangan') is-invalid @enderror" type="text"
                                    name="keterangan" value="{{ old('keterangan') }}">
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="tahun_berakhir" class="form-label">Tahun Berakhir</label>
                                <input class="form-control @error('tahun_berakhir') is-invalid @enderror" type="number"
                                    name="tahun_berakhir" value="{{ old('tahun_berakhir') }}" placeholder="Contoh: 2028" required>
                                @error('tahun_berakhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-select @error('jenis') is-invalid @enderror" name="jenis" id="jenis" required>
                                    <option value="">Pilih...</option>
                                    <option value="akreditasi" {{ old('jenis') == 'akreditasi' ? 'selected' : '' }}>Akreditasi</option>
                                    <option value="sertifikasi" {{ old('jenis') == 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="lingkup" class="form-label">Lingkup</label>
                                <select class="form-select @error('lingkup') is-invalid @enderror" name="lingkup" id="lingkup" required>
                                    <option value="">Pilih...</option>
                                    <option value="perguruan tinggi" {{ old('lingkup') == 'perguruan tinggi' ? 'selected' : '' }}>Perguruan Tinggi</option>
                                    <option value="fakultas" {{ old('lingkup') == 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                                    <option value="prodi" {{ old('lingkup') == 'prodi' ? 'selected' : '' }}>Unit / Program Studi</option>
                                </select>
                                @error('lingkup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="tingkat" class="form-label">Tingkat</label>
                                <select class="form-select @error('tingkat') is-invalid @enderror" name="tingkat" id="tingkat" required>
                                    <option value="">Pilih...</option>
                                    <option value="nasional" {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="internasional" {{ old('tingkat') == 'internasional' ? 'selected' : '' }}>Internasional</option>
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

    <script>
 
    </script>
@endsection
