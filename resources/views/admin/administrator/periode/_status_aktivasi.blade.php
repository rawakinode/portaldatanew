<div class="col-md">
    <div class="card card-action mb-4">
      <div class="card-header">
        <div class="card-action-title">
          <span><h5>Status Aktivasi</h5></span>

          @if($aktivasi['activation'] == 1)
          <span class="badge bg-success">AKTIF</span>
          @else
          <span class="badge bg-danger">NONAKTIF</span>
          @endif

        </div>
      </div>
      <div class="collapse show" style="">
        <div class="card-body pt-0">
          <p class="card-text">Untuk mengaktifkan penginputan sistem penjamin mutu internal (spmi), status aktivasi harus Aktif. Untuk meng-aktifkan / me-nonaktifkan, silahkan klik tombol dibawah ini.</p>

          <form action="/admin/aktivasi" method="post"> @csrf
            @if($aktivasi['activation'] == 1)
                <button type="submit" class="btn btn-danger" style="margin-right: 15px"><i class="bi bi-x mt-n1"></i> Non-Aktifkan Penginputan SPMI</button>
            @else
                <button type="submit" class="btn btn-primary" style="margin-right: 15px"><i class="bi bi-check mt-n1"></i> Aktifkan Penginputan SPMI</button>
            @endif
          </form>
          
        </div>
      </div>
    </div>
  </div>