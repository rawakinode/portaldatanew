@if (isset($data['produk_jasa_mahasiswa']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Produk/Jasa Mahasiswa yang Diadopsi oleh Industri/Masyarakat</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive text-wrap">
            <table class="table" id="kerjasama" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-left">
                    <tr>
                        <th>#</th>
                        <th>Nama Mahasiswa</th>
                        <th>Nama Produk / Jasa</th>
                        <th>Deskripsi</th>
                        <th>Bukti</th>
                        <th>Tahun</th>
                      </tr>
                </thead>
                <tbody class="text-left">
                    @if (isset($data['produk_jasa_mahasiswa']))
                        @foreach ($data['produk_jasa_mahasiswa'] as $item)
                            <tr class="text-uppercase">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['mahasiswa']['nama'] }}</td>
                                <td>{{ $item['produk'] }}</td>
                                <td>{{ $item['deskripsi'] }}</td>
                                <td>{{ $item['bukti'] }}</td>
                                <td>{{ $item['tahun'] }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif