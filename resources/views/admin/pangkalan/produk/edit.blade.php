@extends('admin.layout.layout')

@section('content')
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Produk / Jasa</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk edit Produk / Jasa.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Produk / Jasa</li>
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
                <a href="/prodi/akreditasi/produk" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/akreditasi/produk/{{ $produk['ids'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                       
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nidn" class="form-label">NIDN Dosen (Isi jika produk dihasilkan oleh dosen)</label>
                                <input class="form-control @error('nidn') is-invalid @enderror" type="text"
                                    name="nidn" value="{{ old('nidn') ?? $produk['nidn']}}" placeholder="Contoh: 003267832">
                                @error('nidn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nim" class="form-label">NIM Mahasiswa (Isi jika produk dihasilkan oleh mahasiswa)</label>
                                <input class="form-control @error('nim') is-invalid @enderror" type="text"
                                    name="nim" value="{{ old('nim') ?? $produk['nim']}}" placeholder="Contoh: A10121001">
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="produk" class="form-label">Nama Produk / Jasa</label>
                                <input class="form-control @error('produk') is-invalid @enderror" type="text"
                                    name="produk" value="{{ old('produk') ?? $produk['produk']}}" required>
                                @error('produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-group">
                                <label for="deskripsi" class="form-label">Deskripsi Produk / Jasa</label>
                                <input class="form-control @error('deskripsi') is-invalid @enderror" type="text"
                                    name="deskripsi" value="{{ old('deskripsi') ?? $produk['deskripsi']}}">
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') ?? $produk['tahun']}}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="bukti" class="form-label">Bukti / Link</label>
                                <input class="form-control @error('bukti') is-invalid @enderror" type="text"
                                    name="bukti" value="{{ old('bukti') ?? $produk['bukti']}}">
                                @error('bukti')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input class="form-control @error('keterangan') is-invalid @enderror" type="text"
                                    name="keterangan" value="{{ old('keterangan') ?? $produk['keterangan']}}">
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
