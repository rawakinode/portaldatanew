@extends('admin.layout.layout')

@section('content')

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Mahasiswa</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk edit mahasiswa</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Mahasiswa</li>
                </ol>
            </nav>
        </div>
    </div>

    @include('trait._success')

    <section class="mb-3">
        <div class="row">
            <div class="col">
                <button onclick="document.getElementById('submit').click();" class="btn btn-success float-end"
                    style="margin-left: 5px"><i class="bi bi-check-square-fill"
                        style="margin-right:7px;position: relative;top: -1px;"></i> Simpan</button>
                <a href="/prodi/data/mahasiswa"
                    class="float-end"><button class="btn btn-primary"><i class="bi bi-card-list"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/data/mahasiswa/{{ $mahasiswa['id'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                                <input class="form-control @error('tahun_masuk') is-invalid @enderror" type="number" name="tahun_masuk"
                                    value="{{ old('tahun_masuk') ?? $mahasiswa['tahun_masuk'] }}" required>
                                @error('tahun_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="jalur_masuk" class="form-label">Jalur Masuk</label>
                                <select class="form-select @error('jalur_masuk') is-invalid @enderror" name="jalur_masuk" id="jalur_masuk" required>
                                    <option value="">Pilih...</option>
                                    <option value="snmptn" {{ $mahasiswa['jalur_masuk'] == 'snmptn' ? 'selected' : '' }}>SNMPTN
                                    </option>
                                    <option value="sbmptn" {{ $mahasiswa['jalur_masuk'] == 'sbmptn' ? 'selected' : '' }}>SBMPTN</option>
                                    <option value="smmptn" {{ $mahasiswa['jalur_masuk'] == 'smmptn' ? 'selected' : '' }}>SMMPTN</option>
                                    <option value="lainnya" {{ $mahasiswa['jalur_masuk'] == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jalur_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="daftar_ulang" class="form-label">Mendaftar Ulang ?</label>
                                <select class="form-select @error('daftar_ulang') is-invalid @enderror" name="daftar_ulang" id="daftar_ulang" required>
                                    <option value="">Pilih...</option>
                                    <option value="1" {{ $mahasiswa['daftar_ulang'] == '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ $mahasiswa['daftar_ulang'] == '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                                @error('daftar_ulang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="bidikmisi" class="form-label">Penerima Bidikmisi</label>
                                <select class="form-select @error('bidikmisi') is-invalid @enderror" name="bidikmisi" id="bidikmisi" required>
                                    <option value="0" {{ old('bidikmisi') || $mahasiswa['bidikmisi'] == '0' ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ old('bidikmisi') || $mahasiswa['bidikmisi'] == '1' ? 'selected' : '' }}>Ya</option>
                                </select>
                                @error('bidikmisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="nama" class="form-label">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                    name="nama" id="nama" value="{{ old('nama') ?? $mahasiswa['nama']}}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nim" class="form-label">NIM / Stambuk</label>
                                <input class="form-control @error('nim') is-invalid @enderror" type="text"
                                    name="nim" id="nim" value="{{ old('nim') ?? $mahasiswa['nim'] }}" placeholder="ex : A10122001">
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('kelamin') is-invalid @enderror" name="kelamin" id="kelamin" required>
                                    <option value="">Pilih...</option>
                                    <option value="1" {{ $mahasiswa['kelamin'] == '1' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="0" {{ $mahasiswa['kelamin'] == '0' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('hari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mandatory">
                                <label for="asing" class="form-label">Mahasiswa Asing</label>
                                <select class="form-select @error('asing') is-invalid @enderror" name="asing" id="asing" required>
                                    <option value="0" {{ old('asing') || $mahasiswa['asing'] == '0' ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ old('asing') || $mahasiswa['asing'] == '1' ? 'selected' : '' }}>Ya</option>
                                </select>
                                @error('asing')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="asing_part_time" class="form-label">Mahasiswa Asing Paruh Waktu (Part Time)</label>
                                <select class="form-select @error('asing_part_time') is-invalid @enderror" name="asing_part_time" id="asing_part_time">
                                    <option value="">Pilih...</option>
                                    <option value="0" {{ $mahasiswa['asing_part_time'] == '0' ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ $mahasiswa['asing_part_time'] == '1' ? 'selected' : '' }}>Ya</option>
                                </select>
                                @error('asing_part_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom: 18px">
                <div class="card-header">
                    <h4>Mahasiswa Lulus / Keluar</h4>
                </div>
                <div class="card-body">
                    <div class="row"> 
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="tahun_keluar" class="form-label">Tahun Keluar / Lulus</label>
                                <input class="form-control @error('tahun_keluar') is-invalid @enderror" type="number"
                                    name="tahun_keluar" id="tahun_keluar" value="{{ old('tahun_keluar') ?? $mahasiswa['tahun_keluar']}}">
                                @error('tahun_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="status_keluar" class="form-label">Status Keluar / Lulus</label>
                                <select class="form-select @error('kelamin') is-invalid @enderror" name="status_keluar" id="status_keluar">
                                    <option value="">Pilih...</option>
                                    <option value="lulus" {{ $mahasiswa['status_keluar'] == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                    <option value="mengundurkan diri" {{ $mahasiswa['status_keluar'] == 'mengundurkan diri' ? 'selected' : '' }}>Mengundurkan diri</option>
                                    <option value="dropout" {{ $mahasiswa['status_keluar'] == 'dropout' ? 'selected' : '' }}>Dropout</option>
                                    <option value="hilang" {{ $mahasiswa['status_keluar'] == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                    <option value="lainnya" {{ $mahasiswa['status_keluar'] == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('hari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="ipk" class="form-label">IPK Lulus</label>
                                <input class="form-control @error('ipk') is-invalid @enderror" type="text"
                                    name="ipk" id="ipk" value="{{ old('ipk') ?? $mahasiswa['ipk']}}" placeholder="3.35" pattern="[0-9]+([\.][0-9]+)?" title="IPK harus dalam format numerik (contoh: 3.85)">
                                @error('ipk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="masastudi" class="form-label">Lama Studi (Jumlah Bulan)</label>
                                <input class="form-control @error('masastudi') is-invalid @enderror" type="number"
                                    name="masastudi" id="masastudi" value="{{ old('masastudi') ?? $mahasiswa['masastudi']}}" placeholder="Contoh: 48">
                                @error('masastudi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="tanggal_yudisium" class="form-label">Tanggal Yudisium</label>
                                <input class="form-control @error('tanggal_yudisium') is-invalid @enderror" type="date"
                                    name="tanggal_yudisium" id="tanggal_yudisium" value="{{ old('tanggal_yudisium') ?? $mahasiswa['tanggal_yudisium']}}" >
                                @error('tanggal_yudisium')
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
