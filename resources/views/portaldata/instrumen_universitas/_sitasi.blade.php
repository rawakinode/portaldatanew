<div class="card">
    <div class="card-header">
        <h4>Tabel Publikasi Ilmiah yang Disitasi (3 Tahun Terakhir)</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-start">
                    <tr>
                        <th>#</th>
                        <th>Nama Penulis</th>
                        <th  class="text-center">Tahun Terbit</th>
                        <th>Judul Artikel yang Disitasi (Jurnal, Volume, Tahun, Nomor, Halaman)</th>
                        <th class="text-center">Banyak Artikel yang Mensitasi</th>
                    </tr>

                </thead>
                <tbody class="text-start">
                    @if (isset($data['sitasi']))
                        @foreach ($data['sitasi'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['penulis_dosen'] }}</td>
                                <td  class="text-center">{{ $item['tahun'] }}</td>
                                <td>{{ ucwords($item['judul']) }} ({{ $item['publikasi'] }})</td>
                                <td class="text-center">{{ $item['sitasi'] }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
