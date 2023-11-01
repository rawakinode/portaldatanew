@extends('admin.layout.layout')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Periode & Aktivasi</h4>

<!--INCLUDE -->
@include('trait._error')
@include('trait._success')

<div class="row">
    @include('admin.administrator.periode._status_aktivasi')
    @include('admin.administrator.periode._tahun_aktif')
</div>

<div class="row">
    @include('admin.administrator.periode._tabel')
    @include('admin.administrator.periode._tambah')
</div>

@endsection