@extends('admin.layout.layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Audit Keuangan Eksternal</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk menambahkan audit keuangan eksternal.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Audit Keuangan Eksternal</li>
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
                <a href="/data/universitas/audit_keuangan_eksternal" class="float-end">
                    <button class="btn btn-primary">
                        <i class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar
                    </button>
                </a>
            </div>
        </div>
    </section>

    <section>
        <form action="/data/universitas/audit_keuangan_eksternal" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="lembaga" class="form-label">Lembaga Audit</label>
                                <input class="form-control @error('lembaga') is-invalid @enderror" type="text"
                                    name="lembaga" value="{{ old('lembaga') }}" required>
                                @error('lembaga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') }}" placeholder="Contoh: 2023" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="opini" class="form-label">Opini</label>
                                <input class="form-control @error('opini') is-invalid @enderror" type="text"
                                    name="opini" value="{{ old('opini') }}">
                                @error('opini')
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

                    </div>
                </div>
            </div>

            <input type="submit" value="" id="submit" hidden>
        </form>
    </section>

    <script>
 
    </script>
@endsection
