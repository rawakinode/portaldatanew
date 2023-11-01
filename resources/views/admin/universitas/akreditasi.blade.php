@extends('admin.layout.layout')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Universitas /</span> Akreditasi </h4>

<div class="card">
    <div class="row">
      <div class="col-sm"><h5 class="card-header">Daftar Akreditasi</h5></div>
    </div>
  
    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Kode Prodi</th>
            <th>Nama Prodi</th>
            <th>Fakultas</th>
            <th>Jenjang</th>
            <th>Akreditasi</th>
            <th>Nilai</th>
            <th>Berlaku S/D</th>
            <th>PDF</th>
            <th>Lembaga Akre.</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          
          @foreach ($akreditasi as $a)
          <tr>
            <td>{{$a->kode ?? ''}}</td>
            <td>{{ucwords($a->nama) ?? ''}}</td>
            <td>{{ $a->faculty['singkatan'] ?? '' }}</td>
            <td>{{ucwords($a->jenjang) ?? ''}}</td>
            <td>{{$a->profil[0]->akreditasi_rincian->singkatan ?? ''}}</td>
            <td>{{$a->profil[0]->nilai ?? ''}}</td>
            <td>{{$a->profil[0]->berlaku ?? ''}}</td>
            <td>
              @if ($a->profil[0]->sk_akreditasi ?? '')
              <a href="{{ Storage::url($a->profil[0]->sk_akreditasi ?? '') }}"><button type="button" class="btn btn-sm btn-primary">PDF</button></a> 
              @endif
            </td>
            <td>{{$a->profil[0]->lembaga ?? ''}}</td>
             
          </tr>
          @endforeach
  
        </tbody>
      </table>
    </div>
  </div>
  
@endsection