<div class="card">
    <div class="card-header">
        <h4>Tabel Jabatan Akademik Dosen Tetap</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Pendidikan</th>
                        <th colspan="5">Jabatan Akademik</th>
                        <th rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th>Guru Besar</th>
                        <th>Lektor Kepala</th>
                        <th>Lektor</th>
                        <th>Asisten Ahli</th>
                        <th>Tenaga Pengajar</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['jabatan_akademik_dosen']))
                        @foreach ($data['jabatan_akademik_dosen'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td style="text-align: start">{{ $item['pendidikan'] }}</td>
                                    <td>{{ $item['guru_besar'] }}</td>
                                    <td>{{ $item['lektor_kepala'] }}</td>
                                    <td>{{ $item['lektor'] }}</td>
                                    <td>{{ $item['asisten_ahli'] }}</td>
                                    <td>{{ $item['tenaga_pengajar'] }}</td>
                                    <td style="font-weight: bold">{{ $item['jumlah'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start">{{ $item['pendidikan'] }}</td>
                                    <td>{{ $item['guru_besar'] }}</td>
                                    <td>{{ $item['lektor_kepala'] }}</td>
                                    <td>{{ $item['lektor'] }}</td>
                                    <td>{{ $item['asisten_ahli'] }}</td>
                                    <td>{{ $item['tenaga_pengajar'] }}</td>
                                    <td style="font-weight: bold">{{ $item['jumlah'] }}</td>
                                </tr>
                            @endif
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
