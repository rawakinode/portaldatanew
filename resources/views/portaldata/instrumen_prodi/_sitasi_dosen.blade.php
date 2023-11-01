@if (isset($data['sitasi_dosen']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Karya Ilmiah Dosen Tetap yang Disitasi</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive text-wrap">
            <table class="table" id="kerjasama" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-left">
                    <tr>
                        <th>#</th>
                        <th>Nama Dosen</th>
                        <th>Judul Artikel</th>
                        <th>Jumlah Sitasi</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                      </tr>
                </thead>
                <tbody class="text-left">
                    @if (isset($data['sitasi_dosen']))
                        @foreach ($data['sitasi_dosen'] as $item)
                            <tr class="text-uppercase">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['penulis_dosen'] }}</td>
                                <td>{{ $item['judul'] }}</td>
                                <td>{{ $item['sitasi'] }}</td>
                                <td>{{ $item['publikasi'] }}</td>
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