@if (isset($data['penelitian']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Penelitian Dosen</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive text-wrap">
            <table class="table" id="kerjasama" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2" style="text-align: left">Sumber Pembiayaan</th>
                        <th colspan="3">Jumlah Judul Penelitian</th>
                        <th rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th>TS-2</th>
                        <th>TS-1</th>
                        <th>TS</th>
                    </tr>

                </thead>
                <tbody class="text-center">
                    @if (isset($data['penelitian']))
                        @foreach ($data['penelitian'] as $item)
                            @if ($loop->last)
                            <tr class="text-uppercase" style="background-color: #e7ecff;font-weight:bold">
                                <td>#</td>
                                <td style="text-align: left">{{ $item['nama'] }}</td>
                                <td>{{ $item['ts2'] }}</td>
                                <td>{{ $item['ts1'] }}</td>
                                <td>{{ $item['ts'] }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                            </tr>
                             @else 
                             <tr class="text-uppercase">
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: left">{{ $item['nama'] }}</td>
                                <td>{{ $item['ts2'] }}</td>
                                <td>{{ $item['ts1'] }}</td>
                                <td>{{ $item['ts'] }}</td>
                                <td>{{ $item['jumlah'] }}</td>
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