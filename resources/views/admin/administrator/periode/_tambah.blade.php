<div class="col-md-6">
    <div class="card">
        <form action="/admin/periode" method="post"> @csrf
            <h5 class="card-header">Tambah Periode</h5>
            <div class="card-body">
                <input class="form-control" type="number" name="tahun" id="tahun" required>
                <small>Tidak boleh melangkahi tahun periode, misalkan dari 2022 langsung ke 2024.</small>
                <button type="submit" class="btn btn-primary" style="margin-top: 15px; display:block;"><i class="bx bx-plus mt-n1"></i> Tambah Periode</button>
            </div>
        </form>
    </div>
</div>