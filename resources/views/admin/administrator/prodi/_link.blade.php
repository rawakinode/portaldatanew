
<form action="/admin/prodi/link" method="POST">
    @csrf
    <input type="hidden" name="id" id="accid">
    <div class="mt-3">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal4" id="btnSambungAkun" hidden>Launch modal</button>
  
      <!-- Modal -->
      <div class="modal fade" id="basicModal4" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Sambungkan Akun</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
  
              <div class="row">
                <div class="col mb-3">
                  <label for="username" class="form-label">nama prodi</label>
                  <input class="form-control" type="username" id="link_username" disabled>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="akun" class="form-label">Akun</label>
                  <select class="form-select" name="account" id="account_link">
                      <option value="">Pilih...</option>
                      @foreach ($user as $us)
                          @if ($us->prodi == null)
                              <option value="{{ $us->id }}">{{ $us->name }}</option>
                          @endif
                      @endforeach
                  </select>
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
    function linkAccount(e) {
      const data = JSON.parse(e.dataset.user);
      console.log(data);
      document.getElementById('accid').value = data.id;
      document.getElementById('link_username').value = data.nama;
      document.getElementById('btnSambungAkun').click();
    }
  </script>