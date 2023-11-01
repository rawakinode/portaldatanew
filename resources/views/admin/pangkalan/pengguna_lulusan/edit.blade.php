@extends('admin.layout.layout')

@section('content')
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Kepuasan Pengguna</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk edit kepuasan pengguna lulusan.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Kepuasan Pengguna</li>
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
                <a href="/prodi/akreditasi/pengguna_lulusan" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/akreditasi/pengguna_lulusan/{{ $pengguna_lulusan['ids'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="nim" class="form-label">NIM Mahasiswa</label>
                                <input class="form-control @error('nim') is-invalid @enderror" type="text"
                                    name="nim" value="{{ old('nim') ?? $pengguna_lulusan['nim']}}" placeholder="Contoh: A10120005" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="nama_penilai" class="form-label">Nama Penilai</label>
                                <input class="form-control @error('nama_penilai') is-invalid @enderror" type="text"
                                    name="nama_penilai" value="{{ old('nama_penilai') ?? $pengguna_lulusan['nama_penilai']}}" required>
                                @error('nama_penilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="jabatan_penilai" class="form-label">Jabatan Penilai</label>
                                <input class="form-control @error('jabatan_penilai') is-invalid @enderror" type="text"
                                    name="jabatan_penilai" value="{{ old('jabatan_penilai') ?? $pengguna_lulusan['jabatan_penilai']}}" required>
                                @error('jabatan_penilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-8">
                            <div class="form-group mandatory">
                                <label for="instansi" class="form-label">Instansi Penilai</label>
                                <input class="form-control @error('instansi') is-invalid @enderror" type="text"
                                    name="instansi" value="{{ old('instansi') ?? $pengguna_lulusan['instansi']}}" required>
                                @error('instansi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Data Tahun</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') ?? $pengguna_lulusan['tahun']}}" placeholder="Contoh: 2019" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="etika" class="form-label">Etika Berperilaku</label>
                                <select class="form-select" name="etika" id="etika">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ $pengguna_lulusan['etika'] == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ $pengguna_lulusan['etika'] == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ $pengguna_lulusan['etika'] == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ $pengguna_lulusan['etika'] == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option>          
                                </select>
                                @error('etika')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="kompetensi_utama" class="form-label">Keahlian pada Kompetensi Utama</label>
                                <select class="form-select" name="kompetensi_utama" id="kompetensi_utama">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ $pengguna_lulusan['kompetensi_utama'] == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ $pengguna_lulusan['kompetensi_utama'] == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ $pengguna_lulusan['kompetensi_utama'] == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ $pengguna_lulusan['kompetensi_utama'] == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option>          
                                </select>
                                @error('kompetensi_utama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="bahasa_asing" class="form-label">Kemampuan Berbahasa Asing</label>
                                <select class="form-select" name="bahasa_asing" id="bahasa_asing">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ $pengguna_lulusan['bahasa_asing'] == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ $pengguna_lulusan['bahasa_asing'] == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ $pengguna_lulusan['bahasa_asing'] == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ $pengguna_lulusan['bahasa_asing'] == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option>          
                                </select>
                                @error('bahasa_asing')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="teknologi_informasi" class="form-label">Penggunaan Teknologi Informasi</label>
                                <select class="form-select" name="teknologi_informasi" id="teknologi_informasi">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ $pengguna_lulusan['teknologi_informasi'] == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ $pengguna_lulusan['teknologi_informasi'] == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ $pengguna_lulusan['teknologi_informasi'] == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ $pengguna_lulusan['teknologi_informasi'] == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option>          
                                </select>
                                @error('teknologi_informasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="komunikasi" class="form-label">Kemampuan Berkomunikasi</label>
                                <select class="form-select" name="komunikasi" id="komunikasi">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ $pengguna_lulusan['komunikasi'] == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ $pengguna_lulusan['komunikasi'] == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ $pengguna_lulusan['komunikasi'] == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ $pengguna_lulusan['komunikasi'] == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option>          
                                </select>
                                @error('komunikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="kerjasama" class="form-label">Kerjasama</label>
                                <select class="form-select" name="kerjasama" id="kerjasama">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ $pengguna_lulusan['kerjasama'] == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ $pengguna_lulusan['kerjasama'] == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ $pengguna_lulusan['kerjasama'] == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ $pengguna_lulusan['kerjasama'] == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option>          
                                </select>
                                @error('kerjasama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="pengembangan_diri" class="form-label">Pengembangan Diri</label>
                                <select class="form-select" name="pengembangan_diri" id="pengembangan_diri">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ $pengguna_lulusan['pengembangan_diri'] == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ $pengguna_lulusan['pengembangan_diri'] == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ $pengguna_lulusan['pengembangan_diri'] == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ $pengguna_lulusan['pengembangan_diri'] == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option>          
                                </select>
                                @error('pengembangan_diri')
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
