<div class="card">
    <div class="card-header">
        <h4>Tabel Kesesuaian Bidang Kerja Lulusan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Program Pendidikan</th>
                        <th colspan="3">Persentase Kesesuaian Bidang Kerja (%)</th>
                    </tr>
                    <tr>
                        <th>TS-4</th>
                        <th>TS-3</th>
                        <th>TS-2</th>

                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['kesesuaian_bidang_kerja']))
                        @foreach ($data['kesesuaian_bidang_kerja'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: start" class="text-capitalize">{{ $item['pendidikan'] }}</td>
                                <td>
                                    {{ ($item['lulusan_ts4'] > 0 && $item['total_ts4'] > 0) ? number_format($item['lulusan_ts4']/$item['total_ts4'] * 100).' %' : 0}}
                                </td>
                                <td>
                                    {{ ($item['lulusan_ts3'] > 0 && $item['total_ts3'] > 0) ? number_format($item['lulusan_ts3']/$item['total_ts3'] * 100).' %' : 0}}
                                </td>
                                <td>
                                    {{ ($item['lulusan_ts2'] > 0 && $item['total_ts2'] > 0) ? number_format($item['lulusan_ts2']/$item['total_ts2'] * 100).' %' : 0}}
                                </td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
