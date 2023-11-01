@extends('admin.layout.layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Rekognisi Dosen</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk menambahkan rekognisi.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Rekognisi Dosen</li>
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
                <a href="/prodi/akreditasi/rekognisi" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/akreditasi/rekognisi" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group mandatory">
                                <label for="rekognisi" class="form-label">Rekognisi</label>
                                <input class="form-control @error('rekognisi') is-invalid @enderror" type="text"
                                    name="rekognisi" value="{{ old('rekognisi') }}" required>
                                @error('rekognisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="dosen" class="form-label">Dosen (NIDN / NIDK)</label>
                                <input class="form-control @error('dosen') is-invalid @enderror" type="number"
                                    name="dosen" id="dosen" value="{{ old('dosen') }}" placeholder="ketik nidn / nidk" required>
                                @error('dosen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Rekognisi</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="bidang" class="form-label">Bidang</label>
                                <input class="form-control @error('bidang') is-invalid @enderror" type="text"
                                    name="bidang" value="{{ old('bidang') }}">
                                @error('bidang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                <input class="form-control @error('keterangan') is-invalid @enderror" type="text"
                                    name="keterangan" value="{{ old('keterangan') }}">
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="bukti" class="form-label">Bukti / Link (Opsional)</label>
                                <input class="form-control @error('bukti') is-invalid @enderror" type="text"
                                    name="bukti" value="{{ old('bukti') }}">
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

@endsection
