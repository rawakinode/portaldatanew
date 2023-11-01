@if (isset($data['dosen_pembimbing_utama']))
    <div class="card">
        <div class="card-header">
            <h4>Tabel Dosen Pembimbing Utama Tugas Akhir</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="kerjasama" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Nama Dosen</th>
                            <th rowspan="2">NIDN / NIDK</th>
                            <th colspan="4">Jumlah Mahasiswa di Bimbing</th>
                        </tr>
                        <tr>
                            <th>TS-2</th>
                            <th>TS-1</th>
                            <th>TS</th>
                            <th>Rata-Rata</th>
                        </tr>

                    </thead>
                    <tbody class="text-center">
                        @if (isset($data['dosen_pembimbing_utama']))
                            @foreach ($data['dosen_pembimbing_utama'] as $item)
                                <tr class="text-uppercase">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['dosen_prodi']['nama'] }}</td>
                                    <td>{{ $item['dosen_prodi']['nidn'] }}</td>
                                    <td>{{ $item['ts2'] }}</td>
                                    <td>{{ $item['ts1'] }}</td>
                                    <td>{{ $item['ts'] }}</td>
                                    <td>{{ round($item['rata'], 2) }}</td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
