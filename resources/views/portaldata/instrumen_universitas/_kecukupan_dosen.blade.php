<div class="card">
    <div class="card-header">
        <h4>Tabel Kecukupan Dosen</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Fakultas / Unit Pengelola PS</th>
                        <th colspan="3">Pendidikan Tertinggi</th>
                        <th rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th>Doktor/ Doktor Terapan/ Subspesialis</th>
                        <th>Magister/ Magister Terapan/ Spesialis</th>
                        <th>Profesi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['kecukupan_dosen']))
                        @foreach ($data['kecukupan_dosen'] as $item)
                            @if ($loop->last)
                                <tr style="font-weight: bold; background-color: #e7ecff;">
                                    <td>#</td>
                                    <td style="text-align: start">{{ $item['fakultas'] }}</td>
                                    <td>{{ $item['doctoral'] }}</td>
                                    <td>{{ $item['magister'] }}</td>
                                    <td>{{ $item['profesi'] }}</td>
                                    <td>{{ $item['jumlah'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: start">{{ $item['fakultas'] }}</td>
                                    <td>{{ $item['doctoral'] }}</td>
                                    <td>{{ $item['magister'] }}</td>
                                    <td>{{ $item['profesi'] }}</td>
                                    <td style="font-weight: bold">{{ $item['jumlah'] }}</td>
                                </tr>
                            @endif
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
