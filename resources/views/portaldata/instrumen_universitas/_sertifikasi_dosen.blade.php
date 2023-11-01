<div class="card">
    <div class="card-header">
        <h4>Tabel Sertifikasi Dosen (Pendidik Profesional/Profesi/Industri/Kompetensi)</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Fakultas / Unit Pengelola PS</th>
                        <th>Jumlah Dosen</th>
                        <th>Jumlah Dosen Bersertifikasi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['sertifikasi_dosen']))
                        @foreach ($data['sertifikasi_dosen'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td style="text-align: start">{{ $item['fakultas'] }}</td>
                                    <td>{{ $item['dosen'] }}</td>
                                    <td>{{ $item['dosen_bersertifikat'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start">{{ $item['fakultas'] }}</td>
                                    <td>{{ $item['dosen'] }}</td>
                                    <td>{{ $item['dosen_bersertifikat'] }}</td>
                                </tr>
                            @endif
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
