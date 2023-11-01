@extends('admin.layout.layout')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Matakuliah</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir tambah mata kuliah</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Matakuliah</li>
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
                <a href="/prodi/data/kurikulum" class="float-end"><button class="btn btn-primary"><i class="bi bi-card-list"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/data/kurikulum/create" method="post">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mandatory">
                                <label for="kode" class="form-label">Kode Matakuliah</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text"
                                    name="kode" id="kode" value="{{ old('kode') }}" required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mandatory">
                                <label class="form-label" for="nama">Nama Matakuliah</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama" id="nama"
                                    value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mandatory">
                                <label class="form-label" for="status">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="">Pilih...</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Wajib</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Wajib</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mandatory">
                                <label class="form-label" for="jenis">Jenis MK</label>
                                <select class="form-select @error('jenis') is-invalid @enderror" name="jenis" id="jenis">
                                    <option value="">Pilih...</option>
                                    <option value="mku" {{ old('jenis') == 'mku' ? 'selected' : '' }}>MKU</option>
                                    <option value="inti" {{ old('jenis') == 'inti' ? 'selected' : '' }}>MK Inti Prodi</option>
                                    <option value="pilihan" {{ old('jenis') == 'pilihan' ? 'selected' : '' }}>MK Pilihan</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mandatory">
                                <label for="sks" class="form-label">SKS Total (Kuliah + Praktikum + Seminar)</label>
                                <input class="form-control @error('sks') is-invalid @enderror" type="number"
                                    name="sks" id="sks" value="{{ old('sks') }}" required>
                                @error('sks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="sks_praktikum" class="form-label">SKS Praktikum (jika ada)</label>
                                <input class="form-control @error('sks_praktikum') is-invalid @enderror" type="number"
                                    name="sks_praktikum" id="sks_praktikum" value="{{ old('sks_praktikum') ?? 0 }}">
                                @error('sks_praktikum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="sks_seminar" class="form-label">SKS Seminar (khusus mk seminar)</label>
                                <input class="form-control @error('sks_seminar') is-invalid @enderror" type="number"
                                    name="sks_seminar" id="sks_seminar" value="{{ old('sks_seminar') ?? 0 }}">
                                @error('sks_seminar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="konversi" class="form-label">Konversi Kredit ke Jam</label>
                                <input class="form-control @error('konversi') is-invalid @enderror" type="text"
                                    name="konversi" id="konversi" value="{{ old('konversi') ?? 0 }}" pattern="[0-9]+([\.][0-9]+)?">
                                @error('konversi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mandatory">
                                <label for="semester" class="form-label">Semester</label>
                                <input class="form-control @error('semester') is-invalid @enderror" type="number"
                                    name="semester" id="semester" value="{{ old('semester') }}" required>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    
                    <div class="card">
                        <div class="card-header">
                            <h4>Capaian Pembelajaran</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="capaian_sikap">Sikap</label>
                                        <select class="form-select @error('capaian_sikap') is-invalid @enderror" name="capaian_sikap" id="capaian_sikap">
                                            <option value="">Pilih...</option>
                                            <option value="1" {{ old('capaian_sikap') == '1' ? 'selected' : '' }}>Ada</option>
                                            <option value="0" {{ old('capaian_sikap') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                                        </select>
                                        @error('capaian_sikap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="capaian_pengetahuan">Pengetahuan</label>
                                        <select class="form-select @error('capaian_pengetahuan') is-invalid @enderror" name="capaian_pengetahuan" id="capaian_pengetahuan">
                                            <option value="">Pilih...</option>
                                            <option value="1" {{ old('capaian_pengetahuan') == '1' ? 'selected' : '' }}>Ada</option>
                                            <option value="0" {{ old('capaian_pengetahuan') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                                        </select>
                                        @error('capaian_pengetahuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="capaian_keterampilan_umum">Keterampilan Umum</label>
                                        <select class="form-select @error('capaian_keterampilan_umum') is-invalid @enderror" name="capaian_keterampilan_umum" id="capaian_keterampilan_umum">
                                            <option value="">Pilih...</option>
                                            <option value="1" {{ old('capaian_keterampilan_umum') == '1' ? 'selected' : '' }}>Ada</option>
                                            <option value="0" {{ old('capaian_keterampilan_umum') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                                        </select>
                                        @error('capaian_keterampilan_umum')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="capaian_keterampilan_khusus">Keterampilan Khusus</label>
                                        <select class="form-select @error('capaian_keterampilan_khusus') is-invalid @enderror" name="capaian_keterampilan_khusus" id="capaian_keterampilan_khusus">
                                            <option value="">Pilih...</option>
                                            <option value="1" {{ old('capaian_keterampilan_khusus') == '1' ? 'selected' : '' }}>Ada</option>
                                            <option value="0" {{ old('capaian_keterampilan_khusus') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                                        </select>
                                        @error('capaian_keterampilan_khusus')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="jenis_dokumen">Dokumen Rencana Pembelajaran</label>
                                        <input class="form-control @error('jenis_dokumen') is-invalid @enderror" type="text" name="jenis_dokumen" id="jenis_dokumen"
                                            value="{{ old('jenis_dokumen') }}" placeholder="Contoh: RPS">
                                        @error('jenis_dokumen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="unit_penyelenggara">Unit Penyelenggara</label>
                                        <input class="form-control @error('unit_penyelenggara') is-invalid @enderror" type="text" name="unit_penyelenggara" id="unit_penyelenggara"
                                            value="{{ old('unit_penyelenggara') }}" placeholder="Contoh: Program Studi">
                                        @error('unit_penyelenggara')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
                            
                            
                        </div>
                    </div>
                </div>

            </div>
            <input type="submit" value="" id="submit" hidden>
        </form>
    </section>

    <script></script>
@endsection
