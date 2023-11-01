@extends('admin.layout.layout')

@section('content')

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Jadwal Kuliah</h3>
            <p class="text-subtitle text-muted">Lengkapi formulir tambah jadwal kuliah</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Jadwal Kuliah</li>
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
                        style="margin-right:7px;position: relative;top: -1px;"></i> Update</button>
                <a href="/prodi/data/jadwalkuliah{{ request('tahun') ? '?tahun=' . request('tahun') : '' }}{{ request('tahun') ? '&semester=' . request('semester') : '' }}"
                    class="float-end"><button class="btn btn-primary"><i class="bi bi-card-list"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Daftar</button></a>
            </div>
        </div>
    </section>

    <section>
        <form action="/prodi/data/jadwalkuliah/{{ $jadwal['id'] }}/edit" method="post">
            @csrf
            <div class="card" style="margin-bottom: 18px">
                <div class="card-header">
                    <h4>Rincian</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group mandatory">
                                <label for="kode_mk" class="form-label">Kode MK</label>
                                <input class="form-control @error('kode_mk') is-invalid @enderror" type="text"
                                    name="kode_mk" id="kode_mk" value="{{ old('kode_mk') ?? $jadwal['kode_mk'] ?? ''}}" required>
                                @error('kode_mk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group mandatory">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input class="form-control @error('kelas') is-invalid @enderror" type="text"
                                    name="kelas" id="kelas" value="{{ old('kelas') ?? $jadwal['kelas'] ?? ''}}" required>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group mandatory">
                                <label for="ruang" class="form-label">Ruangan</label>
                                <input class="form-control @error('ruang') is-invalid @enderror" type="text"
                                    name="ruang" id="ruang" value="{{ old('ruang') ?? $jadwal['ruang'] ?? '' }}" required>
                                @error('ruang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group mandatory">
                                <label for="hari" class="form-label">Hari</label>
                                <select class="form-select @error('hari') is-invalid @enderror" name="hari" id="hari">
                                    <option value="">Pilih...</option>
                                    <option value="1" {{ old('hari') == '1' || $jadwal['hari'] == '1' ? 'selected' : '' }}>Senin</option>
                                    <option value="2" {{ old('hari') == '2' || $jadwal['hari'] == '2' ? 'selected' : '' }}>Selasa</option>
                                    <option value="3" {{ old('hari') == '3' || $jadwal['hari'] == '3' ? 'selected' : '' }}>Rabu</option>
                                    <option value="4" {{ old('hari') == '4' || $jadwal['hari'] == '4' ? 'selected' : '' }}>Kamis</option>
                                    <option value="5" {{ old('hari') == '5' || $jadwal['hari'] == '5' ? 'selected' : '' }}>Jumat</option>
                                    <option value="6" {{ old('hari') == '6' || $jadwal['hari'] == '6' ? 'selected' : '' }}>Sabtu</option>
                                    <option value="7" {{ old('hari') == '7' || $jadwal['hari'] == '7' ? 'selected' : '' }}>Minggu</option>
                                </select>
                                @error('hari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input class="form-control @error('jam_mulai') is-invalid @enderror" type="time"
                                    name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') ?? $jadwal['jam_mulai'] ?? ''}}">
                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input class="form-control @error('jam_selesai') is-invalid @enderror" type="time"
                                    name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') ?? $jadwal['jam_selesai'] ?? ''}}">
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="dosen1" class="form-label">Dosen Pengampu 1</label>
                                <select class="form-select" name="dosen1" id="dosen1">
                                    @if($pengajar->where('dosen_ke', 1)->first())
                                        <option value="{{ $pengajar->where('dosen_ke', 1)->first()['dosen_nidn'] }}">
                                            {{ $pengajar->where('dosen_ke', 1)->first()->rincian_dosen['nama'] }} - {{ $pengajar->where('dosen_ke', 1)->first()['dosen_nidn'] }}
                                        </option>
                                    @endif
                                </select>
                                <button class="form-control btn btn-primary mt-2" type="button"
                                    onclick="tambahdosen('1')">Pilih Dosen</button>
                                <button id="hapus_btn_1" class="form-control btn btn-danger mt-2" type="button"
                                    onclick="hapusdosen('1')" style="display: {{ $pengajar->where('dosen_ke', 1)->first() ? 'block' : 'none' }}">Hapus</button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="dosen2" class="form-label">Dosen Pengampu 2</label>
                                <select class="form-select" name="dosen2" id="dosen2">
                                    @if($pengajar->where('dosen_ke', 2)->first())
                                        <option value="{{ $pengajar->where('dosen_ke', 2)->first()['dosen_nidn'] }}">
                                            {{ $pengajar->where('dosen_ke', 2)->first()->rincian_dosen['nama'] }} - {{ $pengajar->where('dosen_ke', 2)->first()['dosen_nidn'] }}
                                        </option>
                                    @endif
                                </select>
                                <button class="form-control btn btn-primary mt-2" type="button"
                                    onclick="tambahdosen('2')">Pilih Dosen</button>
                                <button id="hapus_btn_2" class="form-control btn btn-danger mt-2" type="button"
                                    onclick="hapusdosen('2')" style="display: {{ $pengajar->where('dosen_ke', 2)->first() ? 'block' : 'none' }}">Hapus</button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="dosen3" class="form-label">Dosen Pengampu 3</label>
                                <select class="form-select" name="dosen3" id="dosen3">
                                    @if($pengajar->where('dosen_ke', 3)->first())
                                        <option value="{{ $pengajar->where('dosen_ke', 3)->first()['dosen_nidn'] }}">
                                            {{ $pengajar->where('dosen_ke', 3)->first()->rincian_dosen['nama'] }} - {{ $pengajar->where('dosen_ke', 3)->first()['dosen_nidn'] }}
                                        </option>
                                    @endif
                                </select>
                                <button class="form-control btn btn-primary mt-2" type="button"
                                    onclick="tambahdosen('3')">Pilih Dosen</button>
                                <button id="hapus_btn_3" class="form-control btn btn-danger mt-2" type="button"
                                    onclick="hapusdosen('3')" style="display: {{ $pengajar->where('dosen_ke', 3)->first() ? 'block' : 'none' }}">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" value="" id="submit" hidden>
        </form>
    </section>

    <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#default"
        style="display: none" id="show_modal"> Launch Modal </button>

    <div class="modal fade text-left" id="default" tabindex="-1" aria-labelledby="myModalLabel1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1"></h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="dosen_ke" id="dosen_ke" value="">
                        <input class="form-control" type="text" name="search_dosen" id="search_dosen"
                            placeholder="Ketik nama / nidn" onkeyup="get_dosen_list()">
                    </div>
                    <div class="list-group mb-3" id="dosen_list">

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/pages/jquery-3.6.1.min.js') }}"></script>
    <script>
        function tambahdosen(p) {
            document.getElementById('myModalLabel1').innerText = 'Tambah Dosen Pengampu ' + p;
            document.getElementById('dosen_ke').value = p;
            document.querySelector('#show_modal').click();
        }

        //AJAX Untuk mendapatkan data
        function get_dosen_list() {

            var keyword = document.getElementById('search_dosen').value;
            var token = '{{ csrf_token() }}';

            $.ajax({
                type: 'POST',
                url: "/prodi/data/jadwalkuliah/get_dosen_list",
                data: {
                    keyword: keyword,
                    _token: token
                },
                dataType: 'json',
                success: function(data) {
                    jsontolist(data);
                    console.log(data);
                }
            });
        }

        function jsontolist(d) {
            $("#dosen_list").empty();
            var m = d.data;
            
            for (let i = 0; i < m.length; i++) {
                const el = m[i];
                var htm = '<span class="list-group-item">'+el.nama+' - '+el.nidn+'<button data-bs-dismiss="modal"class="btn btn-sm btn-primary float-end" value="'+btoa(JSON.stringify(el))+'" onclick="pilih_dosen(this.value)">Pilih</button></span>';
                $("#dosen_list").append(htm);
                console.log(el);
            }   
        }

        function pilih_dosen(s) {
            var m = JSON.parse(atob(s));
            var c = document.getElementById('dosen_ke').value;

            if (c == 1) {
                $("#dosen1").empty();
                $("#dosen1").append('<option value="'+m.nidn+'" selected>'+m.nama+' - '+m.nidn+'</option>');
                $("#hapus_btn_1").show();
            }else if(c == 2) {
                $("#dosen2").empty();
                $("#dosen2").append('<option value="'+m.nidn+'" selected>'+m.nama+' - '+m.nidn+'</option>');
                $("#hapus_btn_2").show();
            }else if(c == 3) {
                $("#dosen3").empty();
                $("#dosen3").append('<option value="'+m.nidn+'" selected>'+m.nama+' - '+m.nidn+'</option>');
                $("#hapus_btn_3").show();
            }
        }

        function hapusdosen(p) {
            if (p == 1) {
                $("#dosen1").empty();
                $("#hapus_btn_1").hide();
            } else if(p == 2){
                $("#dosen2").empty();
                $("#hapus_btn_2").hide();
            } else if(p == 3){
                $("#dosen3").empty();
                $("#hapus_btn_3").hide();
            }
        }

    </script>
@endsection
