@if (isset($data['penelitian_dosen_mahasiswa']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Penelitian Dosen yang Melibatkan Mahasiswa</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive text-wrap">
            <table class="table" id="kerjasama" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Nama Dosen</th>
                        <th>Tema Penelitian sesuai Roadmap</th>
                        <th>Nama Mahasiswa</th>
                        <th>Judul Kegiatan</th>
                        <th>Tahun</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['penelitian_dosen_mahasiswa']))
                        @foreach ($data['penelitian_dosen_mahasiswa'] as $item)
                            <tr class="text-uppercase">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item['dosen'])
                                        @foreach (json_decode($item['dosen']) as $s)
                                            {{ $s->dosen }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $item['tema'] }}</td>
                                <td>
                                    @if ($item['mahasiswa'])
                                        @foreach (json_decode($item['mahasiswa']) as $s)
                                            {{ $s->mahasiswa }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $item['judul'] }}</td>
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