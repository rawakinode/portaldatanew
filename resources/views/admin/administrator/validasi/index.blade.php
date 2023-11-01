@extends('admin.layout.layout')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Validasi</h4>

<div class="card">
    <div class="row">
      <div class="col-sm"><h5 class="card-header">Daftar Program Studi</h5></div>
    </div>
  
    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="padding-left: 20px">Kode Prodi</th>
            <th>Nama Prodi</th>
            <th>Jenjang</th>
            <th>Fakultas</th>
            <th width="40%">SPMI Terisi</th>
            <th>Isian</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          
          @foreach ($prodi as $u)
          <tr>
            <td style="padding-left: 20px">{{$u->kode ?? ''}}</td>
            <td>{{ucwords($u->nama) ?? ''}}</td>
            <td>{{ucwords($u->jenjang) ?? ''}}</td>
            <td>{{$u->faculty['singkatan'] ?? ''}}</td>
            <td>
              <div class="progress">
                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: {{$u->jumlah_isian ?? 0}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
            <td>
              <div class="d-inline-block text-nowrap">
                <a href="/admin/validasi/{{ Crypt::encryptString($u->kode) ?? '' }}"><button class="btn btn-sm btn-icon btn-primary"><i class='bi bi-eye-fill'></i></button></a>
            </td>
          </tr>
          @endforeach
  
        </tbody>
      </table>
    </div>
  </div>

@endsection