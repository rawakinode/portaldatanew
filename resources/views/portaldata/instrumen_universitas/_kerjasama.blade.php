<div class="card">
    <div class="card-header">
        <h4>Tabel Kerjasama Perguruan Tinggi</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Lembaga Mitra Kerjasama</th>
                        <th colspan="3">Tingkat</th>
                        <th rowspan="2">Bentuk Kegiatan / Manfaat</th>
                        <th rowspan="2">Tahun Kerjasama</th>
                    </tr>
                    <tr>
                        <th>Provinsi / Wilayah</th>
                        <th>Nasional</th>
                        <th>Internasional</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['kerjasama']))
                        @foreach ($data['kerjasama'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td class="text-start">TOTAL</td>
                                    <td>{{ $item['jumlah_lokal'] }}</td>
                                    <td>{{ $item['jumlah_nasional'] }}</td>
                                    <td>{{ $item['jumlah_internasional'] }}</td>
                                    <td></td>
                                    <td></td>

                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start;text-transform: uppercase">{{ $item['nama'] }}</td>
                                    <td>@if($item['tingkat'] == 'lokal') &#x2705; @endif</td>
                                    <td>@if($item['tingkat'] == 'nasional') &#x2705; @endif</td>
                                    <td>@if($item['tingkat'] == 'internasional') &#x2705; @endif</td>
                                    <td>{{ $item['output'] }}</td>
                                    <td>{{ $item['tahun'] }}</td>
                                </tr>
                            @endif
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
