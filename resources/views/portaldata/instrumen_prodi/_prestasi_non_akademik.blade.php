@if (isset($data['prestasi_non_akademik']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Prestasi Non-Akademik Mahasiswa</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Nama Kegiatan</th>
                        <th>Tahun Perolehan</th>
                        <th>Tingkat</th>
                        <th>Prestasi yang Dicapai</th>
                    </tr>
                </thead>
                <tbody class="text-center text-uppercase">
                    @if (isset($data['prestasi_non_akademik']))
                        @foreach ($data['prestasi_non_akademik'] as $i)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $i['nama'] }}</td>
                                <td>{{ $i['tahun']}}</td>
                                <td>{{ $i['tingkat']}}</td>
                                <td>{{ $i['prestasi']}}</td>

                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif