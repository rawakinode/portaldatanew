@extends('admin.layout.layout')

@section('content')
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Jadwal Kuliah</h3>
            <p class="text-subtitle text-muted">Menampilkan jadwal kuliah program studi</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jadwal Kuliah</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--INCLUDE -->
    @include('trait._error')
    @include('trait._success')

    <section class="mt-2">
        <div class="card">
            <div class="card-body">
                <form action="/prodi/data/jadwalkuliah">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="form-group mandatory">
                                <label for="tahun" class="form-label">Tahun Ajaran</label>
                                <input class="form-control" type="number" name="tahun" value="{{ request('tahun') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select" name="semester" id="semester">
                                    <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Ganjil
                                    </option>
                                    <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Genap</option>
                                    <option value="3" {{ request('semester') == '3' ? 'selected' : '' }}>Antara
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="upload" class="form-label"></label>
                                <input class="form-control btn btn-primary mt-2" type="submit" value="Terapkan">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- menampilkan tabel dosen --}}
    <div class="card">
        <div class="row">
            <div class="col-sm">
                <h5 class="card-header">Daftar</h5>
            </div>
            <div class="col-sm mt-3" style="text-align: right">
                <a
                    href="/prodi/data/jadwalkuliah/create{{ request('tahun') ? '?tahun=' . request('tahun') : '' }}{{ request('tahun') ? '&semester=' . request('semester') : '' }}"><button
                        type="button" class="btn btn-primary" style="margin-right: 15px"><i class="bi bi-plus-square"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Jadwal</button></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">No</th>
                            <th>Kode MK</th>
                            <th>Nama MK</th>
                            <th>Kelas</th>
                            <th>Dosen Pengajar</th>
                            <th>Tahun Semester</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
    
                        @foreach ($jadwalkuliah as $jadwal)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td> {{ $jadwal['kode_mk'] }} </td>
                                <td>{{ Str::ucfirst($jadwal->mata_kuliah['nama']) }}</td>
                                <td>{{ $jadwal['kelas'] }}</td>
                                <td>
                                    @foreach ($jadwal->dosen_pengajar->sortBy('dosen_ke') as $dosen)
                                        {{ $dosen['dosen_nidn'] }} - {{ $dosen->rincian_dosen['nama'] ?? 'not_found' }} <br>
                                    @endforeach
    
                                </td>
                                <td>{{ $jadwal['tahun'] }}{{ $jadwal['semester'] }}</td>
                                <td>
                                    @if ($jadwal['hari'] == 1)
                                        Senin
                                    @elseif($jadwal['hari'] == 2)
                                        Selasa
                                    @elseif($jadwal['hari'] == 3)
                                        Rabu
                                    @elseif($jadwal['hari'] == 4)
                                        Kamis
                                    @elseif($jadwal['hari'] == 5)
                                        Jumat
                                    @elseif($jadwal['hari'] == 6)
                                        Sabtu
                                    @elseif($jadwal['hari'] == 7)
                                        Minggu
                                    @else
                                    @endif
                                </td>
                                <td>{{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }}</td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a
                                            href="/prodi/data/jadwalkuliah/{{ $jadwal->id }}/edit{{ request('tahun') ? '?tahun=' . request('tahun') : '' }}{{ request('tahun') ? '&semester=' . request('semester') : '' }}"><button
                                                type="button" class="btn btn-sm btn-icon btn-primary"
                                                style="margin-left: 5px"><i class="bi bi-pencil-fill"></i></button></a>
                                        <form action="/prodi/data/jadwalkuliah" method="post" style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" id="id" value="{{ $jadwal->id }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus jadwal matakuliah ?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
    
                                    </div>
                                </td>
                            </tr>
                        @endforeach
    
                        @if (count($jadwalkuliah) < 1)
                            <tr>
                                <td colspan="9" class="text-center">
                                    Tidak ada jadwal kuliah pada semester terpilih.
                                </td>
                            </tr>
                        @endif
    
                    </tbody>
                </table>
            </div>
        </div>


    </div>


    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'none'; //ignore error pop up
            $('#example').DataTable(); //show data tabel 
        });
    </script>
@endsection
