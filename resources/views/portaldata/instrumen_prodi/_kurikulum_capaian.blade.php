@if (isset($data['kurikulum_capaian']))
    <div class="card">
        <div class="card-header">
            <h4>Tabel Kurikulum, Capaian Pembelajaran, dan Rencana Pembelajaran</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="data_tabel" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Semester</th>
                            <th rowspan="2">Kode Mata Kuliah</th>
                            <th rowspan="2">Nama Mata Kuliah</th>
                            <th rowspan="2">Mata Kuliah Kompetensi</th>
                            <th colspan="3">Bobot Kredit (SKS)</th>
                            <th rowspan="2">Konversi Kredit ke Jam</th>
                            <th colspan="4">Capaian Pembelajaran</th>
                            <th rowspan="2">Dokumen Rencana Pembelajaran</th>
                            <th rowspan="2">Unit Penyelenggara</th>
                        </tr>
                        <tr>
                            <th>Kuliah/ Responsi/ Tutorial</th>
                            <th>Seminar</th>
                            <th>Praktikum/ Praktik/ Praktik Lapangan</th>
                            <th>Sikap</th>
                            <th>Pengetahuan</th>
                            <th>Keterampilan Umum</th>
                            <th>Keterampilan Khusus</th>
                        </tr>

                    </thead>
                    <tbody class="text-center" style="text-transform: uppercase">
                        @if (isset($data['kurikulum_capaian']))
                            @foreach ($data['kurikulum_capaian'] as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['semester'] }}</td>
                                    <td>{{ $item['kode'] }}</td>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $item['jenis'] }}</td>
                                    <td>{{ $item['sks'] - $item['sks_seminar'] - $item['sks_praktikum'] }}</td>
                                    <td>{{ $item['sks_seminar'] }}</td>
                                    <td>{{ $item['sks_praktikum'] }}</td>
                                    <td>{{ $item['konversi'] }}</td>
                                    <td>
                                        @if ($item['capaian_sikap'] == 1)
                                            &#x2705;
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['capaian_pengetahuan'] == 1)
                                            &#x2705;
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['capaian_keterampilan_umum'] == 1)
                                            &#x2705;
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['capaian_keterampilan_khusus'] == 1)
                                            &#x2705;
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item['jenis_dokumen'] }}</td>
                                    <td>{{ $item['unit_penyelenggara'] }}</td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
