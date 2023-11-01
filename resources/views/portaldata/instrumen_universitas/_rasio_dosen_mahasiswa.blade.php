<div class="card">
    <div class="card-header">
        <h4>Tabel Rasio Dosen dan Mahasiswa</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Fakultas / Unit Pengelola PS</th>
                        <th>Jumlah Dosen</th>
                        <th>Jumlah Mahasiswa</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['rasio_dosen_mahasiswa']))
                        @foreach ($data['rasio_dosen_mahasiswa'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td style="text-align: start">{{ $item['fakultas'] }}</td>
                                    <td>{{ $item['jumlah_dosen'] }}</td>
                                    <td>{{ $item['jumlah_mahasiswa'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start">{{ $item['fakultas'] }}</td>
                                    <td>{{ $item['jumlah_dosen'] }}</td>
                                    <td>{{ $item['jumlah_mahasiswa'] }}</td>
                                </tr>
                            @endif
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
