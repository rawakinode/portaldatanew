@if (isset($data['dosen_tetap']))
    <div class="card">
        <div class="card-header">
            <h4>Tabel Dosen Tetap</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="kerjasama" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-left">
                        <tr>
                            <th>#</th>
                            <th>Nama Dosen</th>
                            <th>NIDN / NIDK</th>
                            <th>S2</th>
                            <th>S3</th>
                            <th>Bidang Keahlian</th>
                            <th>Kesesuaian dengan Kompetensi Inti PS</th>
                            <th>Sertifikat Pendidik Profesional</th>
                            <th>Sertifikat Kompetensi/ Profesi/ Industri</th>
                            <th>Mata Kuliah yang Diampu pada PS yang Diakreditasi</th>
                            <th>Kesesuaian Bidang Keahlian dengan Mata Kuliah yang Diampu</th>
                            <th>Mata Kuliah yang Diampu pada PS Lain</th>
                        </tr>

                    </thead>
                    <tbody class="text-left">
                        @if (isset($data['dosen_tetap']))
                            @foreach ($data['dosen_tetap'] as $item)
                                <tr class="text-uppercase">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['dosen_prodi']['nama'] }}</td>
                                    <td>{{ $item['nidn'] }}</td>
                                    <td>{{ $item['dosen_prodi']['pendidikan_magister'] ?? '-'}}</td>
                                    <td>{{ $item['dosen_prodi']['pendidikan_doctoral'] ?? '-'}}</td>
                                    <td>{{ $item['dosen_prodi']['bidang_keahlian'] ?? '-'}}</td>
                                    <td>{{ $item['kesesuaian_kompetensi'] == 1 ? 'Sesuai' : 'Tidak Sesuai'}}</td>
                                    <td>{{ $item['nomor_sertifikasi'] ?? '-'}}</td>
                                    <td>{{ $item['nomor_sertifikasi_profesi_industri'] ?? '-'}}</td>
                                    <td>{{ $item['matakuliah_prodi'] ?? '-'}}</td>
                                    <td>{{ $item['kesesuaian_matakuliah'] == 1 ? 'Sesuai' : 'Tidak Sesuai'}}</td>
                                    <td>{{ $item['matakuliah_prodi_lain'] ?? '-'}}</td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
