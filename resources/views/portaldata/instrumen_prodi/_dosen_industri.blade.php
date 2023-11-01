@if (isset($data['dosen_industri']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Dosen Industri Praktisi</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive text-wrap">
            <table class="table" id="kerjasama" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-left">
                    <tr>
                        <th>#</th>
                        <th>Nama Dosen Industri/ Praktisi</th>
                        <th>NIDK</th>
                        <th>Perusahaan/ Industri</th>
                        <th>Bidang Keahlian</th>
                        <th>Sertifikat Profesi/ Kompetensi/ Industri</th>
                        <th>Mata Kuliah yang Diampu</th>
                    </tr>

                </thead>
                <tbody class="text-left">
                    @if (isset($data['dosen_industri']))
                        @foreach ($data['dosen_industri'] as $item)
                            <tr class="text-uppercase">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ $item['nidn'] }}</td>
                                <td>{{ $item['perusahaan_industri'] ?? '-'}}</td>
                                <td>{{ $item['bidang_keahlian'] ?? '-' }}</td>
                                <td>{{ $item['nomor_sertifikasi_profesi_industri'] ?? '-' }}</td>
                                <td>{{ $item['matakuliah_prodi'] ?? '-' }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif