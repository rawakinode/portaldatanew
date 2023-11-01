@if (isset($data['tempat_kerja']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Tempat Kerja / Studi Lanjut Lulusan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">Tahun Lulus</th>
                        <th rowspan="2">Jumlah Lulusan</th>
                        <th rowspan="2">Jumlah Lulusan yang Terlacak</th>
                        <th colspan="4">Jumlah Lulusan Terlacak yang Bekerja Berdasarkan Tingkat/Ukuran Tempat Kerja/Berwirausaha</th>
                    </tr>
                    <tr>
                        <th>Lokal/ Wilayah/ Berwirausaha tidak Berbadan Hukum</th>
                        <th>Nasional/ Berwirausaha Berbadan Hukum</th>
                        <th>Multinasional/ Internasional</th>
                        <th>Lanjut Studi</th>
                    </tr>
                </thead>
                <tbody class="text-center text-uppercase">
                    @if (isset($data['tempat_kerja']))
                        @foreach ($data['tempat_kerja'] as $i)
                            @if ($loop->last)
                                <tr style="background-color: #e7ecff;color:#002f67; font-weight:bold;">
                                    <td>{{ $i['nama'] }}</td>
                                    <td>{{ $i['jumlah'] }}</td>
                                    <td>{{ $i['terlacak'] }}</td>
                                    <td>{{ $i['lokal'] }}</td>
                                    <td>{{ $i['nasional'] }}</td>
                                    <td>{{ $i['internasional'] }}</td>
                                    <td>{{ $i['lanjut_studi'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $i['nama'] }}</td>
                                    <td>{{ $i['jumlah'] }}</td>
                                    <td>{{ $i['terlacak'] }}</td>
                                    <td>{{ $i['lokal'] }}</td>
                                    <td>{{ $i['nasional'] }}</td>
                                    <td>{{ $i['internasional'] }}</td>
                                    <td>{{ $i['lanjut_studi'] }}</td>
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
