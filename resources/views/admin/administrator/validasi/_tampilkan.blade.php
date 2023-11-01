<!-- MENAMPILKAN MODAL VIEW ISIAN -->
<button type="button" id="modal-view-isian" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#view_isian" style="display: none"></button>

<!-- MODAL VIEW -->
<div class="modal fade" id="view_isian" tabindex="-1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rincian Pengaturan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-unstyled mb-4 mt-3">
          <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span class="fw-semibold mx-2">Judul:</span> <span id="view-judul"></span></li>
          <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span class="fw-semibold mx-2">Status:</span> <span id="view-status"></span></li>
          <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span class="fw-semibold mx-2">Jawaban:</span> <span id="view-jawaban"></span></li>
          <li class="d-flex align-items-center mb-3"><i class="bx bx-calendar"></i><span class="fw-semibold mx-2">Tanggal di Tetapkan: </span> <span id="view-tanggal"></span></li>
          <li class="d-flex align-items-center mb-3"><i class="bx bx-calendar-plus"></i><span class="fw-semibold mx-2">Tanggal di Tambahkan:</span> <span id="view-timestamp"></span></li>
          <li class="d-flex align-items-center mb-3"><i class="bx bx-file"></i><span class="fw-semibold mx-2">Dokumen:</span> <span id="view-download"></span></li>
          <li class="d-flex align-items-center mb-3"><i class="bx bx-file"></i><span class="fw-semibold mx-2">Dokumen Lainnya:</span> <span id="view-download-tambahan1"></span>&nbsp; <span id="view-download-tambahan2"></span>&nbsp; <span id="view-download-tambahan3"></span></li>
          <li class="d-flex align-items-center mb-3"><i class="bx bx-question-mark"></i><span class="fw-semibold mx-2">Alasan:</span> <span id="view-alasan"></span></li>
          <li class="d-flex align-items-center mb-3"><i class="bx bx-message-dots"></i><span class="fw-semibold mx-2">Komentar:</span></span></li>
          <li>
            <textarea class="form-control" name="komentar" id="view-komentar" cols="30" rows="3"></textarea>
          </li>
        </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="verifikasi(1)">SETUJUI</button>
        <button type="button" class="btn btn-sm btn-danger" onclick="verifikasi(2)">TOLAK</button>
      </div>
    </div>
  </div>
</div>

<form action="/admin/validasi" method="POST" hidden>
  @csrf
  <input type="hidden" name="id" id="isian_id">
  <input type="hidden" name="komentar" id="isian_komentar">
  <input type="hidden" name="verifikasi" id="isian_verifikasi">
  <input type="hidden" name="tambahan" id="isian_tambahan" value="0">
  <input type="submit" id="isian_submit">
</form>

<script>

    function verifikasi(e) {
        var b = document.querySelector('#view-komentar').value;
        b = b.trim();
        if (b == '') {
          document.querySelector('#view-komentar').focus();
        }else{
          document.querySelector('#isian_komentar').value = b;
          document.querySelector('#isian_verifikasi').value = e;
          document.querySelector('#isian_submit').click();
        }
    }

    function tampilkanPengaturan(e) {
        //Mendapatkan data attribut
        e = JSON.parse(e.getAttribute('data-pengaturan'));

        console.log(e);
        // Menampilkan Judul
        document.getElementById("view-judul").innerText = e.judul;

        document.querySelector('#isian_id').value = e.isian_by_prodi.id;
        document.querySelector('#isian_tambahan').value = 0;

        // Menampilkan status validasi
        if (e.isian_by_prodi.verifikasi == 0) {
        document.getElementById("view-status").innerHTML = '<span class="badge bg-primary me-1">Not Validated</span>';
        } else if(e.isian_by_prodi.verifikasi == 1) {
        document.getElementById("view-status").innerHTML = '<span class="badge bg-success me-1">Accepted</span>';
        }else{
        document.getElementById("view-status").innerHTML = '<span class="badge bg-danger me-1">Rejected</span>';
        }

        // Menampilkan jawaban
        if (e.isian_by_prodi.jawaban == 1) {
        document.getElementById("view-jawaban").innerHTML = '<span class="badge bg-success me-1">Ada</span>';
        } else {
        document.getElementById("view-jawaban").innerHTML = '<span class="badge bg-warning me-1">Tidak Ada</span>';
        }

        //Menampilkan tanggal
        document.getElementById("view-tanggal").innerText = e.isian_by_prodi.tanggal;

        //Menampilkan timestamp
        document.getElementById("view-timestamp").innerText = (e.isian_by_prodi.created_at).slice(0,10);

        //Menampilkan Download
        if (e.isian_by_prodi.dokumen1 !== null ) {
        document.getElementById("view-download").innerHTML = '<a href="/storage/'+(e.isian_by_prodi.dokumen1).replace('public/','')+'"><button type="button" class="btn btn-sm btn-danger">Download</button></a>';
        }else{
        document.getElementById("view-download").innerText = '';
        }

        //Menampilkan Download Tambahan 1
        if (e.isian_by_prodi.dokumen2 !== null ) {
        document.getElementById("view-download-tambahan1").innerHTML = '<a href="/storage/'+(e.isian_by_prodi.dokumen2).replace('public/','')+'"><button type="button" class="btn btn-sm btn-danger">Download</button></a>';
        }else{
        document.getElementById("view-download-tambahan1").innerText = '';
        }

        //Menampilkan Download Tambahan 2
        if (e.isian_by_prodi.dokumen3 !== null) {
        document.getElementById("view-download-tambahan2").innerHTML = '<a href="/storage/'+(e.isian_by_prodi.dokumen3).replace('public/','')+'"><button type="button" class="btn btn-sm btn-danger">Download</button></a>';
        }else{
        document.getElementById("view-download-tambahan2").innerText = '';
        }

        //Menampilkan Download Tambahan 3
        if (e.isian_by_prodi.dokumen4 !== null) {
        document.getElementById("view-download-tambahan3").innerHTML = '<a href="/storage/'+(e.isian_by_prodi.dokumen4).replace('public/','')+'"><button type="button" class="btn btn-sm btn-danger">Download</button></a>';
        }else{
        document.getElementById("view-download-tambahan3").innerText = '';
        }

        //Menampilkan Alasan
        document.getElementById("view-alasan").innerText = e.isian_by_prodi.alasan;

        //Menampilkan Komentar
        document.getElementById("view-komentar").innerText = e.isian_by_prodi.komentar;

        document.querySelector('#modal-view-isian').click();
    }


