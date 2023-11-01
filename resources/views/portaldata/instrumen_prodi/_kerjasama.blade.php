@if (isset($data['kerjasama']))
    <div class="card">
        <div class="card-header">
            <h4>Tabel Kerjasama</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="kerjasama" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Lembaga Mitra Kerjasama</th>
                            <th rowspan="2">Judul Kegiatan Kerjasama</th>
                            <th rowspan="2">Tahun Kerjasama</th>
                            <th colspan="3">Tingkat</th>
                            <th rowspan="2">Bentuk Kegiatan / Manfaat</th>
                            <th rowspan="2">Durasi</th>

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
                                <tr class="text-uppercase">
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start;">{{ $item['nama'] }}</td>
                                    <td style="text-align: start;">{{ $item['judul'] }}</td>
                                    <td>{{ $item['tahun'] }}</td>
                                    <td>
                                        @if ($item['tingkat'] == 'lokal')
                                            &#x2705;
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['tingkat'] == 'nasional')
                                            &#x2705;
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['tingkat'] == 'internasional')
                                            &#x2705;
                                        @endif
                                    </td>
                                    <td>{{ $item['output'] }}</td>
                                    <td>{{ $item['durasi'] >= 0 ? $item['durasi'] . ' Bulan' : '-' }}</td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
