
@extends('admin.layout.layout')

@section('content')
    
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">SPMI /</span> {{ucfirst($url)}}</h4>

<!--INCLUDE -->
@include('trait._error')
@include('trait._success')

@if ($url == 'evaluasi')
    @include('admin.spmi._tabel_evaluasi')
    @include('admin.spmi._input_evaluasi')
@else
    @include('admin.spmi._tabel')
    @include('admin.spmi._input')
@endif

@include('admin.spmi._tampilkan')

@endsection