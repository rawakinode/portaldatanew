@extends('admin.layout.layout')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Prodi /</span> Profil </h4>

<!--INCLUDE -->
@include('trait._error')
@include('trait._success')

<div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <h5 class="card-header">Rincian Profil</h5>
  
        <form action="/prodi/profil/create" method="POST" enctype="multipart/form-data">
          @csrf
        <!-- Account -->
        <hr class="my-0">
        <div class="card-body">
          <form id="formAccountSettings" method="POST" onsubmit="return false">
            <div class="row">
  
              <div class="mb-3 col-md-6">
                <label for="namaprodi" class="form-label">Nama Prodi</label>
                <input class="form-control" type="text" id="namaprodi" value="{{ucwords(auth()->user()->prodi->nama)}}" disabled>
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="kodeprodi" class="form-label">Kode Prodi</label>
                <input class="form-control" type="text" id="kodeprodi" value="{{auth()->user()->prodi->kode}}" disabled>
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="fakultas" class="form-label">Fakultas</label>
                    <input class="form-control" type="text" id="fakultas" value="{{ auth()->user()->prodi->faculty->name }}" disabled>
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="universitas" class="form-label">Perguruan Tinggi</label>
                <input class="form-control" type="text" id="universitas" value="Universitas Tadulako" disabled>
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="akreditasi" class="form-label">Akreditasi</label>
                <select class="form-select" name="akreditasi" id="akreditasi">
                    <option value="0">Tidak Terakreditasi</option>
                    <option value="1">Akreditasi A</option>
                    <option value="2">Akreditasi B</option>
                    <option value="3">Akreditasi C</option>
                    <option value="4">Unggul</option>
                    <option value="5">Baik</option>
                    <option value="6">Baik Sekali</option>
                </select>
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="jenjang" class="form-label">Jenjang</label>
                <input class="form-control" type="text" id="jenjang" value="{{auth()->user()->prodi->jenjang}}" disabled>
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="nilai" class="form-label">Nilai Akreditasi</label>
                <input class="form-control" type="number" id="nilai" name="nilai" value="{{$profil->nilai ?? ''}}">
              </div>

              <div class="mb-3 col-md-6">
                <label for="nomor_sk" class="form-label">Nomor SK</label>
                <input class="form-control" type="text" id="nomor_sk" name="nomor_sk" value="{{$profil->nomor_sk ?? ''}}">
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="berlaku_start" class="form-label">Tanggal Mulai Akreditasi</label>
                <input class="form-control" type="date" id="berlaku_start" name="berlaku_start" value="{{$profil->berlaku_start ?? ''}}">
              </div>

              <div class="mb-3 col-md-6">
                <label for="berlaku_end" class="form-label">Tanggal Berakhir Akreditasi</label>
                <input class="form-control" type="date" id="berlaku_end" name="berlaku_end" value="{{$profil->berlaku_end ?? ''}}">
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="skakreditasi" class="form-label">SK Akreditasi (PDF)</label>
                <div class="input-group">
                  <input type="file" accept="application/pdf" class="form-control" id="skakreditasi" name="sk_akreditasi"  aria-describedby="inputGroupFileAddon04" aria-label="Upload">
  
                    @if ($profil->sk_akreditasi ?? '')
                        <a href="{{ Storage::url($profil->sk_akreditasi) }}" target="_blank"><button class="btn btn-primary" type="button"><i class="bi bi-eye-fill"></i></button></a>   
                    @endif
  
                </div>
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="lembagaakreditasi" class="form-label">Lembaga Pengakreditasi</label>
                <input class="form-control" type="text" id="lembagaakreditasi" name="lembaga" value="{{$profil->lembaga ?? ''}}">
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="akreditasiint" class="form-label">Akreditasi Internasional</label>
                <select class="form-select" name="akreditasi_internasional" id="akreditasiint">
                    @if (($profil->akreditasi_internasional ?? 0) == 0)
                      <option value="0" selected>Tidak Terakreditasi</option>
                      <option value="1">Terakreditasi</option>
                    @else
                      <option value="0">Tidak Terakreditasi</option>
                      <option value="1" selected>Terakreditasi</option> 
                    @endif

                </select>
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="skakreditasiinter" class="form-label">SK Akreditasi Internasional (PDF)</label>
                <div class="input-group">
                  <input type="file" accept="application/pdf" class="form-control" id="skakreditasiinter" name="sk_akreditasi_internasional"  aria-describedby="inputGroupFileAddon04" aria-label="Upload">
  
                  @if ($profil->sk_akreditasi_internasional ?? '')
                        <a href="{{ Storage::url($profil->sk_akreditasi_internasional) }}" target="_blank"><button class="btn btn-primary" type="button"><i class="bi bi-eye-fill"></i></button></a>   
                  @endif
  
                </div>
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="lembagaakreditasiinter" class="form-label">Lembaga Pengakreditasi Internasional</label>
                <input class="form-control" type="text" id="lembagaakreditasiinter" name="lembaga_internasional" value="{{$profil->lembaga_internasional ?? ''}}">
              </div>
  
              <div class="mb-3 col-md-6">
                <label for="berlakuinter" class="form-label">Akreditasi Internasional Berlaku Sampai</label>
                <input class="form-control" type="date" id="berlakuinter" name="berlaku_internasional" value="{{$profil->berlaku_internasional ?? ''}}">
              </div>
                  
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Save changes</button>
            </div>
          <div></div><input type="hidden"></form>
        </div>
        <!-- /Account -->
      </form>
  
      </div>
  
    </div>
  </div>

  <script>

    //Set Akreditasi
    var akreditasi = '@if ($profil) {{$profil->akreditasi}} @else 0 @endif';
    document.getElementById("akreditasi").value = akreditasi.trim();
    
    </script>
    
@endsection