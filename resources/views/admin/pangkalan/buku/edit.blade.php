@extends('admin.layout.layout')

@section('content')
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Buku</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk edit buku yang di hasilkan oleh dosen atau mahasiswa.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
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
                        style="margin-right:7px;position: relative;top: -1px;"></i> Perbarui</button>
                <a href="/prodi/akreditasi/buku" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/akreditasi/buku/{{ $buku['ids'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nidn" class="form-label">NIDN Dosen (Isi jika buku dihasilkan oleh dosen)</label>
                                <input class="form-control @error('nidn') is-invalid @enderror" type="text"
                                    name="nidn" value="{{ old('nidn') ?? $buku['nidn'] }}" placeholder="Contoh: 003267832">
                                @error('nidn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nim" class="form-label">NIM Mahasiswa (Isi jika buku dihasilkan oleh mahasiswa)</label>
                                <input class="form-control @error('nim') is-invalid @enderror" type="text"
                                    name="nim" value="{{ old('nim') ?? $buku['nim'] }}" placeholder="Contoh: A10121001">
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="judul" class="form-label">Judul / Nama Buku</label>
                                <input class="form-control @error('judul') is-invalid @enderror" type="text"
                                    name="judul" value="{{ old('judul') ?? $buku['judul'] }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="deskripsi" class="form-label">Deskripsi Buku</label>
                                <input class="form-control @error('deskripsi') is-invalid @enderror" type="text"
                                    name="deskripsi" value="{{ old('deskripsi') ?? $buku['deskripsi'] }}" required>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input class="form-control @error('isbn') is-invalid @enderror" type="number"
                                    name="isbn" value="{{ old('isbn') ?? $buku['isbn'] }}" placeholder="Contoh: 9786230132674" required>
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="penerbit" class="form-label">Penerbit</label>
                                <input class="form-control @error('penerbit') is-invalid @enderror" type="text"
                                    name="penerbit" value="{{ old('penerbit') ?? $buku['penerbit'] }}" required>
                                @error('penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="kota" class="form-label">Kota</label>
                                <input class="form-control @error('kota') is-invalid @enderror" type="text"
                                    name="kota" value="{{ old('kota') ?? $buku['kota'] }}" required>
                                @error('kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Terbit</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') ?? $buku['tahun'] }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" id="kategori" required>
                                    <option value="">Pilih...</option>
                                    <option value="buku ajar" {{ $buku['kategori']  == 'buku ajar' ? 'selected' : '' }}>Buku Ajar</option>
                                    <option value="buku referensi" {{ $buku['kategori']  == 'buku referensi' ? 'selected' : '' }}>Buku Referensi</option>
                                    <option value="buku monograf" {{ $buku['kategori']  == 'buku monograf' ? 'selected' : '' }}>Buku Monograf</option>
                                    <option value="lainnya" {{ $buku['kategori']  == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input class="form-control @error('keterangan') is-invalid @enderror" type="text"
                                name="keterangan" value="{{ old('keterangan') ?? $buku['keterangan']}}">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="bukti" class="form-label">Bukti / Link</label>
                            <input class="form-control @error('bukti') is-invalid @enderror" type="text"
                                name="bukti" value="{{ old('bukti') ?? $buku['bukti']}}">
                            @error('bukti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                </div>
            </div>

            <input type="submit" value="" id="submit" hidden>
        </form>
    </section>


@endsection
