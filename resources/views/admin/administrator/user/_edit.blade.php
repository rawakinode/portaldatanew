<!-- MENAMPILKAN MODAL EDIT USER -->
<form action="/admin/user/edit" method="POST">
    @csrf
    <input type="hidden" name="id" id="id">
    <div class="mt-3">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal3" id="btnModalShowsEdit" hidden>Launch modal</button>
  
      <!-- Modal -->
      <div class="modal fade" id="basicModal3" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Pengguna</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
  
              <input type="hidden" name="id" id="useridx" required>
              <div class="row">
                <div class="col mb-3">
                  <label for="editusername" class="form-label">Username</label>
                  <input class="form-control" type="username" name="username" id="editusername">
                </div>
              </div>
  
              <div class="row">
                <div class="col mb-3">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="editnama" class="form-label">Nama</label>
                      <input class="form-control" type="text" name="name" id="editnama">
                    </div>
                  </div>
                  
                </div>
              </div>
  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <script>
    function editUser(e) {
        const data = JSON.parse(e.dataset.user);
        document.getElementById('useridx').value = data.id;
        document.getElementById('editusername').value = data.username;
        document.getElementById('editnama').value = data.name;
        document.getElementById('btnModalShowsEdit').click();
    }
  </script>