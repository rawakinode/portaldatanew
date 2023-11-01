@if (isset($data['rekognisi_dosen']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Rekognisi / Pengakuan Dosen</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive text-wrap">
            <table class="table" id="kerjasama" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-left">
                    <tr>
                        <th>#</th>
                        <th>Nama Dosen</th>
                        <th>Bidang Keahlian</th>
                        <th>Rekognisi dan Bukti Pendukung</th>
                        <th>Tahun</th>
                      </tr>
                </thead>
                <tbody class="text-left">
                    @if (isset($data['rekognisi_dosen']))
                        @foreach ($data['rekognisi_dosen'] as $item)
                            <tr class="text-uppercase">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['dosen_homebase']['nama'] }}</td>
                                <td>{{ $item['bidang'] }}</td>
                                <td>{{ $item['rekognisi'] }}</td>
                                <td>{{ $item['tahun'] }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif