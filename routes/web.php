<?php

use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\AktivasiController;
use App\Http\Controllers\AuditKeuanganExternalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DosenHomebaseController;
use App\Http\Controllers\DosenTetapProdiController;
use App\Http\Controllers\DosenTidakTetapController;
use App\Http\Controllers\HkiController;
use App\Http\Controllers\ImportDataProdiController;
use App\Http\Controllers\InstrumenAkreditasiController;
use App\Http\Controllers\JadwalKuliahController;
use App\Http\Controllers\KepuasanMahasiswaController;
use App\Http\Controllers\KerjasamaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaLulusController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\PembimbingTugasAkhirController;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\PengabdianController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PenggunaLulusanController;
use App\Http\Controllers\PeralatanLaboratoriumController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PerolehanDanaController;
use App\Http\Controllers\Portal\DosenController as PortalDosenController;
use App\Http\Controllers\Portal\InstrumenAkreditasiProdiController;
use App\Http\Controllers\Portal\InstrumenAkreditasiUniversitasController;
use App\Http\Controllers\Portal\JadwalPengajarController;
use App\Http\Controllers\Portal\KerjasamaController as PortalKerjasamaController;
use App\Http\Controllers\Portal\KurikulumController;
use App\Http\Controllers\Portal\LulusTepatWaktuController;
use App\Http\Controllers\Portal\MahasiswaBaruController;
use App\Http\Controllers\Portal\MahasiswaBidikmisiController;
use App\Http\Controllers\Portal\MahasiswaController as PortalMahasiswaController;
use App\Http\Controllers\Portal\PenelitianController as PortalPenelitianController;
use App\Http\Controllers\Portal\PengabdianController as PortalPengabdianController;
use App\Http\Controllers\Portal\PrestasiController as PortalPrestasiController;
use App\Http\Controllers\Portal\PublikasiController as PortalPublikasiController;
use App\Http\Controllers\PortalDataController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\RekognisiController;
use App\Http\Controllers\SeleksiMahasiswaBaruController;
use App\Http\Controllers\SertifikasiAkreditasiExternalController;
use App\Http\Controllers\SPMIController;
use App\Http\Controllers\StatusMahasiswaController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidasiController;
use App\Models\Faculty;
use App\Models\JadwalKuliah;
use App\Models\PembimbingTugasAkhir;
use App\Models\StatusMahasiswa;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return redirect('/data/mahasiswa/aktif');
});

//TEST
Route::get('/testing', [TestingController::class, 'index']);

//PORTAL DATA
Route::post('/data/prodi_list', [PortalDataController::class, 'get_prodi'])->name('get-prodi-list');

Route::get('/data/mahasiswa/aktif', [PortalMahasiswaController::class, 'index_aktif']);
Route::post('/data/mahasiswa/aktif', [PortalMahasiswaController::class, 'mahasiswa_aktif_get'])->name('mahasiswa_aktif_get');

Route::get('/data/mahasiswa/baru', [MahasiswaBaruController::class, 'index']);
Route::post('/data/mahasiswa/baru', [MahasiswaBaruController::class, 'get_data'])->name('mahasiswa_baru_get');

Route::get('/data/mahasiswa/bidikmisi', [MahasiswaBidikmisiController::class, 'index']);
Route::post('/data/mahasiswa/bidikmisi', [MahasiswaBidikmisiController::class, 'get_data'])->name('mahasiswa_bidikmisi_get');

Route::get('/data/mahasiswa/lulus', [LulusTepatWaktuController::class, 'index']);
Route::post('/data/mahasiswa/lulus', [LulusTepatWaktuController::class, 'get_data'])->name('mahasiswa_lulus_get');

Route::get('/data/dosen', [PortalDosenController::class, 'index']);
Route::post('/data/dosen', [PortalDosenController::class, 'get_data'])->name('dosen_get');

Route::get('/data/publikasi', [PortalPublikasiController::class, 'index']);
Route::post('/data/publikasi', [PortalPublikasiController::class, 'get_data'])->name('publikasi_get');

Route::get('/data/penelitian', [PortalPenelitianController::class, 'index']);
Route::post('/data/penelitian', [PortalPenelitianController::class, 'get_data'])->name('penelitian_get');

Route::get('/data/pengabdian', [PortalPengabdianController::class, 'index']);
Route::post('/data/pengabdian', [PortalPengabdianController::class, 'get_data'])->name('pengabdian_get');

