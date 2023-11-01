@extends('portaldata.template')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <style>
        .dataTables_length label {
            color: #607080;
        }

        .dataTables_filter label {
            color: #607080;
        }

        .dataTables_info {
            color: #607080;
        }
    </style>
    <section class="text-light p-5" style="background-color: #002f67">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 text-center">

                    <!-- Heading -->
                    <h1 style="color:aliceblue">Universitas Tadulako</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Data Tabel Instrumen Borang Akreditasi Perguruan Tinggi
                    </p>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color: rgb(133 128 171);
                    font-style: italic;
                    font-family: monospace;
                    font-size: medium;">
                        Last update at {{ $update ?? 'undefined'}} WIB
                    </p>

                </div>

            </div>
        </div>
    </section>

    <section class="text-dark" style="background-color: #f2f7ff; padding-top: 4rem;">
        <div class="container">

            <div class="row mt-2">
                <div class="col-md-12" style="color: #002f67">
                    
                    @include('portaldata.instrumen_universitas._akreditasi_sertifikasi_eksternal')
                    @include('portaldata.instrumen_universitas._akreditasi_internasional')
                    @include('portaldata.instrumen_universitas._audit_keuangan_eksternal')
                    @include('portaldata.instrumen_universitas._akreditasi_prodi')
                    @include('portaldata.instrumen_universitas._kerjasama')
                    @include('portaldata.instrumen_universitas._seleksi_mahasiswa_baru')
                    @include('portaldata.instrumen_universitas._mahasiswa_asing')
                    @include('portaldata.instrumen_universitas._kecukupan_dosen')
                    @include('portaldata.instrumen_universitas._jabatan_akademik_dosen')
                    @include('portaldata.instrumen_universitas._sertifikasi_dosen')
                    @include('portaldata.instrumen_universitas._dosen_tidak_tetap')
                    @include('portaldata.instrumen_universitas._rasio_dosen_mahasiswa')
                    @include('portaldata.instrumen_universitas._penelitian_dosen')
                    @include('portaldata.instrumen_universitas._pengabdian_dosen')
                    @include('portaldata.instrumen_universitas._rekognisi_dosen')
                    @include('portaldata.instrumen_universitas._perolehan_dana')
                    @include('portaldata.instrumen_universitas._ipk_mahasiswa')
                    @include('portaldata.instrumen_universitas._prestasi_mahasiswa')
                    @include('portaldata.instrumen_universitas._prestasi_non_akademik_mahasiswa')
                    @include('portaldata.instrumen_universitas._lama_studi_mahasiswa')
                    @include('portaldata.instrumen_universitas._lulusan_tepat_waktu')
                    @include('portaldata.instrumen_universitas._masa_tunggu_lulusan')
                    @include('portaldata.instrumen_universitas._kesesuaian_bidang_kerja')
                    @include('portaldata.instrumen_universitas._jumlah_lulusan_dinilai_pengguna')
                    @include('portaldata.instrumen_universitas._kepuasan_pengguna_lulusan')
                    @include('portaldata.instrumen_universitas._tempat_kerja_lulusan')
                    @include('portaldata.instrumen_universitas._publikasi_ilmiah')
                    @include('portaldata.instrumen_universitas._sitasi')
                    @include('portaldata.instrumen_universitas._luaran_hki_paten')
                    @include('portaldata.instrumen_universitas._luaran_hki_hak_cipta')
                    @include('portaldata.instrumen_universitas._luaran_teknologi_produk_seni')
                    @include('portaldata.instrumen_universitas._luaran_buku')

                    
                    
                </div>
            </div>

        </div>
    </section>


    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
