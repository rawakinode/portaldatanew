@if (isset($data['integrasi']))
    <div class="card">
        <div class="card-header">
            <h4>Tabel Integrasi Kegiatan Penelitian/Pengabdian dalam Pembelajaran</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="kerjasama" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Judul Penelitian / Pengabdian</th>
                            <th>Nama Dosen</th>
                            <th>Jenis</th>
                            <th>Bentuk Integrasi</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if (isset($data['integrasi']))
                            @foreach ($data['integrasi'] as $item)
                                <tr class="text-uppercase">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['judul'] }}</td>
                                    <td>
                                        @if ($item['dosen'])
                                            @foreach (json_decode($item['dosen']) as $s)
                                                {{ $s->dosen }} <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $item['jenis'] }}</td>
                                    <td>{{ $item['integrasi'] }}</td>
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
