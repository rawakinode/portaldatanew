<div class="card">
    <div class="card-header">
        <h4>Tabel Perolehan Dana</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Sumber Dana</th>
                        <th rowspan="2">Jenis Dana</th>
                        <th colspan="3">Jumlah Dana (Rupiah)</th>
                        <th rowspan="2">Jumlah (Rupiah)</th>
                    </tr>
                    <tr>
                        <th>TS-2</th>
                        <th>TS-1</th>
                        <th>TS</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['perolehan_dana']))

                        @foreach ($data['perolehan_dana'] as $item)

                            @foreach ($item['jenis'] as $i)

                                @if ($loop->first)
                                    <tr>
                                        <td rowspan="{{ count($item['jenis'])-1 }}">{{ $loop->parent->iteration }}</td>
                                        <td rowspan="{{ count($item['jenis'])-1 }}">{{ $item['sumber'] }}</td>
                                        <td>{{ $i['nama'] }}</td>
                                        <td>{{ $i['data']['ts2'] != 0 ? 'Rp. '.number_format($i['data']['ts2'], 0, ',', '.') : '-' }}</td>
                                        <td>{{ $i['data']['ts1'] != 0 ? 'Rp. '.number_format($i['data']['ts1'], 0, ',', '.') : '-' }}</td>
                                        <td>{{ $i['data']['ts'] != 0 ? 'Rp. '.number_format($i['data']['ts'], 0, ',', '.') : '-' }}</td>
                                        <td>{{ $i['data']['jumlah'] != 0 ? 'Rp. '.number_format($i['data']['jumlah'], 0, ',', '.') : '-' }}</td>
                                        
                                    </tr>
                                @elseif ($loop->last)
                                    <tr style="background-color: #e7ecff;color:#002f67;font-weight:bold;">
                                        <td colspan="3">Total</td>
                                        <td>{{ $i['data']['ts2'] != 0 ? 'Rp. '.number_format($i['data']['ts2'], 0, ',', '.') : '-' }}</td>
                                        <td>{{ $i['data']['ts1'] != 0 ? 'Rp. '.number_format($i['data']['ts1'], 0, ',', '.') : '-' }}</td>
                                        <td>{{ $i['data']['ts'] != 0 ? 'Rp. '.number_format($i['data']['ts'], 0, ',', '.') : '-' }}</td>
                                        <td>{{ $i['data']['jumlah'] != 0 ? 'Rp. '.number_format($i['data']['jumlah'], 0, ',', '.') : '-' }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $i['nama'] }}</td>
                                        <td>{{ $i['data']['ts2'] != 0 ? 'Rp. '.number_format($i['data']['ts2'], 0, ',', '.') : '-' }}</td>
                                        <td>{{ $i['data']['ts1'] != 0 ? 'Rp. '.number_format($i['data']['ts1'], 0, ',', '.') : '-' }}</td>
                                        <td>{{ $i['data']['ts'] != 0 ? 'Rp. '.number_format($i['data']['ts'], 0, ',', '.') : '-' }}</td>
                                        <td>{{ $i['data']['jumlah'] != 0 ? 'Rp. '.number_format($i['data']['jumlah'], 0, ',', '.') : '-' }}</td>
                                    </tr>
                                @endif

                            @endforeach
                            
                        @endforeach

                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
