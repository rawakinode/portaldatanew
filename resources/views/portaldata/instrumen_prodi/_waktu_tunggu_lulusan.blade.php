@if (isset($data['waktu_tunggu_lulusan']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Waktu Tunggu Lulusan Mendapatkan Kerja</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">Tahun Lulus</th>
                        <th rowspan="2">Jumlah Lulusan</th>
                        <th rowspan="2">Jumlah Lulusan yang Terlacak</th>
                        <th colspan="3">Jumlah Lulusan Terlacak dengan Waktu Tunggu Mendapatkan Pekerjaan </th>
                    </tr>
                    <tr>
                        <th>WT < {{ $data['waktu_tunggu_lulusan'][1] }} Bulan</th>
                        <th>WT > {{ $data['waktu_tunggu_lulusan'][1] }} < {{ $data['waktu_tunggu_lulusan'][2] }}
                                Bulan</th>
                        <th>WT > {{ $data['waktu_tunggu_lulusan'][2] }} Bulan</th>
                    </tr>
                </thead>
                <tbody class="text-center text-uppercase">
                    @if (isset($data['waktu_tunggu_lulusan']))
                        @foreach ($data['waktu_tunggu_lulusan'][0] as $i)
                            @if ($loop->last)
                                <tr style="font-weight: bold;background-color: #e7ecff;color:#002f67">
                                    <td>{{ $i['nama'] }}</td>
                                    <td>{{ $i['jumlah'] }}</td>
                                    <td>{{ $i['terlacak'] }}</td>
                                    <td>{{ $i['waktu_tunggu_3'] }}</td>
                                    <td>{{ $i['waktu_tunggu_3_6'] }}</td>
                                    <td>{{ $i['waktu_tunggu_6'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $i['nama'] }}</td>
                                    <td>{{ $i['jumlah'] }}</td>
                                    <td>{{ $i['terlacak'] }}</td>
                                    <td>{{ $i['waktu_tunggu_3'] }}</td>
                                    <td>{{ $i['waktu_tunggu_3_6'] }}</td>
                                    <td>{{ $i['waktu_tunggu_6'] }}</td>
                                </tr>
                            @endif
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif