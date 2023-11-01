<div class="card">
    <div class="card-header">
        <h4>Tabel Tempat Kerja Lulusan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Program Pendidikan</th>
                        <th rowspan="2">Banyaknya Lulusan yang Telah Bekerja / Berwirausaha</th>
                        <th colspan="3">Tingkat/Ukuran Tempat Kerja / Berwirausaha</th>
                    </tr>
                    <tr>
                        <th>Lokal/ Wilayah/ Berwirausaha tidak Berbadan Hukum</th>
                        <th>Nasional/ Berwirausaha Berbadan Hukum</th>
                        <th>Multinasiona/ Internasional</th>

                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['tempat_kerja_lulusan']))
                        @foreach ($data['tempat_kerja_lulusan'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: start" class="text-capitalize">{{ $item['pendidikan'] }}</td>
                                <td>{{ $item['total'] }}</td>
                                <td>{{ $item['lokal'] }}</td>
                                <td>{{ $item['nasional'] }}</td>
                                <td>{{ $item['internasional'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
