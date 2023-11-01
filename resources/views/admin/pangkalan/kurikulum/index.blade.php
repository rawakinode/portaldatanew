@extends('admin.layout.layout')

@section('content')

<div class="row">
  <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Kurikulum</h3>
      <p class="text-subtitle text-muted">Menampilkan kurikulum program studi</p>
  </div>
  <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
              <li class="breadcrumb-item active" aria-current="page">Kurikulum</li>
          </ol>
      </nav>
  </div>
</div>

<!--INCLUDE -->
@include('trait._error')
@include('trait._success')

{{-- menampilkan tabel dosen --}}
<div class="card">
    <div class="row">
      <div class="col-sm"><h5 class="card-header">Daftar Matakuliah</h5></div>
      <div class="col-sm mt-3" style="text-align: right">
        <a href="/prodi/data/kurikulum/create"><button type="button" class="btn btn-primary" style="margin-right: 15px"><i class="bi bi-plus-square" style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Matakuliah</button></a></div>
    </div>
  
    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="padding-left: 20px">No</th>
            <th>Kode MK</th>
            <th>Nama MK</th>
            <th>SKS</th>
            <th>SKSP</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Jenis</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          
          @foreach ($matakuliah as $matkul)
          <tr>
            <td style="padding-left: 20px">{{$loop->iteration}}</td>
            <td> {{ $matkul['kode'] }} </td>
            <td>{{ Str::ucfirst($matkul['nama']) }}</td>
            <td>{{ $matkul['sks'] }}</td>
            <td>{{ $matkul['sks_praktikum'] }}</td>
            <td>{{ $matkul['semester'] }}</td>
            <td>{{ $matkul['status'] == 1 ? 'Wajib' : 'Tidak Wajib'}}</td>
            <td>{{ Str::ucfirst($matkul['jenis'])}}</td>
            <td width="100">
              <div class="d-flex text-nowrap">
                <a href="/prodi/data/kurikulum/{{ $matkul->id }}/edit"><button type="button" class="btn btn-sm btn-icon btn-primary" style="margin-left: 5px"><i class="bi bi-pencil-fill"></i></button></a>
                <form action="/prodi/data/kurikulum" method="post" style="margin-left: 5px">
                @csrf
                @method('delete')
                <input type="hidden" name="id" id="id" value="{{ $matkul->id }}" hidden>
                <button type="submit" class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Yakin menghapus matakuliah ?')"><i class="bi bi-trash"></i></button>
                </form>
                
              </div>
            </td>
          </tr>
          @endforeach

          @if (count($matakuliah) < 1)
             <tr>
                <td colspan="9" class="text-center">
                    Tidak ada matakuliah.
                </td>
            </tr>
          @endif

        </tbody>
      </table>
    </div>
  </div>
  
  <script>
  </script>

@endsection