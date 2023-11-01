@extends('admin.layout.layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Perolehan Dana</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk menambahkan perolehan dana.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Perolehan Dana</li>
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
                <a href="/prodi/akreditasi/perolehan_dana" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/akreditasi/perolehan_dana" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="form-group mandatory">
                                <label for="judul" class="form-label">Judul / Nama</label>
                                <input class="form-control @error('judul') is-invalid @enderror" type="text"
                                    name="judul" value="{{ old('judul') }}" required>
                                @error('judul')
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
                                <label for="sumber" class="form-label">Sumber Dana</label>
                                <select class="form-select" name="sumber" id="sumber">
                                    <option value="">Pilih ...</option>
                                    <option value="mahasiswa" {{ old('sumber') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                                    </option>
                                    <option value="kementerian & yayasan"
                                        {{ old('sumber') == 'kementerian & yayasan' ? 'selected' : '' }}>Kementerian &
                                        Yayasan</option>
                                    <option value="perguruan tinggi"
                                        {{ old('sumber') == 'perguruan tinggi' ? 'selected' : '' }}>Perguruan Tinggi
                                    </option>
                                    <option value="sumber lain" {{ old('sumber') == 'sumber lain' ? 'selected' : '' }}>
                                        Sumber Lain</option>
                                </select>
                                @error('sumber')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-select" name="jenis" id="jenis">

                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="jumlah" class="form-label">Jumlah Dana</label>
                                <input class="form-control @error('jumlah') is-invalid @enderror" type="number"
                                    name="jumlah" value="{{ old('jumlah') }}" required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input class="form-control @error('keterangan') is-invalid @enderror" type="text"
                                    name="keterangan" value="{{ old('keterangan') }}" required>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="bukti" class="form-label">Bukti / Link</label>
                                <input class="form-control @error('bukti') is-invalid @enderror" type="text"
                                    name="bukti" value="{{ old('bukti') }}" required>
                                @error('bukti')
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
        var sumberSelect = document.getElementById("sumber");
        var jenisSelect = document.getElementById("jenis");

        sumberSelect.addEventListener("change", function() {
            jenisSelect.innerHTML = ""; // reset opsi jenis

            var sumberValue = sumberSelect.value;

            if (sumberValue === "mahasiswa") {
                jenisSelect.innerHTML += `
                    <option value="spp" {{ old('jenis') == 'spp' ? 'selected' : '' }}>SPP</option>
                    <option value="sumbangan lain" {{ old('jenis') == 'sumbangan lain' ? 'selected' : '' }}>Sumbangan Lain</option>
                    <option value="lain-lain" {{ old('jenis') == 'lain-lain' ? 'selected' : '' }}>Lain-Lain</option>
                `;
                } else if (sumberValue === "kementerian & yayasan") {
                                jenisSelect.innerHTML += `
                    <option value="anggaran rutin" {{ old('jenis') == 'anggaran rutin' ? 'selected' : '' }}>Anggaran Rutin</option>
                    <option value="anggaran pembangunan" {{ old('jenis') == 'anggaran pembangunan' ? 'selected' : '' }}>Anggaran Pembangunan</option>
                    <option value="hibah penelitian" {{ old('jenis') == 'hibah penelitian' ? 'selected' : '' }}>Hibah Penelitian</option>
                    <option value="hibak pkm" {{ old('jenis') == 'hibah pkm' ? 'selected' : '' }}>Hibah PKM</option>
                    <option value="lain-lain" {{ old('jenis') == 'lain-lain' ? 'selected' : '' }}>Lain-Lain</option>
                `;
                } else if (sumberValue === "perguruan tinggi") {
                                jenisSelect.innerHTML += `
                    <option value="jasa layanan profesi dan keahlian" {{ old('jenis') == 'jasa layanan profesi dan keahlian' ? 'selected' : '' }}>Jasa Layanan Profesi dan Keahlian</option>
                    <option value="produk institusi" {{ old('jenis') == 'produk institusi' ? 'selected' : '' }}>Produk Institusi</option>
                    <option value="kerjasama kelembagaan" {{ old('jenis') == 'kerjasama kelembagaan' ? 'selected' : '' }}>Kerjasama Kelembagaan</option>
                    <option value="lain-lain" {{ old('jenis') == 'lain-lain' ? 'selected' : '' }}>Lain-Lain</option>
                `;
                } else if (sumberValue === "sumber lain") {
                                jenisSelect.innerHTML += `
                    <option value="hibah" {{ old('jenis') == 'hibah' ? 'selected' : '' }}>Pinjaman Hibah</option>
                    <option value="dana lestari dan filantropis" {{ old('jenis') == 'dana lestari dan filantropis' ? 'selected' : '' }}>Dana Lestari dan Filantropis</option>
                    <option value="lain-lain" {{ old('jenis') == 'lain-lain' ? 'selected' : '' }}>Lain-Lain</option>
                `;
            }
        });
    </script>
@endsection
