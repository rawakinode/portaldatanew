<div class="card">
    <div class="card-header">
        <h4>Tabel Jumlah Lulusan yang Dinilai oleh Pengguna Lulusan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Program Pendidikan</th>
                        <th colspan="3">Banyak Lulusan</th>
                        <th colspan="3">Banyak Lulusan yang Dinilai</th>
                    </tr>
                    <tr>
                        <th>TS-4</th>
                        <th>TS-3</th>
                        <th>TS-2</th>
                        <th>TS-4</th>
                        <th>TS-3</th>
                        <th>TS-2</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['jumlah_lulusan_dinilai_pengguna']))
                        @foreach ($data['jumlah_lulusan_dinilai_pengguna'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: start" class="text-capitalize">{{ $item['pendidikan'] }}</td>
                                <td>{{ $item['lulusan_ts4'] }}</td>
                                <td>{{ $item['lulusan_ts3'] }}</td>
                                <td>{{ $item['lulusan_ts2'] }}</td>
                                <td>{{ $item['dinilai_ts4'] }}</td>
                                <td>{{ $item['dinilai_ts3'] }}</td>
                                <td>{{ $item['dinilai_ts2'] }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
