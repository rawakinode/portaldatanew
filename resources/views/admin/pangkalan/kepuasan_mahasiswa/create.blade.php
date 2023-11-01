@extends('admin.layout.layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Kepuasan Mahasiswa</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk menambahkan kepuasan mahasiswa.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Kepuasan Mahasiswa</li>
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
                <a href="/prodi/akreditasi/kepuasan_mahasiswa" class="float-end"><button class="btn btn-primary"><i
                            class="bi bi-card-list" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/akreditasi/kepuasan_mahasiswa" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="nim" class="form-label">NIM Mahasiswa</label>
                                <input class="form-control @error('nim') is-invalid @enderror" type="text"
                                    name="nim" value="{{ old('nim') }}" placeholder="Contoh: A10120005" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Data Tahun</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number"
                                    name="tahun" value="{{ old('tahun') }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="keandalan" class="form-label">Keandalan (reliability): kemampuan dosen, tenaga kependidikan, dan pengelola dalam memberikan pelayanan</label>
                                <select class="form-select" name="keandalan" id="keandalan">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ old('keandalan') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ old('keandalan') == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ old('keandalan') == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ old('keandalan') == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option> 
                                </select>
                                @error('keandalan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="daya_tanggap" class="form-label">Daya tanggap (responsiveness): kemauan dari dosen, tenaga kependidikan, dan pengelola dalam membantu mahasiswa dan memberikan jasa dengan cepat</label>
                                <select class="form-select" name="daya_tanggap" id="daya_tanggap">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ old('daya_tanggap') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ old('daya_tanggap') == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ old('daya_tanggap') == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ old('daya_tanggap') == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option> 
                                </select>
                                @error('daya_tanggap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="kepastian" class="form-label">Kepastian (assurance): kemampuan dosen, tenaga kependidikan, dan pengelola untuk memberi keyakinan kepada mahasiswa bahwa pelayanan yang diberikan telah sesuai dengan ketentuan</label>
                                <select class="form-select" name="kepastian" id="kepastian">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ old('kepastian') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ old('kepastian') == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ old('kepastian') == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ old('kepastian') == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option> 
                                </select>
                                @error('kepastian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="empati" class="form-label">Empati (empathy): kesediaan/kepedulian dosen, tenaga kependidikan, dan pengelola untuk memberi perhatian kepada mahasiswa</label>
                                <select class="form-select" name="empati" id="empati">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ old('empati') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ old('empati') == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ old('empati') == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ old('empati') == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option> 
                                </select>
                                @error('empati')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="nyata" class="form-label">Empati (empathy): kesediaan/kepedulian dosen, tenaga kependidikan, dan pengelola untuk memberi perhatian kepada mahasiswa</label>
                                <select class="form-select" name="nyata" id="nyata">
                                    <option value="">Pilih ...</option>
                                    <option value="sangat baik" {{ old('nyata') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                    </option>
                                    <option value="baik" {{ old('nyata') == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="cukup" {{ old('nyata') == 'cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="kurang" {{ old('nyata') == 'kurang' ? 'selected' : '' }}>Kurang
                                    </option> 
                                </select>
                                @error('nyata')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="tindak_lanjut" class="form-label">Tindak Lanjut oleh UPPS / PS</label>
                                <input class="form-control @error('tindak_lanjut') is-invalid @enderror" type="text"
                                    name="tindak_lanjut" value="{{ old('tindak_lanjut') }}" required>
                                @error('tindak_lanjut')
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
