@extends('admin.layout.layout')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Program Studi</h4>

<!--INCLUDE -->
@include('trait._error')
@include('trait._success')

@include('admin.administrator.prodi._show')
@include('admin.administrator.prodi._tambah')

@include('admin.administrator.prodi._link')

@endsection