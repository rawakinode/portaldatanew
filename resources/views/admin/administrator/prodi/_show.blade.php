
<div class="card">
    <div class="row">
      <div class="col-sm"><h5 class="card-header">Daftar Prodi</h5></div>
      <div class="col-sm mt-3" style="text-align: right">
        <button type="button" class="btn btn-primary" style="margin-right: 15px" onclick="tambahProdi()"><i class='bx bx-plus mt-n1'></i> Tambah Prodi</button></div>
    </div>
  
    <div class="table-responsive text-wrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="padding-left: 20px">Kode Prodi</th>
            <th>Nama Prodi</th>
            <th>Fakultas</th>
            <th>Jenjang</th>
            <th>User Linked</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          
          @foreach ($prodi as $p)
          <tr>
            <td style="padding-left: 20px">{{ $p->kode ?? ''}}</td>
            <td>{{ ucwords($p->nama) ?? ''}}</td>
            <td>{{ $p->faculty['singkatan'] ?? ''}}</td>
            <td>{{ $p->jenjang ?? ''}}</td>
            
            <td><span class="badge bg-primary">{{ $p->users['username'] ?? ''}}</span></td>
            <td>
              <div class="d-inline-block text-nowrap">
  
                <button data-user="{{ $p }}"  class="btn btn-sm btn-icon btn-primary" onclick="linkAccount(this)"><i class="bi bi-link"></i></button>
                
                <form action="/admin/prodi" method="post" style="display: contents">
                  @csrf
                  @method('delete')
                  <input type="hidden" name="id" value="{{ $p->id }}" required>
                  <button type="submit"  class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Yakin menghapus prodi ini?')"><i class="bi bi-trash"></i></button>
                </form>
  
              </div>
            </td>
          </tr>
          @endforeach
  
        </tbody>
      </table>
    </div>
  </div>