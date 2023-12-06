@if (isset($data['dosen_tidak_tetap']))
    <div class="card">
        <div class="card-header">
            <h4>Tabel Dosen Tidak Tetap</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="kerjasama" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-left">
                        <tr>
                            <th>#</th>
                            <th>Nama Dosen</th>
                            <th>NIDN/NIDK</th>
                            <th>Pendidikan</th>
                            <th>Pasca Sarjana</th>
                            <th>Bidang Keahlian</th>
                            <th>Jabatan Akademik</th>
                            <th>Sertifikat Pendidik Profesional</th>
                            <th>Sertifikat Kompetensi/ Profesi/ Industri</th>
                            <th>Mata Kuliah yang Diampu pada PS yang Diakreditasi</th>
                            <th>Kesesuaian Bidang Keahlian dengan Mata Kuliah yang Diampu</th>
                        </tr>

                    </thead>
                    <tbody class="text-left">
                        @if (isset($data['dosen_tidak_tetap']))
                            @foreach ($data['dosen_tidak_tetap'] as $item)
                                <tr class="text-uppercase">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $item['nidn'] }}</td>
                                    <td>{{ $item['pendidikan'] == 1 ? 'S1' : ($item['pendidikan'] == 2 ? 'S2' : ($item['pendidikan'] == 3 ? 'S3' : '')) }}</td>
                                    <td>{{ $item['pascasarjana'] }}</td>
                                    <td>{{ $item['bidang_keahlian'] }}</td>
                                    <td>
                                        @if ($item['fungsional'] == 1)
                                            Asisten Ahli
                                        @elseif ($item['fungsional'] == 2)
                                            Lektor
                                        @elseif ($item['fungsional'] == 3)
                                            Lektor Kepala
                                        @elseif ($item['fungsional'] == 4)
                                            Guru Besar
                                        @elseif ($item['fungsional'] == 5)
                                            Tenaga Pengajar
                                        @endif
                                    </td>
                                    <td>{{ $item['nomor_sertifikasi'] }}</td>
                                    <td>{{ $item['nomor_sertifikasi_profesi_industri'] }}</td>
                                    <td>{{ $item['matakuliah_prodi'] }}</td>
                                    <td>{{ $item['kesesuaian_matakuliah'] == 1 ? 'YA' : 'TIDAK' }}</td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
