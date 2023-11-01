@extends('admin.layout.layout')

@section('content')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Penelitian</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir untuk menambahkan penelitian.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Penelitian</li>
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
                <a href="/prodi/data/penelitian"
                    class="float-end"><button class="btn btn-primary"><i class="bi bi-card-list"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/data/penelitian" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group mandatory">
                                <label for="judul" class="form-label">Judul Penelitian</label>
                                <input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul"
                                    value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group mandatory">
                                <label for="tema" class="form-label">Tema Sesuai Roadmap</label>
                                <input class="form-control @error('tema') is-invalid @enderror" type="text" name="tema"
                                    value="{{ old('tema') }}" required>
                                @error('tema')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="rujukan_tema" class="form-label">Judul Tesis / Disertasi (Isi jika penelitian ini dirujuk menjadi Tesis / Disertasi Mahasiswa) (Opsional)</label>
                                <input class="form-control @error('rujukan_tema') is-invalid @enderror" type="text" name="rujukan_tema"
                                    value="{{ old('rujukan_tema') }}">
                                @error('rujukan_tema')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="integrasi_pembelajaran" class="form-label">Integrasi Kegiatan Penelitian dalam Pembelajaran (Opsional)</label>
                                <input class="form-control @error('integrasi_pembelajaran') is-invalid @enderror" type="text" name="integrasi_pembelajaran"
                                    value="{{ old('integrasi_pembelajaran') }}">
                                @error('integrasi_pembelajaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Penelitian</label>
                                <input class="form-control @error('tahun') is-invalid @enderror" type="number" name="tahun"
                                    value="{{ old('tahun') }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="sumber_dana" class="form-label">Sumber Dana</label>
                                <select class="form-select @error('sumber_dana') is-invalid @enderror" name="sumber_dana" id="sumber_dana" required>
                                    <option value="">Pilih...</option>
                                    <option value="mandiri" {{ old('sumber_dana') == 'mandiri' ? 'selected' : '' }}>Mandiri
                                    </option>
                                    <option value="perguruan tinggi" {{ old('sumber_dana') == 'perguruan tinggi' ? 'selected' : '' }}>Perguruan Tinggi</option>
                                    <option value="nasional" {{ old('sumber_dana') == 'nasional' ? 'selected' : '' }}>Nasional Tinggi</option>
                                    <option value="internasional" {{ old('sumber_dana') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                                @error('sumber_dana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="jumlah_dana" class="form-label">Jumlah Dana</label>
                                <input class="form-control @error('jumlah_dana') is-invalid @enderror" type="number" name="jumlah_dana" value="{{ old('jumlah_dana') }}">
                                @error('jumlah_dana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="row" style="margin-bottom: -20px">
                            <div class="col-6">
                                <div class="card-header">
                                    <h4>Dosen Peneliti</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-header">
                                    <button type="button" class="btn btn-sm btn-primary float-end" onclick="tambahdosen()">Tambah Peneliti</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="list_dosen_peneliti">
                            {{-- tempat menaruh list --}}
                            
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="row" style="margin-bottom: -20px">
                            <div class="col-7">
                                <div class="card-header">
                                    <h4>Mahasiswa Terlibat</h4>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="card-header">
                                    <button type="button" class="btn btn-sm btn-primary float-end" onclick="tambahmahasiswa()">Tambah Mahasiswa</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="list_mahasiswa_peneliti">

                        </div>
                    </div>
                </div>

            </div>
            
            <input type="submit" value="" id="submit" hidden>
        </form>
    </section>

    <script>

        function tambahdosen() {
            var random = Math.random().toString(36).substring(2,10);
            var element = '<div class="row mb-3" id="'+random+'"> <div class="col-12"> <div class="form-group"> <input class="form-control" type="text" name="nidn[]" value="" placeholder="NIDN / NIDK" required> </div> </div> <div class="col-12"> <div class="form-group"> <input class="form-control" type="text" name="dosen[]" value="" placeholder="Nama Dosen" required> </div> </div> <div class="col-12"> <button value="'+random+'" type="button" onclick="hapus_list(this.value)" class="btn btn-sm btn-danger float-end" style="margin-left: 5px"><i class="bi bi-trash-fill" style="position: relative;top: -1px;"></i></button> </div> </div>';

            $('#list_dosen_peneliti').append(element);
        }

        function tambahmahasiswa() {
            var random = Math.random().toString(36).substring(2,10);
            var element = '<div class="row mb-3" id="'+random+'"> <div class="col-12"> <div class="form-group"> <input class="form-control" type="text" name="nim[]" value="" placeholder="NIM / Stambuk" required> </div> </div> <div class="col-12"> <div class="form-group"> <input class="form-control" type="text" name="mahasiswa[]" value="" placeholder="Nama Mahasiswa" required> </div> </div> <div class="col-12"> <button value="'+random+'" type="button" onclick="hapus_list(this.value)" class="btn btn-sm btn-danger float-end" style="margin-left: 5px"><i class="bi bi-trash-fill" style="position: relative;top: -1px;"></i></button> </div> </div>';

            $('#list_mahasiswa_peneliti').append(element);
        }

        function hapus_list(e) {
            $('#'+e).remove();
        }

    </script>

@endsection
