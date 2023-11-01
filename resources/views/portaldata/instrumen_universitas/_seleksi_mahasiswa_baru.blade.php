<div class="card">
    <div class="card-header">
        <h4>Tabel Seleksi Mahasiswa Baru</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">Tahun Akademik</th>
                        <th rowspan="2">Daya Tampung</th>
                        <th colspan="2">Jumlah Calon Mahasiswa</th>
                        <th colspan="2">Jumlah Mahasiswa Baru</th>
                        <th colspan="2">Jumlah Mahasiswa Aktif</th>
                    </tr>
                    <tr>
                        <th>Pendaftar</th>
                        <th>Lulus Seleksi</th>
                        <th>Reguler</th>
                        <th>Transfer</th>
                        <th>Reguler</th>
                        <th>Transfer</th>
                    </tr>

                </thead>
                <tbody class="text-center">
                    @if (isset($data['seleksi_mahasiswa_baru']))
                        <tr>
                            <td colspan="10" style="background-color: #e7ecff;color:#002f67;font-weight:bold">Program Doktor/Doktor Terapan/Subspesialis</td>
                        </tr>

                        @foreach ($data['seleksi_mahasiswa_baru']['S3'] as $i)
                            <tr>
                                <td>TS{{ 5 - $loop->iteration }}</td>
                                <td>{{ $i['daya_tampung'] }}</td>
                                <td>{{ $i['pendaftar'] }}</td>
                                <td>{{ $i['lulus_seleksi'] }}</td>
                                <td>{{ $i['baru_reguler'] }}</td>
                                <td>{{ $i['baru_transfer'] }}</td>
                                <td>{{ $i['reguler'] }}</td>
                                <td>{{ $i['transfer'] }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="10" style="background-color: #e7ecff;color:#002f67;font-weight:bold">Program Magister/Magister Terapan/Spesialis</td>
                        </tr>

                        @foreach ($data['seleksi_mahasiswa_baru']['S2'] as $i)
                            <tr>
                                <td>TS{{ 5 - $loop->iteration }}</td>
                                <td>{{ $i['daya_tampung'] }}</td>
                                <td>{{ $i['pendaftar'] }}</td>
                                <td>{{ $i['lulus_seleksi'] }}</td>
                                <td>{{ $i['baru_reguler'] }}</td>
                                <td>{{ $i['baru_transfer'] }}</td>
                                <td>{{ $i['reguler'] }}</td>
                                <td>{{ $i['transfer'] }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="10" style="background-color: #e7ecff;color:#002f67;font-weight:bold">Program Profesi</td>
                        </tr>

                        @foreach ($data['seleksi_mahasiswa_baru']['PROF'] as $i)
                            <tr>
                                <td>TS{{ 5 - $loop->iteration }}</td>
                                <td>{{ $i['daya_tampung'] }}</td>
                                <td>{{ $i['pendaftar'] }}</td>
                                <td>{{ $i['lulus_seleksi'] }}</td>
                                <td>{{ $i['baru_reguler'] }}</td>
                                <td>{{ $i['baru_transfer'] }}</td>
                                <td>{{ $i['reguler'] }}</td>
                                <td>{{ $i['transfer'] }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="10" style="background-color: #e7ecff;color:#002f67;font-weight:bold">Program Sarjana</td>
                        </tr>

                        @foreach ($data['seleksi_mahasiswa_baru']['S1'] as $i)
                            <tr>
                                <td>TS{{ 5 - $loop->iteration }}</td>
                                <td>{{ $i['daya_tampung'] }}</td>
                                <td>{{ $i['pendaftar'] }}</td>
                                <td>{{ $i['lulus_seleksi'] }}</td>
                                <td>{{ $i['baru_reguler'] }}</td>
                                <td>{{ $i['baru_transfer'] }}</td>
                                <td>{{ $i['reguler'] }}</td>
                                <td>{{ $i['transfer'] }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="10" style="background-color: #e7ecff;color:#002f67;font-weight:bold">Program Diploma Empat / Sarjana Terapan</td>
                        </tr>

                        @foreach ($data['seleksi_mahasiswa_baru']['D4'] as $i)
                            <tr>
                                <td>TS{{ 5 - $loop->iteration }}</td>
                                <td>{{ $i['daya_tampung'] }}</td>
                                <td>{{ $i['pendaftar'] }}</td>
                                <td>{{ $i['lulus_seleksi'] }}</td>
                                <td>{{ $i['baru_reguler'] }}</td>
                                <td>{{ $i['baru_transfer'] }}</td>
                                <td>{{ $i['reguler'] }}</td>
                                <td>{{ $i['transfer'] }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="10" style="background-color: #e7ecff;color:#002f67;font-weight:bold">Program Diploma Tiga</td>
                        </tr>

                        @foreach ($data['seleksi_mahasiswa_baru']['D3'] as $i)
                            <tr>
                                <td>TS{{ 5 - $loop->iteration }}</td>
                                <td>{{ $i['daya_tampung'] }}</td>
                                <td>{{ $i['pendaftar'] }}</td>
                                <td>{{ $i['lulus_seleksi'] }}</td>
                                <td>{{ $i['baru_reguler'] }}</td>
                                <td>{{ $i['baru_transfer'] }}</td>
                                <td>{{ $i['reguler'] }}</td>
                                <td>{{ $i['transfer'] }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="10" style="background-color: #e7ecff;color:#002f67;font-weight:bold">Program Diploma Dua</td>
                        </tr>

                        @foreach ($data['seleksi_mahasiswa_baru']['D2'] as $i)
                            <tr>
                                <td>TS{{ 5 - $loop->iteration }}</td>
                                <td>{{ $i['daya_tampung'] }}</td>
                                <td>{{ $i['pendaftar'] }}</td>
                                <td>{{ $i['lulus_seleksi'] }}</td>
                                <td>{{ $i['baru_reguler'] }}</td>
                                <td>{{ $i['baru_transfer'] }}</td>
                                <td>{{ $i['reguler'] }}</td>
                                <td>{{ $i['transfer'] }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="10" style="background-color: #e7ecff;color:#002f67;font-weight:bold">Program Diploma Satu</td>
                        </tr>

                        @foreach ($data['seleksi_mahasiswa_baru']['D1'] as $i)
                            <tr>
                                <td>TS{{ 5 - $loop->iteration }}</td>
                                <td>{{ $i['daya_tampung'] }}</td>
                                <td>{{ $i['pendaftar'] }}</td>
                                <td>{{ $i['lulus_seleksi'] }}</td>
                                <td>{{ $i['baru_reguler'] }}</td>
                                <td>{{ $i['baru_transfer'] }}</td>
                                <td>{{ $i['reguler'] }}</td>
                                <td>{{ $i['transfer'] }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
