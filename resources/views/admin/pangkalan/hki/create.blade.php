@extends('admin.layout.layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah HKI</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk menambahkan HKI dosen atau mahasiswa.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah HKI</li>
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
                <a href="/prodi/akreditasi/hki" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/akreditasi/hki" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nidn" class="form-label">NIDN Dosen (Isi jika HKI dihasilkan oleh dosen)</label>
                                <input class="form-control @error('nidn') is-invalid @enderror" type="text"
                                    name="nidn" value="{{ old('nidn') }}" placeholder="Contoh: 003267832">
                                @error('nidn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nim" class="form-label">NIM Mahasiswa (Isi jika HKI dihasilkan oleh mahasiswa)</label>
                                <input class="form-control @error('nim') is-invalid @enderror" type="text"
                                    name="nim" value="{{ old('nim') }}" placeholder="Contoh: A10121001">
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="judul" class="form-label">Judul HKI</label>
                                <input class="form-control @error('judul') is-invalid @enderror" type="text"
                                    name="judul" value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                <input class="form-control @error('keterangan') is-invalid @enderror" type="text"
                                    name="keterangan" value="{{ old('keterangan') }}" >
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="bukti" class="form-label">Bukti / Link (Opsional)</label>
                                <input class="form-control @error('bukti') is-invalid @enderror" type="text"
                                    name="bukti" value="{{ old('bukti') }}" >
                                @error('bukti')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Perolehan</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="nomor" class="form-label">Nomor Permohonan</label>
                                <input class="form-control @error('nomor') is-invalid @enderror" type="text"
                                    name="nomor" value="{{ old('nomor') }}" required>
                                @error('nomor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-select" name="jenis" id="jenis">
                                    <option value="">Pilih ...</option>
                                    <option value="hak cipta">Hak Cipta</option>
                                    <option value="merek">Merek</option>
                                    <option value="paten">Paten</option>
                                    <option value="paten sederhana">Paten Sederhana</option>
                                    <option value="desain industri">Desain Industri</option>
                                    <option value="indikasi geografis">Indikasi Geografis</option>
                                    <option value="perlindungan varietas tanaman">Perlindungan Varietas Tanaman</option>
                                    <option value="desain tata letak sirkuit terpadu">Desain Tata Letak Sirkuit Terpadu</option>
                                    <option value="teknologi tepat guna">Teknologi Tepat Guna</option>
                                    <option value="produk">Produk</option>
                                    <option value="karya seni">Karya Seni</option>
                                    <option value="rekayasa sosial">Rekayasa Sosial</option>
                                </select>
                                @error('jenis')
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
