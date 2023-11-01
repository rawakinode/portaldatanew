<div class="card">
    <div class="card-header">
        <h4>Tabel Sertifikasi/Akreditasi Eksternal</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67">
                    <tr>
                        <th>#</th>
                        <th>Lembaga Sertifikasi / Akreditasi</th>
                        <th>Jenis</th>
                        <th>Lingkup</th>
                        <th>Tingkat</th>
                        <th>Masa Berlaku</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($data['akreditasi_sertifikasi_eksternal']))
                        @foreach ($data['akreditasi_sertifikasi_eksternal'] as $item)
                            <tr class="text-uppercase">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['lembaga'] }}</td>
                                <td>{{ $item['jenis'] }}</td>
                                <td>{{ $item['lingkup'] }}</td>
                                <td>{{ $item['tingkat'] }}</td>
                                <td>{{ $item['tahun_berakhir'] }}</td>
                                <td>{{ $item['keterangan'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>