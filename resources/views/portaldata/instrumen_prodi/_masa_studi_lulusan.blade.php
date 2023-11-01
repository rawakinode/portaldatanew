@if (isset($data['masa_studi_lulusan']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Masa Studi Lulusan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">Tahun Masuk</th>
                        <th rowspan="2">Jumlah Mahasiswa Diterima</th>
                        <th colspan="7">Jumlah Mahasiswa Yang Lulus Pada</th>
                        <th rowspan="2">Jumlah Lulusan sd. Akhir TS</th>
                        <th rowspan="2">Rata-Rata Masa Studi</th>
                    </tr>
                    <tr>
                        <th>Akhir TS-6</th>
                        <th>Akhir TS-5</th>
                        <th>Akhir TS-4</th>
                        <th>Akhir TS-3</th>
                        <th>Akhir TS-2</th>
                        <th>Akhir TS-1</th>
                        <th>Akhir TS</th>
                    </tr>
                </thead>
                <tbody class="text-center text-uppercase">
                    @if (isset($data['masa_studi_lulusan']))
                        @foreach ($data['masa_studi_lulusan'] as $index => $i)
                            <tr>
                                <td>TS{{ $index - 6}}</td>
                                <td style="{{ $i['jumlah_mahasiswa_diterima'] != 0 ? 'font-weight: bold' : '' }}">{{ $i['jumlah_mahasiswa_diterima'] }}</td>
                                <td style="{{ $i['jumlah_ts6'] != 0 ? 'font-weight: bold; background:#e7ecff' : '' }};">{{ $i['jumlah_ts6']}}</td>
                                <td style="{{ $i['jumlah_ts5'] != 0 ? 'font-weight: bold; background:#e7ecff' : '' }}">{{ $i['jumlah_ts5']}}</td>
                                <td style="{{ $i['jumlah_ts4'] != 0 ? 'font-weight: bold; background:#e7ecff' : '' }}">{{ $i['jumlah_ts4']}}</td>
                                <td style="{{ $i['jumlah_ts3'] != 0 ? 'font-weight: bold; background:#e7ecff' : '' }}">{{ $i['jumlah_ts3']}}</td>
                                <td style="{{ $i['jumlah_ts2'] != 0 ? 'font-weight: bold; background:#e7ecff' : '' }}">{{ $i['jumlah_ts2']}}</td>
                                <td style="{{ $i['jumlah_ts1'] != 0 ? 'font-weight: bold; background:#e7ecff' : '' }}">{{ $i['jumlah_ts1']}}</td>
                                <td style="{{ $i['jumlah_ts'] != 0 ? 'font-weight: bold; background:#e7ecff' : '' }}">{{ $i['jumlah_ts']}}</td>
                                <td style="{{ $i['jumlah_semua_ts'] != 0 ? 'font-weight: bold' : '' }}">{{ $i['jumlah_semua_ts']}}</td>
                                <td>{{ $i['rata_masa_studi'] ? $i['rata_masa_studi'] : '-' }}</td>

                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
