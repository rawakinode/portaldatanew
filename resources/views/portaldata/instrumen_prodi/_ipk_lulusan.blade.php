@if (isset($data['ipk_lulusan']))
<div class="card">
    <div class="card-header">
        <h4>Tabel IPK Lulusan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th>Tahun Semester</th>
                        <th>Jumlah Lulusan</th>
                        <th>IPK Minimal</th>
                        <th>IPK Rata-rata</th>
                        <th>IPK Maksimal</th>
                    </tr>
                </thead>
                <tbody class="text-center text-uppercase">
                    @if (isset($data['ipk_lulusan']))
                        @foreach ($data['ipk_lulusan'] as $i)
                            <tr>
                                <td>{{ $i['nama'] }}</td>
                                <td>{{ $i['jumlah']}}</td>
                                <td>{{ $i['min'] ? $i['min'] : '-' }}</td>
                                <td>{{ $i['rata'] ? round($i['rata'], 2) : '-' }}</td>
                                <td>{{ $i['max'] ? $i['max'] : '-' }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif