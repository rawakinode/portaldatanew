@extends('admin.layout.layout')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Pengaturan SPMI</h4>

<!--INCLUDE -->
@include('trait._error')
@include('trait._success')

<div class="row">
    <!-- Accordion with Icon -->
    <div class="col-md mb-4 mb-md-2">
      <div class="accordion mt-3" id="accordionWithIcon">
  
        @foreach ($pengaturan as $p)     
        
        <div class="card accordion-item card">
          <h2 class="accordion-header d-flex align-items-center">
            <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#{{$p->nama ?? ''}}" aria-expanded="true">
              <i class="bx bx-spreadsheet me-2"></i>
              {{ucfirst($p->nama) ?? ''}}
            </button>
          </h2>
  
          <div id="{{$p->nama ?? ''}}" class="accordion-collapse collapse" style="">
            <div class="accordion-body">
                    <div class="table-responsive text-wrap">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Pengaturan</th>
                            <th>Jenis Berkas</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
  
                          @forelse ($p->subpengaturan as $index => $s)
                          <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$s->judul ?? ''}}</td>
                            <td>{{$s->berkas ?? ''}}</td>
                            <td></td>
                          </tr>
                          @empty   
                          @endforelse
  
                        </tbody>
                      </table>
                    </div>
            </div>
          </div>
        </div>
  
        @endforeach
  
        @if (count($pengaturan) < 1)
        
        <div class="row">
          <div class="col-md">
            <div class="card card-action mb-4">
              <div class="card-header">
                <div class="card-action-title">
                  <h5>Pengaturan SPMI</h5>
                </div>
              </div>
                <div class="card-body pt-0">
                  <p class="card-text">Tidak ada pengaturan di tahun ini, untuk menambahkan pengaturan dan sub pengaturan spmi, silahkan import semua pengaturan dari database. Silahkan klik tombol import di bawah ini.</p>
                  
                  <form action="/admin/spmi/import" method="POST">
                    @csrf
                  <button type="submit" class="btn btn-primary" style="margin-right: 15px"><i class="bx bx-import mt-n2 mr-3"></i> Import Pengaturan SPMI</button>
                  </form>
                </div>
            </div>
          </div>
  
        </div>
        @endif
  
  
      </div>
    </div> 
  </div>

@endsection