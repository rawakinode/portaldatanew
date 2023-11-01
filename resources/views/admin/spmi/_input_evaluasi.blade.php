<!-- MENAMPILKAN MODAL INPUT ISIAN -->
<form action="/spmi/create/{{ $url }}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="mt-3" id="modalfortambah">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input_evaluasi" id="ModalTambah" hidden>Launch modal</button>

        <!-- Modal -->
        <div class="modal fade" id="input_evaluasi" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahJudul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="jawaban" value="1">
                <div id="switchmodal">
                    
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
    var modalarray ;

    function openModalTambahIsian(e) {

        //Mendapatkan data attribut
        e = JSON.parse(e.getAttribute('data-pengaturan'));

        console.log(e);

        //Mengisi array di modal array dari data button
        modalarray = e;
        
        //Merubah Judul Modal
        document.getElementById("modalTambahJudul").innerText = modalarray.judul;

        //Aktikan form Ada
        switchAda();

        //Click tombol tampil modal
        document.getElementById("ModalTambah").click();
        
    }

    function switchAda() {
        var adahtml = '<div class="row"> <div class="col mb-3"> <label for="html5-date-input" class="form-label">Terakhir Dilaksanakan</label> <input class="form-control" type="date" name="tanggal" id="html5-date-input"> </div> </div> <div class="row"> <div class="col mb-3"> <label for="formFile1" class="form-label">Upload Dokuman PDF ('+modalarray.berkas+')</label> <input class="form-control" type="file" id="formFile1" name="dokumen1" accept="application/pdf"> </div> </div> <div class="row"> <div class="col mb-3"><label for="formFile2" class="form-label">Dokumen Tambahan (Opsional)</label> <input class="form-control" type="file" id="formFile2" name="dokumen2" accept="application/pdf"> </div> </div> <div class="row"> <div class="col mb-3"> <input class="form-control" type="file" accept="application/pdf" id="formFile3" name="dokumen3"> </div> </div> <div class="row"> <div class="col mb-3"> <input class="form-control" type="file" accept="application/pdf" id="formFile4" name="dokumen4"> </div> </div><input type="text" name="subpengaturan_id" value="'+modalarray.id+'" hidden>';

        document.getElementById("switchmodal").innerHTML = adahtml;

    }
</script>

<!-- MENAMPILKAN MODAL INPUT ISIAN -->
<form action="/spmi/create_tambahan" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="mt-3" id="modalfortambah">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input_evaluasi_tambahan" id="ModalEvaluasiTambahan" hidden>Launch modal</button>
    
            <!-- Modal -->
            <div class="modal fade" id="input_evaluasi_tambahan" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahJudul">Evaluasi Lainnya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                          <label for="evaluasi_judul" class="form-label">Nama Evaluasi</label>
                          <input class="form-control" type="text" name="judul" id="evaluasi_judul">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                          <label for="html5-date-input" class="form-label">Ditetapkan</label>
                          <input class="form-control" type="date" name="tanggal" id="html5-date-input">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                          <label for="formFile1" class="form-label">Upload Dokumen PDF</label>
                          <input class="form-control" type="file" id="formFile1" name="dokumen1" accept="application/pdf">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                          <label for="formFile2" class="form-label">Dokumen Tambahan (Opsional)</label>
                          <input class="form-control" type="file" id="formFile2" name="dokumen2" accept="application/pdf">
                    </div>
                    </div>
                      <div class="row">
                        <div class="col mb-3">
                          <input class="form-control" type="file" id="formFile3" name="dokumen3" accept="application/pdf">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                          <input class="form-control" type="file" id="formFile4" name="dokumen4" accept="application/pdf">
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

    function openModalTambahan() {

        //Click tombol tampil modal
        document.getElementById("ModalEvaluasiTambahan").click();
        
    }

</script>

<div class="hapus-form">
    <form action="/spmi/hapus_evaluasi_tambahan" method="post">
        @csrf

    </form>
</div>
  