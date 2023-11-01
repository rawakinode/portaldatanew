@extends('admin.layout.layout')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Akun Pengguna</h4>

<!--INCLUDE -->
@include('trait._error')
@include('trait._success')

@include('admin.administrator.user._show')
@include('admin.administrator.user._tambah')
@include('admin.administrator.user._edit')
@include('admin.administrator.user._reset_password')

@endsection