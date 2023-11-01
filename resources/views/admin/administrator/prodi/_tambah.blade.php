
<form action="/admin/prodi" method="POST">
    @csrf
    <div class="mt-3">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTarget" id="tambahProdiModal" hidden>Launch modal</button>
  
      <!-- Modal -->
      <div class="modal fade" id="modalTambahTarget" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Program Studi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
  
              <div class="row">
                <div class="col mb-3">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="name" class="form-label">Nama Prodi</label>
                      <input class="form-control" type="text" name="nama">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col mb-3">
                      <label for="kode" class="form-label">Kode Prodi</label>
                      <input class="form-control" type="number" name="kode">
                    </div>
                  </div>
  
                  <div class="row">
                    <div class="col mb-3">
                      <label for="fakultas" class="form-label">Fakultas</label>
                      <select class="form-select" name="fakultas" id="fakultas">
                        <option value="0">Pilih...</option>
  
                        @foreach ($fakultas as $faculty)
                        <option value="{{$faculty->code}}">{{$faculty->singkatan}}</option>
                        @endforeach
  
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col mb-3">
                      <label for="jenjang" class="form-label">Jenjang</label>
                      <select class="form-select" name="jenjang" id="jenjang">
                        <option value="">Pilih...</option>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="S1">S1</option>
                        <option value="PROF">PROFESI</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                        <option value="SPES">SPESIALIS</option>
                      </select>
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
        function tambahProdi() {
            document.getElementById('tambahProdiModal').click();
        }
    </script>