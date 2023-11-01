<div class="card mb-3">
    <h5 class="card-header">{{ucfirst($url)}}</h5>
    <div class="table-responsive text-wrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th style="padding-left: 20px">Evaluasi yang dilakukan, dijalankan melalui mekanisme</th>
            <th>Terakhir Dilaksanakan</th>
            <th>Validasi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($pengaturan->sub_pengaturan->where('tipe','0') as $data)
            <tr>
                <td style="padding-left: 20px">{{ $data->judul }}</td>

                @if ($data->isian != null)
                    <td>{{ $data->isian['tanggal'] }}</td>
                    <td>
                        @if ($data->isian['verifikasi'] == 0)
                            <span class="badge bg-primary">Not Validated</span>
                        @elseif($data->isian['verifikasi'] == 1)
                            <span class="badge bg-success">Accepted</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td style="width: 100px">
                        <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="tampilkanPengaturan(this)"><i class="bi bi-eye-fill"></i></button>
        
                        <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="openModalTambahIsian(this)"><i class="bi bi-pencil-fill"></i></button>
                    </td>
                @else
                    <td colspan="2">
                        <span style="font-style: italic">Belum mengisi</span>
                    </td>
                    <td style="width: 100px">
                        <button type="button" class="btn btn-sm btn-icon btn-primary" disabled>
                          <i class="bi bi-eye-fill"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="openModalTambahIsian(this)"><i class="bi bi-pencil-fill"></i></button>
                    </td>
                @endif
                
            </tr>
          @endforeach

        </tbody>
      </table>
    </div>
</div>

<div class="card mb-3">
  <div class="table-responsive text-wrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th style="padding-left: 20px">List audit mutu internal</th>
          <th>Terakhir Dilaksanakan</th>
          <th>Validasi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($pengaturan->sub_pengaturan->where('tipe','1') as $data)
          <tr>
              <td style="padding-left: 20px">{{ $data->judul }}</td>

              @if ($data->isian != null)
                  <td>{{ substr($data->isian['created_at'], 0, 10) }}</td>
                  <td>
                      @if ($data->isian['verifikasi'] == 0)
                          <span class="badge bg-primary">Not Validated</span>
                      @elseif($data->isian['verifikasi'] == 1)
                          <span class="badge bg-success">Accepted</span>
                      @else
                          <span class="badge bg-danger">Rejected</span>
                      @endif
                  </td>
                  <td style="width: 100px">
                      <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="tampilkanPengaturan(this)">
                        <i class="bi bi-eye-fill"></i></button>
      
                      <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="openModalTambahIsian(this)"><i class="bi bi-pencil-fill"></i></button>
                  </td>
              @else
                  <td colspan="2">
                      <span style="font-style: italic">Belum mengisi</span>
                  </td>
                  <td style="width: 100px">
                      <button type="button" class="btn btn-sm btn-icon btn-primary" disabled>
                        <i class="bi bi-eye-fill"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="openModalTambahIsian(this)"><i class="bi bi-pencil-fill"></i></button>
                  </td>
              @endif
              
          </tr>
        @endforeach

      </tbody>
    </table>
  </div>
</div>


<div class="card mb-3 mt-2">
  <div class="table-responsive text-wrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th style="padding-left: 20px">List mekanisme evaluasi lainnya yang dilakukan</th>
          <th>Terakhir Dilaksanakan</th>
          <th>Validasi</th>
          <th>Aksi</th>
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
                          <span class="badge bg-primary">Not Validated</span>
                      @elseif($data->verifikasi == 1)
                          <span class="badge bg-success">Accepted</span>
                      @else
                          <span class="badge bg-danger">Rejected</span>
                      @endif
                  </td>
                  <td style="width: 100px">
                      <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="tampilkanPengaturanEvaluasitambahan(this)">
                        <i class="bi bi-eye-fill"></i></button>
                        
                      <form action="/spmi/delete_tambahan" method="post" style="display: contents">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-icon btn-danger" onclick=""><i class="bi bi-trash-fill"></i></button>
                      </form>
                      
                  </td>
                  
              </tr>
            @endforeach
        @else
            <tr>
              <td colspan="4" class="text-center">Tidak ada evaluasi tambahan.</td>
            </tr>
        @endif
        @if (count($tambahan) < 11)
            <tr>
              <td colspan="4" class="text-center"><button type="button" class="btn btn-sm btn-primary" onclick="openModalTambahan()">Tambah</button></td>
            </tr>
        @endif
        

      </tbody>
    </table>
  </div>
</div>



