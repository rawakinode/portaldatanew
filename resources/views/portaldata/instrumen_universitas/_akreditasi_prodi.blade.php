<div class="card">
    <div class="card-header">
        <h4>Tabel Akreditasi Program Studi</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Status dan Peringkat Akreditasi</th>
                        <th colspan="8">Jumlah Program Studi</th>
                        <th rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th>S-3</th>
                        <th>S-2</th>
                        <th>S-1</th>
                        <th>Profesi</th>
                        <th>D-4</th>
                        <th>D-3</th>
                        <th>D-3</th>
                        <th>D-1</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['akreditasi_prodi']))
                        @foreach ($data['akreditasi_prodi'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td>{{ $item['akreditasi'] }}</td>
                                    <td>{{ $item['S3'] }}</td>
                                    <td>{{ $item['S2'] }}</td>
                                    <td>{{ $item['S1'] }}</td>
                                    <td>{{ $item['PROF'] }}</td>
                                    <td>{{ $item['D4'] }}</td>
                                    <td>{{ $item['D3'] }}</td>
                                    <td>{{ $item['D2'] }}</td>
                                    <td>{{ $item['D1'] }}</td>
                                    <td style="font-weight: bold">{{ $item['total'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['akreditasi'] }}</td>
                                    <td>{{ $item['S3'] }}</td>
                                    <td>{{ $item['S2'] }}</td>
                                    <td>{{ $item['S1'] }}</td>
                                    <td>{{ $item['PROF'] }}</td>
                                    <td>{{ $item['D4'] }}</td>
                                    <td>{{ $item['D3'] }}</td>
                                    <td>{{ $item['D2'] }}</td>
                                    <td>{{ $item['D1'] }}</td>
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
