
<form action="/admin/user/reset" method="POST">
    @csrf
    <input type="hidden" name="id" id="resetpasswordid">
    <div class="mt-3">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal4" id="btnResetPassword" hidden>Launch modal</button>
  
      <!-- Modal -->
      <div class="modal fade" id="basicModal4" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Reset Password</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
  
              <div class="row">
                <div class="col mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input class="form-control" type="username" id="reset_username" disabled>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input class="form-control" type="password" name="password" id="reset_password">
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="password2" class="form-label">Ulangi Password</label>
                  <input class="form-control" type="password" name="password_confirmation" id="reset_password_confirmation">
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
    function resetPassword(e) {
      const data = JSON.parse(e.dataset.user);
      document.getElementById('resetpasswordid').value = data.id;
      document.getElementById('reset_username').value = data.username;
      document.getElementById('btnResetPassword').click();
    }
  </script>