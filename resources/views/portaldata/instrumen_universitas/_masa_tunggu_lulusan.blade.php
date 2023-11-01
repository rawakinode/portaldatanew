<div class="card">
    <div class="card-header">
        <h4>Tabel Waktu Tunggu Lulusan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Program Pendidikan</th>
                        <th colspan="3">Rata-rata Masa Tunggu Lulusan (Bulan)</th>
                    </tr>
                    <tr>
                        <th>TS-4</th>
                        <th>TS-3</th>
                        <th>TS-2</th>

                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['masa_tunggu_lulusan']))
                        @foreach ($data['masa_tunggu_lulusan'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: start" class="text-capitalize">{{ $item['pendidikan'] }}</td>
                                <td>{{ round($item['lulusan_ts4'], 1) }}</td>
                                <td>{{ round($item['lulusan_ts3'], 1) }}</td>
                                <td>{{ round($item['lulusan_ts2'], 1) }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