</script>

<script>
  function tampilkanPengaturanEvaluasitambahan(e) {

      //Mendapatkan data attribut
      e = JSON.parse(e.getAttribute('data-pengaturan'));

      console.log(e);
      // Menampilkan Judul
      document.getElementById("view-judul").innerText = e.judul;

      document.querySelector('#isian_id').value = e.id;
      document.querySelector('#isian_tambahan').value = 1;

      // Menampilkan status validasi
      if (e.verifikasi == 0) {
      document.getElementById("view-status").innerHTML = '<span class="badge bg-primary me-1">Not Validated</span>';
      } else if(e.verifikasi == 1) {
      document.getElementById("view-status").innerHTML = '<span class="badge bg-success me-1">Accepted</span>';
      }else{
      document.getElementById("view-status").innerHTML = '<span class="badge bg-danger me-1">Rejected</span>';
      }

      //Menampilkan tanggal
      document.getElementById("view-tanggal").innerText = e.tanggal;

      //Menampilkan timestamp
      document.getElementById("view-timestamp").innerText = (e.created_at).slice(0,10);

      //Menampilkan Download
      if (e.dokumen1 !== null ) {
      document.getElementById("view-download").innerHTML = '<a href="/storage/'+(e.dokumen1).replace('public/','')+'"><button type="button" class="btn btn-sm btn-danger">Download</button></a>';
      }else{
      document.getElementById("view-download").innerText = '';
      }

      //Menampilkan Download Tambahan 1
      if (e.dokumen2 !== null ) {
      document.getElementById("view-download-tambahan1").innerHTML = '<a href="/storage/'+(e.dokumen2).replace('public/','')+'"><button type="button" class="btn btn-sm btn-danger">Download</button></a>';
      }else{
      document.getElementById("view-download-tambahan1").innerText = '';
      }

      //Menampilkan Download Tambahan 2
      if (e.dokumen3 !== null) {
      document.getElementById("view-download-tambahan2").innerHTML = '<a href="/storage/'+(e.dokumen3).replace('public/','')+'"><button type="button" class="btn btn-sm btn-danger">Download</button></a>';
      }else{
      document.getElementById("view-download-tambahan2").innerText = '';
      }

      //Menampilkan Download Tambahan 3
      if (e.dokumen4 !== null) {
      document.getElementById("view-download-tambahan3").innerHTML = '<a href="/storage/'+(e.dokumen4).replace('public/','')+'"><button type="button" class="btn btn-sm btn-danger">Download</button></a>';
      }else{
      document.getElementById("view-download-tambahan3").innerText = '';
      }

      //Menampilkan Komentar
      document.getElementById("view-komentar").innerText = e.komentar;

      document.querySelector('#modal-view-isian').click();
  }


</script>