Route::get('/data/kerjasama', [PortalKerjasamaController::class, 'index']);
Route::post('/data/kerjasama', [PortalKerjasamaController::class, 'get_data'])->name('kerjasama_get');

Route::get('/data/mahasiswa/prestasi', [PortalPrestasiController::class, 'index']);
Route::post('/data/mahasiswa/prestasi', [PortalPrestasiController::class, 'get_data'])->name('prestasi_get');

Route::get('/data/kurikulum', [KurikulumController::class, 'index']);
Route::post('/data/kurikulum', [KurikulumController::class, 'get_data'])->name('kurikulum_get');
Route::post('/data/kurikulum/prodilist', [KurikulumController::class, 'get_prodi_list'])->name('kurikulum_prodi_get');

Route::get('/data/jadwalpengajar', [JadwalPengajarController::class, 'index']);
Route::post('/data/jadwalpengajar', [JadwalPengajarController::class, 'get_data'])->name('jadwalpengajar_get');

Route::get('/data/spmi', [PortalDataController::class, 'index_spmi']);
Route::post('/data/spmi', [PortalDataController::class, 'get_spmi'])->name('portal-spmi-get');

Route::get('/data/instrumen', [InstrumenAkreditasiProdiController::class, 'list']);
Route::get('/data/instrumen/{id}', [InstrumenAkreditasiProdiController::class, 'index']);

Route::get('/data/instrumen_perguruan_tinggi', [InstrumenAkreditasiUniversitasController::class, 'index']);


//KHUSUS GUEST
Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'authenticate'])->name('authenticate');
});

