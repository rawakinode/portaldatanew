@if (isset($data['kepuasan_mahasiswa']))
    <div class="card">
        <div class="card-header" style="margin-bottom: -30px">
            <h4>Tabel Kepuasan Mahasiswa</h4>
            <a href="{{ $data['kepuasan_mahasiswa'][0] ?? '#' }}" target="_blank"><button class="btn btn-primary btn-sm" style="float:right; position: relative;top:-37px;">Bukti Dukung</button></a>
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="kerjasama" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Aspek yang Diukur</th>
                            <th colspan="4">Tingkat Kepuasan Mahasiswa (%)</th>
                        </tr>
                        <tr>
                            <th>Sangat Baik</th>
                            <th>Baik</th>
                            <th>Cukup</th>
                            <th>Kurang</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if (isset($data['kepuasan_mahasiswa']))
                            @foreach ($data['kepuasan_mahasiswa'][1] as $item)
                                <tr class="text-uppercase">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $item['faktor'] }} : {{ $item['penjelasan'] }}</td>
                                    <td>{{ $item['sangat_baik'] > 0 && $item['jumlah'] > 0 ? ($item['sangat_baik'] / $item['jumlah']) * 100 . '%' : '-' }}
                                    </td>
                                    <td>{{ $item['baik'] > 0 && $item['jumlah'] > 0 ? ($item['baik'] / $item['jumlah']) * 100 . '%' : '-' }}
                                    </td>
                                    <td>{{ $item['cukup'] > 0 && $item['jumlah'] > 0 ? ($item['cukup'] / $item['jumlah']) * 100 . '%' : '-' }}
                                    </td>
                                    <td>{{ $item['kurang'] > 0 && $item['jumlah'] > 0 ? ($item['kurang'] / $item['jumlah']) * 100 . '%' : '-' }}
                                    </td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
