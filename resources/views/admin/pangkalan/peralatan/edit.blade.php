@extends('admin.layout.layout')

@section('content')
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Peralatan Laboratorium</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk edit peralatan laboratorium.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Peralatan Laboratorium</li>
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
                <a href="/prodi/akreditasi/peralatan_laboratorium" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/akreditasi/peralatan_laboratorium/{{ $peralatan['ids'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        
                        
                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="nama" class="form-label">Nama Alat</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                    name="nama" value="{{ old('nama') ?? $peralatan['nama']}}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="fungsi" class="form-label">Fungsi</label>
                                <input class="form-control @error('fungsi') is-invalid @enderror" type="text"
                                    name="fungsi" value="{{ old('fungsi') ?? $peralatan['fungsi']}}" required>
                                @error('fungsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Pengadaan</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') ?? $peralatan['tahun']}}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-9">
                            <div class="form-group mandatory">
                                <label for="lokasi" class="form-label">Lokasi / Tempat</label>
                                <input class="form-control @error('lokasi') is-invalid @enderror" type="text"
                                    name="lokasi" value="{{ old('lokasi') ?? $peralatan['lokasi']}}" required>
                                @error('lokasi')
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