//KHUSUS ADMIN & OPERATOR
Route::middleware(['auth'])->group(function () {

    Route::middleware('account_link')->group(function () {

        //Pangkalan data Universitas
        Route::group(['middleware' => ['can:pangkalan data universitas']], function () {

            Route::get('/data/universitas/sertifikasi_akreditasi_eksternal', [SertifikasiAkreditasiExternalController::class, 'index']);
            Route::get('/data/universitas/sertifikasi_akreditasi_eksternal/create', [SertifikasiAkreditasiExternalController::class, 'create']);
            Route::get('/data/universitas/sertifikasi_akreditasi_eksternal/{ids}/edit', [SertifikasiAkreditasiExternalController::class, 'edit']);
            Route::post('/data/universitas/sertifikasi_akreditasi_eksternal/{ids}/edit', [SertifikasiAkreditasiExternalController::class, 'update']);
            Route::post('/data/universitas/sertifikasi_akreditasi_eksternal', [SertifikasiAkreditasiExternalController::class, 'store']);
            Route::delete('/data/universitas/sertifikasi_akreditasi_eksternal', [SertifikasiAkreditasiExternalController::class, 'destroy']);

            Route::get('/data/universitas/audit_keuangan_eksternal', [AuditKeuanganExternalController::class, 'index']);
            Route::get('/data/universitas/audit_keuangan_eksternal/create', [AuditKeuanganExternalController::class, 'create']);
            Route::get('/data/universitas/audit_keuangan_eksternal/{ids}/edit', [AuditKeuanganExternalController::class, 'edit']);
            Route::post('/data/universitas/audit_keuangan_eksternal/{ids}/edit', [AuditKeuanganExternalController::class, 'update']);
            Route::post('/data/universitas/audit_keuangan_eksternal', [AuditKeuanganExternalController::class, 'store']);
            Route::delete('/data/universitas/audit_keuangan_eksternal', [AuditKeuanganExternalController::class, 'destroy']);
        });

        //Pengaturan SPMI Prodi / Universitas
        Route::get('/spmi/{slug}', [PengaturanController::class, 'index']);
        Route::post('/spmi/create/{slug}', [PengaturanController::class, 'store']);
        Route::post('/spmi/create_tambahan', [PengaturanController::class, 'storeTambahan']);
        Route::post('/spmi/delete_tambahan', [PengaturanController::class, 'deleteTambahan']);

        //Profil
        Route::get('/prodi/profil', [ProfilController::class, 'index']);
        Route::post('/prodi/profil/create', [ProfilController::class, 'store']);

        Route::group(['middleware' => ['can:view pangkalan data']], function () {
            //Pangkalan Data
            Route::get('/prodi/data/dosen', [DosenTetapProdiController::class, 'index']);
            Route::get('/prodi/data/dosen_tabel', [DosenTetapProdiController::class, 'table'])->name('dosen_table_get');
            Route::post('/prodi/data/dosen/create', [DosenTetapProdiController::class, 'store'])->name('create_dosen_tetap');
            Route::post('/prodi/data/dosen/details/', [DosenTetapProdiController::class, 'edit'])->name('edit_dosen_tetap');
            Route::post('/prodi/data/dosen/update', [DosenTetapProdiController::class, 'update'])->name('update_dosen_tetap');
            Route::delete('/prodi/data/dosen', [DosenTetapProdiController::class, 'destroy'])->name('delete_dosen_tetap');

            Route::get('/prodi/data/dosen_tt', [DosenTidakTetapController::class, 'index']);
            Route::get('/prodi/data/dosen_tt_tabel', [DosenTidakTetapController::class, 'table'])->name('dosen_tt_table_get');
            Route::post('/prodi/data/dosen_tt/create', [DosenTidakTetapController::class, 'store'])->name('create_dosen_tt');
            Route::post('/prodi/data/dosen_tt/details/', [DosenTidakTetapController::class, 'edit'])->name('edit_dosen_tt');
            Route::post('/prodi/data/dosen_tt/update', [DosenTidakTetapController::class, 'update'])->name('update_dosen_tt');
            Route::delete('/prodi/data/dosen_tt', [DosenTidakTetapController::class, 'destroy'])->name('delete_dosen_tt');

            Route::get('/prodi/data/kurikulum', [MataKuliahController::class, 'index']);
            Route::get('/prodi/data/kurikulum/create', [MataKuliahController::class, 'create']);
            Route::get('/prodi/data/kurikulum/{id}/edit', [MataKuliahController::class, 'edit']);
            Route::post('/prodi/data/kurikulum/{id}/edit', [MataKuliahController::class, 'update']);
            Route::post('/prodi/data/kurikulum/create', [MataKuliahController::class, 'store']);
            Route::delete('/prodi/data/kurikulum', [MataKuliahController::class, 'destroy']);

            Route::get('/prodi/data/jadwalkuliah', [JadwalKuliahController::class, 'index']);
            Route::get('/prodi/data/jadwalkuliah/create', [JadwalKuliahController::class, 'create']);
            Route::post('/prodi/data/jadwalkuliah/get_dosen_list', [JadwalKuliahController::class, 'get_dosen_list']);
            Route::post('/prodi/data/jadwalkuliah/create', [JadwalKuliahController::class, 'store']);
            Route::get('/prodi/data/jadwalkuliah/{id}/edit', [JadwalKuliahController::class, 'edit']);
            Route::post('/prodi/data/jadwalkuliah/{id}/edit', [JadwalKuliahController::class, 'update']);
            Route::delete('/prodi/data/jadwalkuliah', [JadwalKuliahController::class, 'destroy']);

            Route::get('/prodi/data/mahasiswa', [MahasiswaController::class, 'index']);
            Route::get('/prodi/data/mahasiswa/create', [MahasiswaController::class, 'create']);
            Route::get('/prodi/data/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit']);
            Route::post('/prodi/data/mahasiswa/{id}/edit', [MahasiswaController::class, 'update']);
            Route::post('/prodi/data/mahasiswa', [MahasiswaController::class, 'store']);
            Route::delete('/prodi/data/mahasiswa', [MahasiswaController::class, 'destroy']);

            Route::get('/prodi/data/prestasi', [PrestasiController::class, 'index']);
            Route::get('/prodi/data/prestasi/create', [PrestasiController::class, 'create']);
            Route::post('/prodi/data/prestasi', [PrestasiController::class, 'store']);
            Route::get('/prodi/data/prestasi/{ids}/edit', [PrestasiController::class, 'edit']);
            Route::post('/prodi/data/prestasi/{ids}/edit', [PrestasiController::class, 'update']);
            Route::delete('/prodi/data/prestasi', [PrestasiController::class, 'destroy']);

            Route::get('/prodi/data/kerjasama', [KerjasamaController::class, 'index']);
            Route::get('/prodi/data/kerjasama/create', [KerjasamaController::class, 'create']);
            Route::get('/prodi/data/kerjasama/{ids}/edit', [KerjasamaController::class, 'edit']);
            Route::post('/prodi/data/kerjasama/{ids}/edit', [KerjasamaController::class, 'update']);
            Route::post('/prodi/data/kerjasama', [KerjasamaController::class, 'store']);
            Route::delete('/prodi/data/kerjasama', [KerjasamaController::class, 'destroy']);

            Route::get('/prodi/data/penelitian', [PenelitianController::class, 'index']);
            Route::post('/prodi/data/penelitian', [PenelitianController::class, 'store']);
            Route::delete('/prodi/data/penelitian', [PenelitianController::class, 'destroy']);
            Route::get('/prodi/data/penelitian/create', [PenelitianController::class, 'create']);
            Route::get('/prodi/data/penelitian/{ids}/edit', [PenelitianController::class, 'edit']);
            Route::post('/prodi/data/penelitian/{ids}/edit', [PenelitianController::class, 'update']);

            Route::get('/prodi/data/pengabdian', [PengabdianController::class, 'index']);
            Route::post('/prodi/data/pengabdian', [PengabdianController::class, 'store']);
            Route::delete('/prodi/data/pengabdian', [PengabdianController::class, 'destroy']);
            Route::get('/prodi/data/pengabdian/create', [PengabdianController::class, 'create']);
            Route::get('/prodi/data/pengabdian/{ids}/edit', [PengabdianController::class, 'edit']);
            Route::post('/prodi/data/pengabdian/{ids}/edit', [PengabdianController::class, 'update']);

            Route::get('/prodi/data/publikasi', [PublikasiController::class, 'index']);
            Route::post('/prodi/data/publikasi', [PublikasiController::class, 'store']);
            Route::delete('/prodi/data/publikasi', [PublikasiController::class, 'destroy']);
            Route::get('/prodi/data/publikasi/create', [PublikasiController::class, 'create']);
            Route::get('/prodi/data/publikasi/{ids}/edit', [PublikasiController::class, 'edit']);
            Route::post('/prodi/data/publikasi/{ids}/edit', [PublikasiController::class, 'update']);

            Route::get('/prodi/data/statusmahasiswa', [StatusMahasiswaController::class, 'index']);
            Route::post('/prodi/data/statusmahasiswa', [StatusMahasiswaController::class, 'store']);
            Route::post('/prodi/data/statusmahasiswa/edit', [StatusMahasiswaController::class, 'update']);

            Route::get('/prodi/akreditasi/rekognisi', [RekognisiController::class, 'index']);
            Route::post('/prodi/akreditasi/rekognisi', [RekognisiController::class, 'store']);
            Route::delete('/prodi/akreditasi/rekognisi', [RekognisiController::class, 'destroy']);
            Route::get('/prodi/akreditasi/rekognisi/create', [RekognisiController::class, 'create']);
            Route::get('/prodi/akreditasi/rekognisi/{ids}/edit', [RekognisiController::class, 'edit']);
            Route::post('/prodi/akreditasi/rekognisi/{ids}/edit', [RekognisiController::class, 'update']);

            Route::get('/prodi/akreditasi/hki', [HkiController::class, 'index']);
            Route::post('/prodi/akreditasi/hki', [HkiController::class, 'store']);
            Route::delete('/prodi/akreditasi/hki', [HkiController::class, 'destroy']);
            Route::get('/prodi/akreditasi/hki/create', [HkiController::class, 'create']);
            Route::get('/prodi/akreditasi/hki/{ids}/edit', [HkiController::class, 'edit']);
            Route::post('/prodi/akreditasi/hki/{ids}/edit', [HkiController::class, 'update']);

            Route::get('/prodi/akreditasi/perolehan_dana', [PerolehanDanaController::class, 'index']);
            Route::post('/prodi/akreditasi/perolehan_dana', [PerolehanDanaController::class, 'store']);
            Route::delete('/prodi/akreditasi/perolehan_dana', [PerolehanDanaController::class, 'destroy']);
            Route::get('/prodi/akreditasi/perolehan_dana/create', [PerolehanDanaController::class, 'create']);
            Route::get('/prodi/akreditasi/perolehan_dana/{ids}/edit', [PerolehanDanaController::class, 'edit']);
            Route::post('/prodi/akreditasi/perolehan_dana/{ids}/edit', [PerolehanDanaController::class, 'update']);

            Route::get('/prodi/akreditasi/tracer_study', [TracerStudyController::class, 'index']);
            Route::post('/prodi/akreditasi/tracer_study', [TracerStudyController::class, 'store']);
            Route::delete('/prodi/akreditasi/tracer_study', [TracerStudyController::class, 'destroy']);
            Route::get('/prodi/akreditasi/tracer_study/create', [TracerStudyController::class, 'create']);
            Route::get('/prodi/akreditasi/tracer_study/{ids}/edit', [TracerStudyController::class, 'edit']);
            Route::post('/prodi/akreditasi/tracer_study/{ids}/edit', [TracerStudyController::class, 'update']);

            Route::get('/prodi/akreditasi/pengguna_lulusan', [PenggunaLulusanController::class, 'index']);
            Route::post('/prodi/akreditasi/pengguna_lulusan', [PenggunaLulusanController::class, 'store']);
            Route::delete('/prodi/akreditasi/pengguna_lulusan', [PenggunaLulusanController::class, 'destroy']);
            Route::get('/prodi/akreditasi/pengguna_lulusan/create', [PenggunaLulusanController::class, 'create']);
            Route::get('/prodi/akreditasi/pengguna_lulusan/{ids}/edit', [PenggunaLulusanController::class, 'edit']);
            Route::post('/prodi/akreditasi/pengguna_lulusan/{ids}/edit', [PenggunaLulusanController::class, 'update']);

            Route::get('/prodi/data/seleksi_mahasiswa_baru', [SeleksiMahasiswaBaruController::class, 'index']);
            Route::post('/prodi/data/seleksi_mahasiswa_baru', [SeleksiMahasiswaBaruController::class, 'store']);
            Route::delete('/prodi/data/seleksi_mahasiswa_baru', [SeleksiMahasiswaBaruController::class, 'destroy']);
            Route::get('/prodi/data/seleksi_mahasiswa_baru/create', [SeleksiMahasiswaBaruController::class, 'create']);
            Route::get('/prodi/data/seleksi_mahasiswa_baru/{ids}/edit', [SeleksiMahasiswaBaruController::class, 'edit']);
            Route::post('/prodi/data/seleksi_mahasiswa_baru/{ids}/edit', [SeleksiMahasiswaBaruController::class, 'update']);

            Route::get('/prodi/akreditasi/produk', [ProdukController::class, 'index']);
            Route::post('/prodi/akreditasi/produk', [ProdukController::class, 'store']);
            Route::delete('/prodi/akreditasi/produk', [ProdukController::class, 'destroy']);
            Route::get('/prodi/akreditasi/produk/create', [ProdukController::class, 'create']);
            Route::get('/prodi/akreditasi/produk/{ids}/edit', [ProdukController::class, 'edit']);
            Route::post('/prodi/akreditasi/produk/{ids}/edit', [ProdukController::class, 'update']);

            Route::get('/prodi/akreditasi/buku', [BukuController::class, 'index']);
            Route::post('/prodi/akreditasi/buku', [BukuController::class, 'store']);
            Route::delete('/prodi/akreditasi/buku', [BukuController::class, 'destroy']);
            Route::get('/prodi/akreditasi/buku/create', [BukuController::class, 'create']);
            Route::get('/prodi/akreditasi/buku/{ids}/edit', [BukuController::class, 'edit']);
            Route::post('/prodi/akreditasi/buku/{ids}/edit', [BukuController::class, 'update']);
            
            Route::get('/prodi/akreditasi/kepuasan_mahasiswa', [KepuasanMahasiswaController::class, 'index']);
            Route::post('/prodi/akreditasi/kepuasan_mahasiswa', [KepuasanMahasiswaController::class, 'store']);
            Route::delete('/prodi/akreditasi/kepuasan_mahasiswa', [KepuasanMahasiswaController::class, 'destroy']);
            Route::get('/prodi/akreditasi/kepuasan_mahasiswa/create', [KepuasanMahasiswaController::class, 'create']);
            Route::get('/prodi/akreditasi/kepuasan_mahasiswa/{ids}/edit', [KepuasanMahasiswaController::class, 'edit']);
            Route::post('/prodi/akreditasi/kepuasan_mahasiswa/{ids}/edit', [KepuasanMahasiswaController::class, 'update']);

            Route::get('/prodi/data/mahasiswa_lulus', [MahasiswaLulusController::class, 'index']);

            Route::get('/prodi/data/pembimbing_tugas_akhir', [PembimbingTugasAkhirController::class, 'index']);
            Route::post('/prodi/data/pembimbing_tugas_akhir', [PembimbingTugasAkhirController::class, 'store']);
            Route::delete('/prodi/data/pembimbing_tugas_akhir', [PembimbingTugasAkhirController::class, 'destroy']);
            Route::get('/prodi/data/pembimbing_tugas_akhir/create', [PembimbingTugasAkhirController::class, 'create']);
            Route::get('/prodi/data/pembimbing_tugas_akhir/{ids}/edit', [PembimbingTugasAkhirController::class, 'edit']);
            Route::post('/prodi/data/pembimbing_tugas_akhir/{ids}/edit', [PembimbingTugasAkhirController::class, 'update']);

            Route::get('/prodi/akreditasi/instrumen', [InstrumenAkreditasiController::class, 'index']);
            Route::post('/prodi/akreditasi/instrumen', [InstrumenAkreditasiController::class, 'update']);

            Route::get('/prodi/akreditasi/peralatan_laboratorium', [PeralatanLaboratoriumController::class, 'index']);
            Route::post('/prodi/akreditasi/peralatan_laboratorium', [PeralatanLaboratoriumController::class, 'store']);
            Route::delete('/prodi/akreditasi/peralatan_laboratorium', [PeralatanLaboratoriumController::class, 'destroy']);
            Route::get('/prodi/akreditasi/peralatan_laboratorium/create', [PeralatanLaboratoriumController::class, 'create']);
            Route::get('/prodi/akreditasi/peralatan_laboratorium/{ids}/edit', [PeralatanLaboratoriumController::class, 'edit']);
            Route::post('/prodi/akreditasi/peralatan_laboratorium/{ids}/edit', [PeralatanLaboratoriumController::class, 'update']);

        });
    });

    //Dashboard dan Informasi
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/home/dashboard', [DashboardController::class, 'index']);
    Route::get('/home/info/about', function () {
        return view('admin.about.about');
    });
    Route::get('/home/info/hubungi', function () {
        return view('admin.about.hubungi');
    });

    //Halaman Universitas & Rektor & Dekan
    Route::get('/universitas/programstudi', [ProgramStudiController::class, 'index']);
    Route::get('/universitas/akreditasi', [AkreditasiController::class, 'index']);

    //Admin Manage Users
    Route::get('/admin/user', [UserController::class, 'index']);
    Route::post('/admin/user', [UserController::class, 'create']);
    Route::post('/admin/user/edit', [UserController::class, 'update']);
    Route::post('/admin/user/reset', [UserController::class, 'reset_password']);
    Route::delete('/admin/user', [UserController::class, 'destroy']);

    //Admin Manage Program Studi
    Route::get('/admin/prodi', [ProdiController::class, 'index']);
    Route::post('/admin/prodi', [ProdiController::class, 'store']);
    Route::post('/admin/prodi/edit', [ProdiController::class, 'update']);
    Route::post('/admin/prodi/link', [ProdiController::class, 'link']);
    Route::delete('/admin/prodi', [ProdiController::class, 'destroy']);

    //Admin Manage Periode
    Route::get('/admin/periode', [PeriodeController::class, 'index']);
    Route::post('/admin/periode', [PeriodeController::class, 'store']);
    Route::delete('/admin/periode', [PeriodeController::class, 'destroy']);
    Route::post('/admin/periode/select', [PeriodeController::class, 'selectPeriode']);

    //Admin Manage Aktivasi
    Route::post('/admin/aktivasi', [AktivasiController::class, 'update']);

    //Admin Manage Validasi
    Route::get('/admin/validasi', [ValidasiController::class, 'index']);
    Route::get('/admin/validasi/{id}', [ValidasiController::class, 'show']);
    Route::get('/admin/spmi/isian/{id}', [ValidasiController::class, 'show']);
    Route::post('/admin/validasi', [ValidasiController::class, 'update']);

    //Admin Manage SPMI
    Route::get('/admin/spmi', [SPMIController::class, 'index']);
    Route::post('/admin/spmi/import', [SPMIController::class, 'import']);

    //Admin Manage Portaldata Dosen
    Route::get('/portaldata/dosen', [DosenHomebaseController::class, 'index']);
    Route::post('/portaldata/dosen', [DosenHomebaseController::class, 'store']);
    Route::get('/portaldata/dosen/create', [DosenHomebaseController::class, 'create']);
    Route::get('/portaldata/dosen/{id}/edit', [DosenHomebaseController::class, 'edit']);
    Route::post('/portaldata/dosen/{id}/edit', [DosenHomebaseController::class, 'update']);
    Route::delete('/portaldata/dosen', [DosenHomebaseController::class, 'destroy']);



});
