@extends('admin.layout.layout')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a style="color: inherit" href="/admin/validasi">Validasi</a></span> / <span>{{ ucwords($prodi->nama) }}</span></h4>

<!--INCLUDE -->
@include('trait._error')
@include('trait._success')

@foreach ($pengaturan as $p)

    <div class="card mb-3">
        <h5 class="card-header">{{ Str::title($p->nama) }}</h5>
        <div class="table-responsive text-wrap">
        <table class="table table-hover">
            <thead>
            <tr>
                <th style="padding-left: 20px">Nama Pengaturan</th>
                @if ($p->nama != 'evaluasi') <th>Pilihan</th> @endif
                @if ($p->nama != 'evaluasi') <th>Ditetapkan</th> @else <th>Terakhir Dilaksanakan</th> @endif 
                <th>Ditambahkan</th>
                <th>Validasi</th>
                @can('konfirmasi validasi')
                    <th>Aksi</th>
                @endcan
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach($p->subpengaturan as $data)
                @if ($data->tipe != 2)
                    <tr>
                        <td style="padding-left: 20px">{{ $data->judul }}</td>
        
                        @if ($data->isian_by_prodi != null)
                            @if ($p->nama != 'evaluasi')
                                <td>
                                    @if ($data->isian_by_prodi['jawaban'] == 1)
                                    <span class="badge bg-success me-1">Ada</span>
                                    @else
                                    <span class="badge bg-warning me-1">Tidak Ada</span>
                                    @endif
                                </td>
                            @endif
                            <td>{{ $data->isian_by_prodi['tanggal'] }}</td>
                            <td>{{ substr($data->isian_by_prodi['created_at'], 0, 10) }}</td>
                            <td>
                                @if ($data->isian_by_prodi['verifikasi'] == 0)
                                    <span class="badge bg-primary me-1">Not Validated</span>
                                @elseif($data->isian_by_prodi['verifikasi'] == 1)
                                    <span class="badge bg-success me-1">Accepted</span>
                                @else
                                    <span class="badge bg-danger me-1">Rejected</span>
                                @endif
                            </td>
                            @can('konfirmasi validasi')
                                <td style="width: 100px">
                                    <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="tampilkanPengaturan(this)">
                                        <i class='bi bi-eye-fill'></i></button>
                                </td>
                            @endcan
                        @else
                            <td colspan="7" style="text-align: center;"><span style="font-style: italic;">Belum mengisi</span></td>
                        @endif
                        
                    </tr>
                @endif

            @endforeach
    
            </tbody>
        </table>
        </div>
    </div>
@endforeach

<div class="card mb-3 mt-2">
    <div class="table-responsive text-wrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th style="padding-left: 20px">List mekanisme evaluasi lainnya yang dilakukan</th>
            <th>Terakhir Dilaksanakan</th>
            <th>Validasi</th>
            @can('konfirmasi validasi') <th>Aksi</th> @endcan
            
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @if ($tambahan->count())
              @foreach($tambahan as $data)
                <tr>
                    <td style="padding-left: 20px">{{ $data->judul }}</td>
  
                    <td>{{ substr($data->created_at, 0, 10) }}</td>
                    <td>
                        @if ($data->verifikasi == 0)
                            <span class="badge bg-label-primary me-1">Not Validated</span>
                        @elseif($data->verifikasi == 1)
                            <span class="badge bg-label-success me-1">Accepted</span>
                        @else
                            <span class="badge bg-label-danger me-1">Rejected</span>
                        @endif
                    </td>
                    @can('konfirmasi validasi')
                        <td style="width: 100px">
                            <button type="button" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<span>Tampilkan & Validasi</span>" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="tampilkanPengaturanEvaluasitambahan(this)">
                            <span class="tf-icons bx bxs-show"></span></button>                       
                        </td>
                    @endcan
                    
                </tr>
              @endforeach
          @else
              <tr>
                <td colspan="4" class="text-center">Tidak ada evaluasi tambahan.</td>
              </tr>
          @endif

        </tbody>
      </table>
    </div>
  </div>

  @include('admin.administrator.validasi._tampilkan')

@endsection