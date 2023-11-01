@extends('admin.layout.layout')

@section('content')
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Semua Mahasiswa</h3>
            <p class="text-subtitle text-muted">Menampilkan semua mahasiswa baru & daftar ulang program studi</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Semua Mahasiswa</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--INCLUDE -->
    @include('trait._success')

    <section class="mt-2">
        <div class="card">
            <div class="card-body">
                <form action="/prodi/data/mahasiswa">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="form-group mandatory">
                                <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                                <input class="form-control" type="number" name="tahun_masuk" value="{{ request('tahun_masuk') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mandatory">
                                <label for="daftar_ulang" class="form-label">Mendaftar Ulang</label>
                                <select class="form-select" name="daftar_ulang" id="daftar_ulang">
                                    <option value="1" {{ request('daftar_ulang') == '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ request('daftar_ulang') == '0' ? 'selected' : '' }}>Tidak</option>
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
                <h5 class="card-header">Daftar Mahasiswa</h5>
            </div>
            <div class="col-sm mt-3" style="text-align: right">
                <a
                    href="/prodi/data/mahasiswa/create"><button
                        type="button" class="btn btn-primary" style="margin-right: 15px"><i class="bi bi-plus-square"
                            style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Mahasiswa</button></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Daftar Ulang</th>
                            <th>Angkatan</th>
                            <th>Kelamin</th>
                            <th>Bidikmisi</th>
                            <th>Mahasiswa Asing</th>
                            <th>Jalur</th>
                            <th>Tahun Keluar</th>
                            <th>Status Keluar</th>
                            <th>Tanggal Yudisium</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
    
                        @foreach ($mahasiswa as $mhs)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td> {{ $mhs['nim'] }} </td>
                                <td style="text-transform:uppercase;">{{ ($mhs['nama']) }}</td>
                                <td> {{ $mhs['daftar_ulang'] == 1 ? 'Ya' : 'Tidak' }} </td>
                                <td> {{ $mhs['tahun_masuk'] }} </td>
                                <td> {{ $mhs['kelamin'] == 1 ? 'Laki-laki' : 'Perempuan'}} </td>
                                <td> {{ $mhs['bidikmisi'] == 1 ? 'Ya' : 'Tidak' }} </td>
                                <td> {{ $mhs['asing'] == 1 ? 'Ya' : 'Tidak' }} </td>
                                <td> {{ $mhs['jalur_masuk'] }} </td>
                                <td> {{ $mhs['tahun_keluar'] }} </td>
                                <td> {{ $mhs['status_keluar'] }} </td>
                                <td> {{ $mhs['tanggal_yudisium'] }} </td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a
                                            href="/prodi/data/mahasiswa/{{ $mhs->id }}/edit{{ request('tahun') ? '?tahun=' . request('tahun') : '' }}{{ request('tahun') ? '&daftar_ulang=' . request('daftar_ulang') : '' }}"><button
                                                type="button" class="btn btn-sm btn-icon btn-primary"
                                                style="margin-left: 5px"><i class="bi bi-pencil-fill"></i></button></a>
                                        <form action="/prodi/data/mahasiswa" method="post" style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" id="id" value="{{ $mhs->id }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus mahasiswa ini ?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
    
                                    </div>
                                </td>
                            </tr>
                        @endforeach
    
                        @if (count($mahasiswa) < 1)
                            <tr>
                                <td colspan="15" class="text-center">
                                    Tidak ada mahasiswa.
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
