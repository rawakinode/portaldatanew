<div class="card">
    <div class="card-header">
        <h4>Tabel Akreditasi Internasional Program Studi</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67">
                    <tr>
                        <th>#</th>
                        <th>Program Studi</th>
                        <th>Kode Prodi</th>
                        <th>Lembaga Akreditasi</th>
                        <th>Status Peringkat</th>
                        <th>Masa Berlaku</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($data['akreditasi_internasional']))
                        @foreach ($data['akreditasi_internasional'] as $item)
                            <tr class="text-uppercase">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['prodi']['nama'] }}</td>
                                <td>{{ $item['prodi']['kode'] }}</td>
                                <td>{{ $item['lembaga_internasional'] }}</td>
                                <td></td>
                                <td>{{ $item['berlaku_internasional'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>