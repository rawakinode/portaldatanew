<div class="card">
    <div class="card-header">
        <h4>Tabel Buku Ber-ISBN / Book Chapter (3 Tahun Terakhir)</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-start">
                    <tr>
                        <th>#</th>
                        <th>Nama/Judul Buku</th>
                        <th class="text-center">Tahun Terbit</th>
                        <th>Keterangan</th>
                    </tr>

                </thead>
                <tbody class="text-start">
                    @if (isset($data['luaran_buku']))
                        @foreach ($data['luaran_buku'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($item['judul']) }}</td>
                                <td class="text-center">{{ $item['tahun'] }}</td>
                                <td>{{ $item['deskripsi'] }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
