@if (isset($data['kesesuaian_bidang']))
    <div class="card">
        <div class="card-header">
            <h4>Tabel Kesesuaian Bidang Kerja Lulusan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="data_tabel" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                        <tr>
                            <th rowspan="2">Tahun Lulus</th>
                            <th rowspan="2">Jumlah Lulusan</th>
                            <th rowspan="2">Jumlah Lulusan yang Terlacak</th>
                            <th colspan="3">Jumlah Lulusan Terlacak dengan Tingkat Keseuaian Bidang Kerja</th>
                        </tr>
                        <tr>
                            <th>Rendah</th>
                            <th>Sedang</th>
                            <th>Tinggi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center text-uppercase">
                        @if (isset($data['kesesuaian_bidang']))
                            @foreach ($data['kesesuaian_bidang'] as $i)
                                @if ($loop->last)
                                    <tr style="background-color: #e7ecff;color:#002f67; font-weight:bold;">
                                        <td>{{ $i['nama'] }}</td>
                                        <td>{{ $i['jumlah'] }}</td>
                                        <td>{{ $i['terlacak'] }}</td>
                                        <td>{{ $i['rendah'] }}</td>
                                        <td>{{ $i['sedang'] }}</td>
                                        <td>{{ $i['tinggi'] }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $i['nama'] }}</td>
                                        <td>{{ $i['jumlah'] }}</td>
                                        <td>{{ $i['terlacak'] }}</td>
                                        <td>{{ $i['rendah'] }}</td>
                                        <td>{{ $i['sedang'] }}</td>
                                        <td>{{ $i['tinggi'] }}</td>
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
