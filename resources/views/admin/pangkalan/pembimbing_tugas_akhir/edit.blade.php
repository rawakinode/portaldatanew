@extends('admin.layout.layout')

@section('content')
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Pembimbing Tugas Akhir</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk edit dosen pembimbing tugas akhir mahasiswa.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Pembimbing Tugas Akhir</li>
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
                <a href="/prodi/data/pembimbing_tugas_akhir" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/data/pembimbing_tugas_akhir/{{ $pembimbing_tugas_akhir['ids'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="nidn" class="form-label">NIDN Dosen (Pembimbing Utama)</label>
                                <input class="form-control @error('nidn') is-invalid @enderror" type="text"
                                    name="nidn" value="{{ old('nidn') ?? $pembimbing_tugas_akhir['nidn']}}" placeholder="Contoh: 003267832" required>
                                @error('nidn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="nim" class="form-label">NIM / Stambuk (Mahasiswa Bimbingan)</label>
                                <input class="form-control @error('nim') is-invalid @enderror" type="text"
                                    name="nim" value="{{ old('nim') ?? $pembimbing_tugas_akhir['nim']}}" placeholder="Contoh: A10121001" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="nama_mahasiswa" class="form-label">Nama (Mahasiswa Bimbingan)</label>
                                <input class="form-control @error('nama_mahasiswa') is-invalid @enderror" type="text"
                                    name="nama_mahasiswa" value="{{ old('nama_mahasiswa') ?? $pembimbing_tugas_akhir['nama_mahasiswa'] }}" required>
                                @error('nama_mahasiswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="judul" class="form-label">Judul Skripsi / Tesis</label>
                                <input class="form-control @error('judul') is-invalid @enderror" type="text"
                                    name="judul" value="{{ old('judul') ?? $pembimbing_tugas_akhir['judul'] }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') ?? $pembimbing_tugas_akhir['tahun'] }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nomor_sk_pembimbing" class="form-label">Nomor SK Pembimbing</label>
                                <input class="form-control @error('nomor_sk_pembimbing') is-invalid @enderror" type="text"
                                    name="nomor_sk_pembimbing" value="{{ old('nomor_sk_pembimbing') ?? $pembimbing_tugas_akhir['nomor_sk_pembimbing'] }}">
                                @error('nomor_sk_pembimbing')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input class="form-control @error('keterangan') is-invalid @enderror" type="text"
                                    name="keterangan" value="{{ old('keterangan') ?? $pembimbing_tugas_akhir['keterangan']}}">
                                @error('keterangan')
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
