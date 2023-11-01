<div class="card">
    <div class="card-header">
        <h4>Tabel Audit Keuangan Eksternal</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67">
                    <tr>
                        <th>#</th>
                        <th>Lembaga Audit</th>
                        <th>Tahun</th>
                        <th>Opini</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($data['audit_keuangan_eksternal']))
                        @foreach ($data['audit_keuangan_eksternal'] as $item)
                            <tr class="text-uppercase">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['lembaga'] }}</td>
                                <td>{{ $item['tahun'] }}</td>
                                <td>{{ $item['opini'] }}</td>
                                <td>{{ $item['keterangan'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>