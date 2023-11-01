<div class="card">
    <div class="card-header">
        <h4>Tabel Mahasiswa Lulus Tepat Waktu</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">Tahun Masuk</th>
                        <th colspan="7">Jumlah Mahasiswa Lulus per Angkatan pada Tahun</th>
                        <th rowspan="2">Jumlah Lulusan s.d. Akhir TS</th>
                    </tr>
                    <tr>
                        <th>TS-6</th>
                        <th>TS-5</th>
                        <th>TS-4</th>
                        <th>TS-3</th>
                        <th>TS-2</th>
                        <th>TS-1</th>
                        <th>TS</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['lulusan_tepat_waktu']))
                        @foreach ($data['lulusan_tepat_waktu'] as $item)
                            <tr>
                                <td style="text-align: center">{{ $item['nama'] }}</td>
                                <td>{{ $item['ts6'] }}</td>
                                <td>{{ $item['ts5'] }}</td>
                                <td>{{ $item['ts4'] }}</td>
                                <td>{{ $item['ts3'] }}</td>
                                <td>{{ $item['ts2'] }}</td>
                                <td>{{ $item['ts1'] }}</td>
                                <td>{{ $item['ts'] }}</td>
                                <td style="font-weight: bold">{{ $item['jumlah'] }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
