<?php

namespace Database\Seeders;

use App\Models\InstrumenAkreditasi;
use Illuminate\Database\Seeder;

class InstrumenAkreditasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $instrumen = [
            [
                'nama' => 'Kerjasama',
                'slug' => 'kerjasama'
            ],
            [
                'nama' => 'Seleksi Mahasiswa Baru',
                'slug' => 'seleksi'
            ],
            [
                'nama' => 'Mahasiswa Asing',
                'slug' => 'asing'
            ],
            [
                'nama' => 'Dosen Tetap Perguruan Tinggi',
                'slug' => 'dtpt'
            ],
            [
                'nama' => 'Dosen Pembimbing Utama Tugas Akhir',
                'slug' => 'dosen_pembimbing_utama'
            ],
            [
                'nama' => 'Ekuivalen Waktu Mengajar Penuh (EWMP) Dosen Tetap Perguruan Tinggi',
                'slug' => 'ewmp'
            ],
            [
                'nama' => 'Dosen Tidak Tetap',
                'slug' => 'dosen_tt'
            ],
            [
                'nama' => 'Dosen Industri / Praktisi',
                'slug' => 'dosen_industri'
            ],
            [
                'nama' => 'Pengakuan / Rekognisi Dosen Tetap',
                'slug' => 'rekognisi_dtps'
            ],
            [
                'nama' => 'Penelitian Dosen Tetap',
                'slug' => 'penelitian_dtps'
            ],
            [
                'nama' => 'Pengabdian Kepada Masyarakat Dosen Tetap',
                'slug' => 'pengabdian_dtps'
            ],
            [
                'nama' => 'Publikasi Ilmiah Dosen Tetap',
                'slug' => 'publikasi_dtps'
            ],
            [
                'nama' => 'Pagelaran / Pameran / Presentasi / Publikasi Ilmiah Dosen Tetap',
                'slug' => 'pagelaran_pameran_dtps'
            ],
            [
                'nama' => 'Karya Ilmiah Dosen Tetap yang Disitasi',
                'slug' => 'karya_ilmiah_dtps_sitasi'
            ],
            [
                'nama' => 'Produk / Jasa Dosen Tetap yang Diadopsi oleh Industri / Masyarakat',
                'slug' => 'produk_jasa_dtps'
            ],
            [
                'nama' => 'HKI (Paten / Paten Sederhana) Dosen Tetap',
                'slug' => 'hki_paten_dtps'
            ],
            [
                'nama' => 'HKI (Hak Cipta, Desain Produk, dll) Dosen Tetap',
                'slug' => 'hki_hak_cipta_dtps'
            ],
            [
                'nama' => 'Teknologi Tepat Guna, Produk, Karya Seni, Rekayasa Sosial Dosen Tetap',
                'slug' => 'teknologi_tepat_guna_dtps'
            ],
            [
                'nama' => 'Buku Ber-ISBN, Book Chapter',
                'slug' => 'buku_dtps'
            ],
            [
                'nama' => 'Penggunaan Dana',
                'slug' => 'penggunaan_dana'
            ],
            [
                'nama' => 'Kurikulum, Capaian Pembelajaran, dan Rencana Pembelajaran',
                'slug' => 'kurikulum_capaian'
            ],
            [
                'nama' => 'Integrasi Kegiatan Penelitian / Pengabdian kepada Masyarakat dalam Pembelajaran',
                'slug' => 'integrasi_penelitian_pkm_pembelajaran'
            ],
            [
                'nama' => 'Kepuasan Mahasiswa',
                'slug' => 'kepuasan_mahasiswa'
            ],
            [
                'nama' => 'Penelitian Dosen Tetap yang Melibatkan Mahasiswa',
                'slug' => 'penelitian_dtps_mahasiswa'
            ],
            [
                'nama' => 'Penelitian Dosen Tetap yang Menjadi Rujukan Tema Tesis / Disertasi',
                'slug' => 'penelitian_dtps_rujukan_tema'
            ],
            [
                'nama' => 'Pengabdian Kepada Masyarakat Dosen Tetap yang Melibatkan Mahasiswa',
                'slug' => 'pengabdian_dtps_mahasiswa'
            ],
            [
                'nama' => 'IPK Lulusan',
                'slug' => 'ipk_lulusan'
            ],
            [
                'nama' => 'Prestasi Akademik Mahasiswa',
                'slug' => 'prestasi_akademik_mahasiswa'
            ],
            [
                'nama' => 'Prestasi Non-Akademik Mahasiswa',
                'slug' => 'prestasi_non_akademik_mahasiswa'
            ],
            [
                'nama' => 'Masa Studi Lulusan',
                'slug' => 'masa_studi_lulusan'
            ],
            [
                'nama' => 'Lulus Tepat Waktu',
                'slug' => 'lulusan_tepat_waktu'
            ],
            [
                'nama' => 'Waktu Tunggu Lulusan',
                'slug' => 'waktu_tunggu_lulusan'
            ],
            [
                'nama' => 'Kesesuaian Bidang Kerja Lulusan',
                'slug' => 'kesesuaian_bidang'
            ],
            [
                'nama' => 'Tempat Kerja Lulusan',
                'slug' => 'tempat_kerja'
            ],
            [
                'nama' => 'Kepuasan Pengguna Lulusan',
                'slug' => 'kepuasan_pengguna'
            ],
            [
                'nama' => 'Publikasi Ilmiah Mahasiswa',
                'slug' => 'publikasi_mahasiswa'
            ],
            [
                'nama' => 'Pagelaran / Pameran / Presentasi / Publikasi Ilmiah Mahasiswa',
                'slug' => 'pagelaran_pameran_mahasiswa'
            ],
            [
                'nama' => 'Karya Ilmiah Mahasiswa yang Disitasi',
                'slug' => 'karya_mahasiswa_sitasi'
            ],
            [
                'nama' => 'Produk / Jasa Mahasiswa yang Diadopsi oleh Industri/Masyarakat',
                'slug' => 'produk_jasa_mahasiswa'
            ],
            [
                'nama' => 'Luaran Penelitian yang dihasilkan Mahasiswa - HKI (Paten, Paten Sederhana)',
                'slug' => 'hki_paten_mahasiswa'
            ],
            [
                'nama' => 'Luaran Penelitian yang Dihasilkan Mahasiswa - HKI (Hak Cipta, Desain Produk Industri, dll)',
                'slug' => 'hki_hak_cipta_mahasiswa'
            ],
            [
                'nama' => 'Luaran Penelitian yang Dihasilkan Mahasiswa -Teknologi Tepat Guna, Produk, Karya Seni, Rekayasa Sosial',
                'slug' => 'teknologi_produk_mahasiswa'
            ],
            [
                'nama' => 'Luaran Penelitian yang Dihasilkan Mahasiswa - Buku ber-ISBN, Book Chapter',
                'slug' => 'buku_mahasiswa'
            ],
            [
                'nama' => 'Peralatan Laboratorium',
                'slug' => 'peralatan_laboratorium'
            ],
        ];

        foreach ($instrumen as $item) {
            InstrumenAkreditasi::create($item);
        }
    }
}
