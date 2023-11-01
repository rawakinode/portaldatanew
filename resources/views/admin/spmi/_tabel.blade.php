<div class="card">
    <h5 class="card-header">{{ucfirst($url)}}</h5>
    <div class="table-responsive text-wrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th style="padding-left: 20px">Nama Pengaturan</th>
            <th>Pilihan</th>
            <th>Ditambahkan</th>
            <th>Validasi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($pengaturan->sub_pengaturan as $data)
            <tr>
                <td style="padding-left: 20px">{{ $data->judul }}</td>

                @if ($data->isian != null)
                    <td>
                        @if ($data->isian['jawaban'] == 1)
                        <span class="badge bg-primary">Ada</span>
                        @else
                        <span class="badge bg-secondary">Tidak Ada</span>
                        @endif
                    </td>
                    <td>{{ substr($data->isian['created_at'], 0, 10) }}</td>
                    <td>
                        @if ($data->isian['verifikasi'] == 0)
                            <span class="badge bg-primary">Not Validated</span>
                        @elseif($data->isian['verifikasi'] == 1)
                            <span class="badge bg-success ">Accepted</span>
                        @else
                            <span class="badge bg-danger ">Rejected</span>
                        @endif
                    </td>
                    <td style="width: 100px">
                        <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="tampilkanPengaturan(this)">
                        <i class="bi bi-eye-fill"></i></button>
        
                        <button type="button" class="btn btn-sm btn-icon btn-primary" data-pengaturan="{{ $data }}" onclick="openModalTambahIsian(this)"><i class="bi bi-pencil-fill"></i></button>
                    </td>
                @else
                    <td colspan="3">
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