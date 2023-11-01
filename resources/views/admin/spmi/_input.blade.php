<!-- MENAMPILKAN MODAL INPUT ISIAN -->
<form action="/spmi/create/{{ $url }}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="mt-3" id="modalfortambah">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input_spmi_pengaturan" id="ModalTambah" hidden>Launch modal</button>

        <!-- Modal -->
        <div class="modal fade" id="input_spmi_pengaturan" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahJudul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Ketersediaan</label>
                    <select id="defaultSelectAda" name="jawaban" class="form-select" onchange="switchAda()">
                        <option value="1">Ada</option>
                        <option value="0">Tidak Ada</option>
                    </select>
                </div>
                </div>

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
        console.log("clicked");
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
        var adahtml = '<div class="row"> <div class="col mb-3"> <label for="html5-date-input" class="form-label">Ditetapkan</label> <input class="form-control" type="date" name="tanggal" id="html5-date-input"> </div> </div> <div class="row"> <div class="col mb-3"> <label for="formFile1" class="form-label">Upload Dokumen PDF ('+modalarray.berkas+')</label> <input class="form-control" type="file" id="formFile1" name="dokumen1" accept="application/pdf"> </div> </div> <div class="row"> <div class="col mb-3"><label for="formFile2" class="form-label">Dokumen PDF Tambahan (Opsional)</label> <input class="form-control" type="file" accept="application/pdf" id="formFile2" name="dokumen2"> </div> </div> <div class="row"> <div class="col mb-3"> <input class="form-control" type="file" accept="application/pdf" id="formFile3" name="dokumen3"> </div> </div> <div class="row"> <div class="col mb-3"> <input class="form-control" type="file" accept="application/pdf" id="formFile4" name="dokumen4"> </div> </div><input type="text" name="subpengaturan_id" value="'+modalarray.id+'" hidden>';

        var tidakadahtml = '<div class="row"> <div class="col mb-3"> <label for="pilihalasan" class="form-label">Berikan alasan</label> <select id="pilihalasan" class="form-select" onchange="switchAlasan()"> <option value="1">Belum ada pengaturan</option> <option value="2">Masih dalam proses</option> <option value="3">Lainnya</option> </select> </div> </div> <div class="row" id="tabalasanlainnya" style="display: none"> <div class="col mb-3"> <label for="alasan" class="form-label">KETIK ALASAN LAINNYA</label> <input type="text" class="form-control" name="alasan" value="Belum ada pengaturan" id="alasan" placeholder="Alasan lain" aria-describedby="defaultFormControlHelp"> </div> </div><input type="text" name="subpengaturan_id" value="'+modalarray.id+'" hidden>';

        var getselectid = document.getElementById("defaultSelectAda").value;

        if (getselectid == '1') {
            document.getElementById("switchmodal").innerHTML = adahtml;
        } else {
            document.getElementById("switchmodal").innerHTML = tidakadahtml;
        }

        console.log(getselectid);
    
    }

    function switchAlasan() {
        var a = document.getElementById("pilihalasan").value;
        if (a === '3') {
            document.getElementById("tabalasanlainnya").style.display = 'block';
            document.getElementById("alasan").value = '';
        } else if(a === '2') {
            document.getElementById("tabalasanlainnya").style.display = 'none';
            document.getElementById("alasan").value = 'Masih dalam proses';
        } else if(a === '1') {
            document.getElementById("tabalasanlainnya").style.display = 'none';
            document.getElementById("alasan").value = 'Belum ada pengaturan';
        }
    }
</script>