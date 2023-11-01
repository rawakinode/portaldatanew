<div class="card">
    <div class="card-header">
        <h4>Tabel Rekognisi Dosen (3 Tahun Terakhir)</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Nama Dosen</th>
                        <th>Bidang Keahlian</th>
                        <th>Rekognisi</th>
                        <th>Tahun Perolehan</th>
                    </tr>

                </thead>
                <tbody class="text-start">
                    @if (isset($data['rekognisi_dosen']))
                        @foreach ($data['rekognisi_dosen'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['dosens']['nama'] }}</td>
                                <td>{{ $item['bidang'] }}</td>
                                <td>{{ $item['rekognisi'] }}</td>
                                <td class="text-center">{{ $item['tahun'] }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
