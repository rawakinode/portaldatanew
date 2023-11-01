<div class="col-md">
    <div class="card card-action mb-4">
      <div class="card-header">
        <div class="card-action-title"><span><h5>Tahun Aktif</h5></span>
          @foreach ($periode as $p)
              @if ($p->status == 1)
              <span class="badge bg-success">{{$p->tahun}}</span>
              @endif
          @endforeach
          
        </div>
      </div>
      <div class="collapse show" style="">
        <div class="card-body pt-0">
          <form action="/admin/periode/select" method="POST">
            @csrf
            <select class="form-select mb-2" id="exampleFormControlSelect1" aria-label="Default select example" name="id">
              <option selected="">Pilih...</option>
              @foreach ($periode as $p)
                  <option value="{{$p->id ?? 0}}">{{$p->tahun ?? 0}}</option>
              @endforeach
            </select>
            <p class="card-text">Untuk mengubah periode, silahkan pilih tahun dan klik tombol dibawah ini.</p>
            <button type="submit" class="btn btn-primary" style="margin-right: 15px"><i class="bx bx-plus mt-n1"></i> Konfirmasi Periode</button>
        </form>
        </div>
      </div>
    </div>
</div>