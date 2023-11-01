@extends('admin.layout.layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Data Seleksi Mahasiswa Baru</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk menambahkan data seleksi mahasiswa baru.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data Seleksi Mahasiswa Baru</li>
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
                <a href="/prodi/data/seleksi_mahasiswa_baru" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/data/seleksi_mahasiswa_baru" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Akademik</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') }}" placeholder="Contoh: 2020" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="daya_tampung" class="form-label">Daya Tampung</label>
                                <input class="form-control @error('daya_tampung') is-invalid @enderror" type="number"
                                    name="daya_tampung" value="{{ old('daya_tampung') }}" >
                                @error('daya_tampung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mahasiswa_mendaftar" class="form-label">Jumlah Calon Mahasiswa Pendaftar</label>
                                <input class="form-control @error('mahasiswa_mendaftar') is-invalid @enderror" type="number"
                                    name="mahasiswa_mendaftar" value="{{ old('mahasiswa_mendaftar') }}" >
                                @error('mahasiswa_mendaftar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mahasiswa_lulus_seleksi" class="form-label">Jumlah Calon Mahasiswa Lulus Seleksi</label>
                                <input class="form-control @error('mahasiswa_lulus_seleksi') is-invalid @enderror" type="number"
                                    name="mahasiswa_lulus_seleksi" value="{{ old('mahasiswa_lulus_seleksi') }}" >
                                @error('mahasiswa_lulus_seleksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mahasiswa_baru_reguler" class="form-label">Jumlah Mahasiswa Baru Reguler</label>
                                <input class="form-control @error('mahasiswa_baru_reguler') is-invalid @enderror" type="number"
                                    name="mahasiswa_baru_reguler" value="{{ old('mahasiswa_baru_reguler') }}" >
                                @error('mahasiswa_baru_reguler')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mahasiswa_baru_transfer" class="form-label">Jumlah Mahasiswa Baru Transfer</label>
                                <input class="form-control @error('mahasiswa_baru_transfer') is-invalid @enderror" type="number"
                                    name="mahasiswa_baru_transfer" value="{{ old('mahasiswa_baru_transfer') }}" >
                                @error('mahasiswa_baru_transfer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mahasiswa_aktif_reguler" class="form-label">Jumlah Mahasiswa Aktif Reguler</label>
                                <input class="form-control @error('mahasiswa_aktif_reguler') is-invalid @enderror" type="number"
                                    name="mahasiswa_aktif_reguler" value="{{ old('mahasiswa_aktif_reguler') }}" >
                                @error('mahasiswa_aktif_reguler')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mahasiswa_aktif_transfer" class="form-label">Jumlah Mahasiswa Aktif Transfer</label>
                                <input class="form-control @error('mahasiswa_aktif_transfer') is-invalid @enderror" type="number"
                                    name="mahasiswa_aktif_transfer" value="{{ old('mahasiswa_aktif_transfer') }}" >
                                @error('mahasiswa_aktif_transfer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mahasiswa_aktif_luar_provinsi" class="form-label">Jumlah Mahasiswa Aktif Luar Provinsi</label>
                                <input class="form-control @error('mahasiswa_aktif_luar_provinsi') is-invalid @enderror" type="number"
                                    name="mahasiswa_aktif_luar_provinsi" value="{{ old('mahasiswa_aktif_luar_provinsi') }}" >
                                @error('mahasiswa_aktif_luar_provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mahasiswa_aktif_luar_negeri" class="form-label">Jumlah Mahasiswa Aktif Luar Negeri</label>
                                <input class="form-control @error('mahasiswa_aktif_luar_negeri') is-invalid @enderror" type="number"
                                    name="mahasiswa_aktif_luar_negeri" value="{{ old('mahasiswa_aktif_luar_negeri') }}" >
                                @error('mahasiswa_aktif_luar_negeri')
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
