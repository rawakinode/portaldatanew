
<div class="card">
    <div class="row">
      <div class="col-sm"><h5 class="card-header">Daftar User</h5></div>
      <div class="col-sm mt-3" style="text-align: right">
        <button type="button" class="btn btn-primary" style="margin-right: 15px" onclick="openModal()"><i class='bx bx-plus mt-n1'></i> Tambah Pengguna</button></div>
    </div>
  
    <div class="table-responsive text-wrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="padding-left: 20px">Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>Account Linked</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          
          @foreach ($user as $u)
          <tr>
            <td style="padding-left: 20px">{{ucwords($u->name) ?? ''}}</td>
            <td>{{ $u->username ?? ''}}</td>
            <td>
                @if ($u->role)
                    @if ($u->role == 1)
                    <span class="badge bg-success">Administrator</span>
                    @elseif($u->role == 2)
                    <span class="badge bg-secondary">Universitas</span>
                    @elseif($u->role == 3)
                    <span class="badge bg-secondary">Rektor</span>
                    @elseif($u->role == 4)
                    <span class="badge bg-secondary">Dekan</span> <span class="badge bg-info">{{ $u->faculty['singkatan'] }}</span>
                    @elseif($u->role == 5)
                    <span class="badge bg-primary">Prodi</span>
                    @else
                      Tidak Ada   
                    @endif
                @endif
            </td>
            <td><span class="badge bg-primary">{{ $u->prodi['nama'] ?? ''}}</span></td>
            <td>
              <div class="d-inline-block text-nowrap">
                <button data-user="{{ $u }}" class="btn btn-sm btn-icon btn-secondary" onclick="resetPassword(this)"><i class="bi bi-lock-fill"></i></button>
  
                <button data-user="{{ $u }}" class="btn btn-sm btn-icon btn-primary" onclick="editUser(this)"><i class="bi bi-pencil-fill"></i></button>
                
                <form action="/admin/user" method="post" style="display: contents">
                  @csrf
                  @method('delete')
                  <input type="hidden" name="id" value="{{ $u->id }}" required>
                  <button type="submit" class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Yakin menghapus akun ini?')"><i class="bi bi-trash"></i></button>
                </form>
  
              </div>
            </td>
          </tr>
          @endforeach
  
        </tbody>
      </table>
    </div>
  </div>
