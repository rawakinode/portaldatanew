<div class="card">
    <div class="card-header">
        <h4>Tabel Kepuasan Pengguna Lulusan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Program Pendidikan</th>
                        <th colspan="4">Persentase Hasil Penilaian (%)</th>
                    </tr>
                    <tr>
                        <th>Sangat Baik</th>
                        <th>Baik</th>
                        <th>Cukup</th>
                        <th>Kurang</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['kepuasan_pengguna_lulusan']))
                        @foreach ($data['kepuasan_pengguna_lulusan'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: start" class="text-capitalize">{{ $item['judul'] }}</td>
                                <td>
                                    @if($item['sangat_baik'] > 0 && $item['total'] > 0)
                                    {{ ($item['sangat_baik'] / $item['total']) * 100}} %
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($item['baik'] > 0 && $item['total'] > 0)
                                    {{ ($item['baik'] / $item['total']) * 100}} %
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($item['cukup'] > 0 && $item['total'] > 0)
                                    {{ ($item['cukup'] / $item['total']) * 100}} %
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($item['kurang'] > 0 && $item['total'] > 0)
                                    {{ ($item['kurang'] / $item['total']) * 100}} %
                                    @else
                                    -
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
