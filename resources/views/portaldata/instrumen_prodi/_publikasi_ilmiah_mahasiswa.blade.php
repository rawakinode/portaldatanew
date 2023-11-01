@if (isset($data['publikasi_ilmiah_mahasiswa']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Publikasi Ilmiah Mahasiswa</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Jenis Publikasi</th>
                        <th colspan="3">Jumlah Judul</th>
                        <th rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th>TS-2</th>
                        <th>TS-1</th>
                        <th>TS</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['publikasi_ilmiah_mahasiswa']))
                        @foreach ($data['publikasi_ilmiah_mahasiswa'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td style="text-align: start" class="text-capitalize">TOTAL</td>
                                    <td>{{ $item['ts2'] }}</td>
                                    <td>{{ $item['ts1'] }}</td>
                                    <td>{{ $item['ts'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['total'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start" class="text-capitalize">{{ $item['jenis'] }}</td>
                                    <td>{{ $item['ts2'] }}</td>
                                    <td>{{ $item['ts1'] }}</td>
                                    <td>{{ $item['ts'] }}</td>
                                    <td style="font-weight: bold">{{ $item['total'] }}</td>
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
