<div class="card">
    <div class="card-header">
        <h4>Tabel IPK Mahasiswa Lulusan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Program Pendidikan</th>
                        <th rowspan="2">Jumlah Prodi</th>
                        <th colspan="3">Jumlah Lulusan Pada</th>
                        <th colspan="3">Rata-rata IPK Lulusan Pada</th>
                    </tr>
                    <tr>
                        <th>TS-2</th>
                        <th>TS-1</th>
                        <th>TS</th>
                        <th>TS-2</th>
                        <th>TS-1</th>
                        <th>TS</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['ipk_mahasiswa']))
                        @foreach ($data['ipk_mahasiswa'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td style="text-align: start">{{ $item['pendidikan'] }}</td>
                                    <td>{{ $item['jumlah_prodi'] }}</td>
                                    <td>{{ $item['lulusan_ts2'] }}</td>
                                    <td>{{ $item['lulusan_ts1'] }}</td>
                                    <td>{{ $item['lulusan_ts'] }}</td>
                                    <td colspan="3"></td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start" class="text-capitalize">{{ $item['pendidikan'] }}</td>
                                    <td>{{ $item['jumlah_prodi'] }}</td>
                                    <td>{{ $item['lulusan_ts2'] }}</td>
                                    <td>{{ $item['lulusan_ts1'] }}</td>
                                    <td>{{ $item['lulusan_ts'] }}</td>
                                    <td>{{ round($item['ipk_ts2'], 2) }}</td>
                                    <td>{{ round($item['ipk_ts1'], 2) }}</td>
                                    <td>{{ round($item['ipk_ts'], 2) }}</td>
                                </tr>
                            @endif
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
