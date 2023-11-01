@extends('admin.layout.layout')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

<div class="row">
  <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Dosen</h3>
      <p class="text-subtitle text-muted">Menampilkan daftar dosen homebase di Universitas Tadulako</p>
  </div>
  <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Portal data</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dosen</li>
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
      <div class="col-sm"><h5 class="card-header">Daftar Dosen</h5></div>
      <div class="col-sm mt-3" style="text-align: right">
        <a href="/portaldata/dosen/create"><button type="button" class="btn btn-primary" style="margin-right: 15px"><i class="bi bi-plus-square" style="margin-right:7px;position: relative;top: -1px;"></i> Tambah Dosen</button></a></div>
    </div>
  
    <div class="card-body">
      <div class="table-responsive text-wrap">
        <table class="table table-striped" id="datatabel">
          <thead>
            <tr>
              <th style="padding-left: 20px">Aksi</th>
              <th>Nama</th>
              <th>Pendidikan</th>
              <th>Kelamin</th>
              <th>Jab. Fungsional</th>
              <th>Golongan</th>
              <th>Bidang Keahlian</th>
              <th>Homebase</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            
            @foreach ($dosen as $ds)
            <tr>
              <td width="100">
                <div class="d-flex text-nowrap">
                  <a href="/portaldata/dosen/{{ $ds->id }}/edit"><button type="button" class="btn btn-sm btn-icon btn-primary" style="margin-left: 5px"><i class="bi bi-pencil-fill"></i></button></a>
                  <form action="/portaldata/dosen/" method="post" style="margin-left: 5px">
                  @csrf
                  @method('delete')
                  <input type="hidden" name="id" id="id" value="{{ $ds->id }}" hidden>
                  <button type="submit" class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Yakin menghapus dosen ?')"><i class="bi bi-trash"></i></button>
                  </form>
                  
                </div>
              </td>
              <td style="padding-left: 20px">
                <div class="d-flex justify-content-start align-items-center user-name">
                  <div class="avatar-wrapper">
                    <div class="avatar avatar-sm me-3">
                      <img src="/images/no-profile-picture-icon-1.png" alt="Avatar" class="rounded-circle">
                    </div>
                  </div>
                  <div class="d-flex flex-column">
                    <span class="fw-semibold">{{ucwords($ds->nama)}}</span>
                        <small class="text-muted">{{$ds->nidn}}</small>
                  <div>
                </div>
              </td>
              <td>
                @if ($ds->pendidikan == 1)
                  S1
                  @elseif($ds->pendidikan == 2)
                  S2
                  @elseif($ds->pendidikan == 3)
                  S3
                  @elseif($ds->pendidikan == 4)
                  PROFESOR
                @endif       
              </td>
              <td>@if($ds->kelamin == 0) Laki-Laki @elseif($ds->kelamin == 1) Perempuan @else @endif</td>
              <td>
                  @if ($ds->fungsional == 1)
                  Asisten Ahli
                  @elseif($ds->fungsional == 2)
                  Lektor
                  @elseif($ds->fungsional == 3)
                  Lektor Kepala
                  @elseif($ds->fungsional == 4)
                  Guru Besar
                  @elseif($ds->fungsional == 5)
                  Tenaga Pengajar
                  @endif
              </td>
              <td>{{$ds->golongan}}</td>
              <td>{{ $ds->bidang_keahlian }}</td>
              <td style="text-transform: uppercase">{{ $ds->prodi_homebase['jenjang'].' '.$ds->prodi_homebase['nama'] }}</td>
  
            </tr>
            @endforeach
  
            @if (count($dosen) < 1)
               <tr>
                  <td colspan="10" class="text-center">
                      Tidak ada dosen.
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
        $('#datatabel').DataTable(); //show data tabel 
    });
</script>

@endsection