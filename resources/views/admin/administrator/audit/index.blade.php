@extends('admin.layout.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Audit Keuangan Eksternal</h3>
            <p class="text-subtitle text-muted">Menampilkan audit keuangan eksternal.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pangkalan Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Audit Keuangan Eksternal</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--INCLUDE -->
    @include('trait._success')

    <div class="card">
        <div class="row">
            <div class="col-sm">
                <h5 class="card-header">Daftar</h5>
            </div>
            <div class="col-sm mt-3" style="text-align: right">
                <a href="/data/universitas/audit_keuangan_eksternal/create">
                    <button type="button" class="btn btn-primary" style="margin-right: 15px">
                        <i class="bi bi-plus-square" style="margin-right:7px;position: relative;top: -1px;"></i>
                        Tambah Data
                    </button>
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px">No</th>
                            <th>Lembaga Audit</th>
                            <th>Tahun</th>
                            <th>Opini</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($auditKeuangan as $data)
                            <tr>
                                <td style="padding-left: 20px">{{ $loop->iteration }}</td>
                                <td>{{ ucwords($data['lembaga']) }}</td>
                                <td>{{ ucwords($data['tahun']) }}</td>
                                <td>{{ ucwords($data['opini']) }}</td>
                                <td>{{ ucwords($data['keterangan']) }}</td>
                                <td width="100">
                                    <div class="d-flex text-nowrap">
                                        <a href="/data/universitas/audit_keuangan_eksternal/{{ $data->id }}/edit">
                                            <button type="button" class="btn btn-sm btn-icon btn-primary"
                                                style="margin-left: 5px">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                        </a>
                                        <form action="/data/universitas/audit_keuangan_eksternal" method="post"
                                            style="margin-left: 5px">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" id="id" value="{{ $data->id }}"
                                                hidden>
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                onclick="return confirm('Yakin menghapus audit keuangan ini ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($auditKeuangan) < 1)
                            <tr>
                                <td colspan="15" class="text-center">
                                    Tidak ada data.
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
