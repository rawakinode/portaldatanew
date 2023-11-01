@if (isset($data['peralatan_laboratorium']))
    <div class="card">
        <div class="card-header">
            <h4>Tabel Peralatan Laboratorium</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="data_tabel" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-start">
                        <tr>
                            <th>#</th>
                            <th>Nama Alat</th>
                            <th class="text-center">Tahun Pengadaan</th>
                            <th>Fungsi</th>
                            <th>Lokasi / Tempat</th>
                        </tr>

                    </thead>
                    <tbody class="text-start" style="text-transform: uppercase">
                        @foreach ($data['peralatan_laboratorium'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['nama'] }}</td>
                                <td class="text-center">{{ $item['tahun'] }}</td>
                                <td>{{ $item['fungsi'] }}</td>
                                <td>{{ $item['lokasi'] }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
