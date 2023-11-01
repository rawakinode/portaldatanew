<div class="card">
    <div class="card-header">
        <h4>Tabel Mahasiswa Asing</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Fakultas / Unit Pengelola PS</th>
                        <th>TS-2</th>
                        <th>TS-1</th>
                        <th>TS</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['mahasiswa_asing']))
                        @foreach ($data['mahasiswa_asing'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td style="text-align: start">{{ $item['fakultas'] }}</td>
                                    <td>{{ $item['ts2'] }}</td>
                                    <td>{{ $item['ts1'] }}</td>
                                    <td>{{ $item['ts'] }}</td>
                                    <td>{{ $item['jumlah'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start">{{ $item['fakultas'] }}</td>
                                    <td>{{ $item['ts2'] }}</td>
                                    <td>{{ $item['ts1'] }}</td>
                                    <td>{{ $item['ts'] }}</td>
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
