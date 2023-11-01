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
                    <h1 style="color:aliceblue">Program Studi {{ ucwords($prodi['nama']) }}</h1>

                    <!-- Text -->
                    <p class="fs-lg mb-7 mb-md-9" style="color:aliceblue">
                        Data Tabel Instrumen Borang Akreditasi Program Studi {{ ucwords($prodi['nama']) }}
                    </p>

                </div>

            </div>
        </div>
    </section>

    <section class="text-dark" style="background-color: #f2f7ff; padding-top: 4rem;">
        <div class="container">

            <div class="row mt-2">
                <div class="col-md-12" style="color: #002f67">

                    @include('portaldata.instrumen_prodi._kerjasama')
                    @include('portaldata.instrumen_prodi._seleksi_mahasiswa_baru')
                    @include('portaldata.instrumen_prodi._mahasiswa_asing')
                    @include('portaldata.instrumen_prodi._dosen_tetap')
                    @include('portaldata.instrumen_prodi._dosen_pembimbing_utama')
                    @include('portaldata.instrumen_prodi._dosen_tidak_tetap')
                    @include('portaldata.instrumen_prodi._dosen_industri')
                    @include('portaldata.instrumen_prodi._rekognisi_dosen')
                    @include('portaldata.instrumen_prodi._penelitian_dosen')
                    @include('portaldata.instrumen_prodi._pengabdian_dosen')
                    @include('portaldata.instrumen_prodi._publikasi_ilmiah')
                    @include('portaldata.instrumen_prodi._pagelaran_pameran')
                    @include('portaldata.instrumen_prodi._sitasi_dosen')
                    @include('portaldata.instrumen_prodi._produk_jasa_dosen')
                    @include('portaldata.instrumen_prodi._luaran_hki_paten_dosen')
                    @include('portaldata.instrumen_prodi._luaran_hki_hak_cipta_dosen')
                    @include('portaldata.instrumen_prodi._luaran_teknologi_dosen')
                    @include('portaldata.instrumen_prodi._buku_dosen')
                    @include('portaldata.instrumen_prodi._kurikulum_capaian')
                    @include('portaldata.instrumen_prodi._integrasi')
                    @include('portaldata.instrumen_prodi._kepuasan_mahasiswa')
                    @include('portaldata.instrumen_prodi._penelitian_dosen_mahasiswa')
                    @include('portaldata.instrumen_prodi._penelitian_dosen_dirujuk')
                    @include('portaldata.instrumen_prodi._pengabdian_dosen_mahasiswa')
                    @include('portaldata.instrumen_prodi._ipk_lulusan')
                    @include('portaldata.instrumen_prodi._prestasi_akademik')
                    @include('portaldata.instrumen_prodi._prestasi_non_akademik')
                    @include('portaldata.instrumen_prodi._masa_studi_lulusan')
                    @include('portaldata.instrumen_prodi._waktu_tunggu_lulusan')
                    @include('portaldata.instrumen_prodi._kesesuaian_bidang')
                    @include('portaldata.instrumen_prodi._tempat_kerja')
                    @include('portaldata.instrumen_prodi._publikasi_ilmiah_mahasiswa')
                    @include('portaldata.instrumen_prodi._pagelaran_pameran_mahasiswa')
                    @include('portaldata.instrumen_prodi._sitasi_mahasiswa')
                    @include('portaldata.instrumen_prodi._produk_jasa_mahasiswa')
                    @include('portaldata.instrumen_prodi._luaran_hki_paten_mahasiswa')
                    @include('portaldata.instrumen_prodi._luaran_hki_hak_cipta_mahasiswa')
                    @include('portaldata.instrumen_prodi._luaran_teknologi_mahasiswa')
                    @include('portaldata.instrumen_prodi._buku_mahasiswa')
                    @include('portaldata.instrumen_prodi._peralatan_laboratorium')


                </div>
            </div>

        </div>
    </section>


    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
