@if (isset($data['luaran_hki_hak_cipta_dosen']))
    <div class="card">
        <div class="card-header">
            <h4>Tabel HKI (Hak Cipta, Desain Produk Industri) oleh Dosen Tetap</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="data_tabel" style="font-size: 0.9rem">
                    <thead style="background-color: #e7ecff;color:#002f67" class="text-start">
                        <tr>
                            <th>#</th>
                            <th>Nama/Judul Hak Kekayaan Intelektual (HKI)</th>
                            <th class="text-center">Tahun Perolehan</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                        </tr>

                    </thead>
                    <tbody class="text-start" style="text-transform: uppercase">
                        @if (isset($data['luaran_hki_hak_cipta_dosen']))
                            @foreach ($data['luaran_hki_hak_cipta_dosen'] as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucwords($item['judul']) }}</td>
                                    <td class="text-center">{{ $item['tahun'] }}</td>
                                    <td>{{ $item['jenis'] }}</td>
                                    <td>{{ $item['keterangan'] }}</td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
