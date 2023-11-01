@if (isset($data['mahasiswa_asing']))
<div class="card">
    <div class="card-header">
        <h4>Tabel Mahasiswa Asing</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data_tabel" style="font-size: 0.9rem">
                <thead style="background-color: #e7ecff;color:#002f67" class="text-center">
                    <tr>
                        <th>Tahun Semester</th>
                        <th>Jumlah Mahasiswa Asing Penuh Waktu (Full-time)</th>
                        <th>Jumlah Mahasiswa Asing Paruh Waktu (Part-time)</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (isset($data['mahasiswa_asing']))
                        @foreach ($data['mahasiswa_asing'] as $i)
                            <tr>
                                <td>TS{{ 3 - $loop->iteration }}</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif