<div class="card">
    <div class="card-header">
        <h4>Tabel Prestasi Non-Akademik Mahasiswa (3 Tahun Terakhir)</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Nama Kegiatan</th>
                        <th rowspan="2">Waktu Penyelenggara</th>
                        <th colspan="3">Tingkat</th>
                        <th rowspan="2">Prestasi yang Dicapai</th>
                    </tr>
                    <tr>
                        <th>Provinsi / Wilayah</th>
                        <th>Nasional</th>
                        <th>Internasional</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['prestasi_non_akademik_mahasiswa']))
                        @foreach ($data['prestasi_non_akademik_mahasiswa'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td class="text-start">TOTAL</td>
                                    <td></td>
                                    <td>{{ $item['wilayah'] }}</td>
                                    <td>{{ $item['nasional'] }}</td>
                                    <td>{{ $item['internasional'] }}</td>
                                    <td></td>

                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start" class="text-capitalize">{{ $item['nama'] }}</td>
                                    <td>{{ $item['tahun'] }}</td>
                                    <td>@if($item['tingkat'] == 'lokal') &#x2705; @endif</td>
                                    <td>@if($item['tingkat'] == 'nasional') &#x2705; @endif</td>
                                    <td>@if($item['tingkat'] == 'internasional') &#x2705; @endif</td>
                                    <td>{{ $item['prestasi'] }}</td>
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
