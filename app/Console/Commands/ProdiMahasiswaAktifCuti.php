<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\Prodi;
use App\Models\RekapProdi;
use App\Models\StatusMahasiswa;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProdiMahasiswaAktifCuti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prodi-rekap-mahasiswa-aktif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk melakukan rekap data mahasiswa aktif ke database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $periode = Periode::where('status', 1)->first();
        $ts = $periode['tahun'];

        $prodi = Prodi::orderBy('fakultas', 'ASC')->with('faculty')->get();
        $prodi->each(function ($item) use ($ts) {

            $jumlah_ts = collect([$ts, $ts - 1, $ts - 2, $ts - 3, $ts - 4, $ts - 5, $ts - 6]);
            $semester = collect([1, 2]);

            $maba_all = Mahasiswa::where('kode_prodi', $item->kode)->where('daftar_ulang', 1)->get();
            $bidikmisi_all = Mahasiswa::where('kode_prodi', $item->kode)->where('daftar_ulang', 1)->where('bidikmisi', 1)->get();
            $aktif_all = StatusMahasiswa::where('kode_prodi', $item->kode)->whereStatus('aktif')->with('mahasiswa')->get();
            $nonaktif_all = StatusMahasiswa::where('kode_prodi', $item->kode)->where('status', 'nonaktif')->with('mahasiswa')->get();
            $cuti_all = StatusMahasiswa::where('kode_prodi', $item->kode)->whereStatus('cuti')->with('mahasiswa')->get();

            $jumlah_ts->each(function ($jts) use ($item, $maba_all, $aktif_all, $cuti_all, $nonaktif_all, $bidikmisi_all, $semester) {

                $maha_baru = $maba_all->where('tahun_masuk', $jts);
                $mahasiswa_bidikmisi = $bidikmisi_all->where('tahun_masuk', $jts);
                $mhs_asing = $maba_all->filter(function ($item) {
                    return $item['asing'] == 1;
                })->where('tahun', $jts);


                $semester->each(function ($sem) use ($item, $maba_all, $aktif_all, $cuti_all, $nonaktif_all, $bidikmisi_all, $jts) {

                    $mhs_aktif = $aktif_all->where('tahun', $jts - 1)->where('semester', $sem);
                    $mhs_cuti = $cuti_all->where('tahun', $jts)->where('semester', $sem);
                    $mhs_non_aktif = $nonaktif_all->where('tahun', $jts)->where('semester', $sem);

                    $mhs_lulus = $maba_all->where('status_keluar', 'lulus')->filter(function ($i) use ($jts, $sem) {

                        if ($i['tanggal_yudisium'] === null || $i['tanggal_yudisium'] === 0) {
                            return false; // Skip this entry
                        }

                        $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                        $tanggalMulaiAjaran = Carbon::create($jts, 9, 1);
                        $tanggalAkhirAjaran = Carbon::create($jts + 1, 1, 31);

                        if ($sem == 2) {
                            $tanggalMulaiAjaran = Carbon::create($jts + 1, 2, 1);
                            $tanggalAkhirAjaran = Carbon::create($jts + 1, 8, 31);
                        }
                        return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                    });

                    //Input mahasiswa aktif
                    $check = RekapProdi::where('kode_prodi', $item->kode)->where('tahun',  $jts)->where('status', 'aktif')->where('semester', $sem)->first();

                    $pria = max(
                        $this->countByMahasiswaId($mhs_aktif, 1) -
                            $this->countByGender($mhs_lulus, 1),
                        0
                    );

                    $wanita = max(
                        $this->countByMahasiswaId($mhs_aktif, 0) -
                            $this->countByGender($mhs_lulus, 0),
                        0
                    );

                    $rekapData = [
                        'status' => 'aktif',
                        'kode_prodi' => $item->kode,
                        'fakultas' => $item['fakultas'],
                        'jenjang' => $item['jenjang'],
                        'tahun' => $jts,
                        'semester' => $sem,
                        'pria' => $pria,
                        'wanita' => $wanita,
                        'jumlah' => $pria + $wanita,
                    ];

                    if ($check) {
                        $check->update($rekapData);
                    } else {
                        RekapProdi::create($rekapData);
                    }

                    //Input Mahasiswa Nonaktif
                    $check = RekapProdi::where('kode_prodi', $item->kode)->where('tahun',  $jts)->where('status', 'nonaktif')->where('semester', $sem)->first();

                    $rekapData = [
                        'status' => 'nonaktif',
                        'kode_prodi' => $item->kode,
                        'fakultas' => $item['fakultas'],
                        'jenjang' => $item['jenjang'],
                        'tahun' => $jts,
                        'semester' => $sem,
                        'pria' => $this->countByMahasiswaId($mhs_non_aktif, 1),
                        'wanita' => $this->countByMahasiswaId($mhs_non_aktif, 0),
                        'jumlah' => $this->countByMahasiswaId($mhs_non_aktif, 1) + $this->countByMahasiswaId($mhs_non_aktif, 0),
                    ];

                    if ($check) {
                        $check->update($rekapData);
                    } else {
                        RekapProdi::create($rekapData);
                    }

                    //Input Mahasiswa Cuti
                    $check = RekapProdi::where('kode_prodi', $item->kode)->where('tahun',  $jts)->where('status', 'cuti')->where('semester', $sem)->first();

                    $rekapData = [
                        'status' => 'cuti',
                        'kode_prodi' => $item->kode,
                        'fakultas' => $item['fakultas'],
                        'jenjang' => $item['jenjang'],
                        'tahun' => $jts,
                        'semester' => $sem,
                        'pria' => $this->countByMahasiswaId($mhs_cuti, 1),
                        'wanita' => $this->countByMahasiswaId($mhs_cuti, 0),
                        'jumlah' => $this->countByMahasiswaId($mhs_cuti, 1) + $this->countByMahasiswaId($mhs_cuti, 0),
                    ];

                    if ($check) {
                        $check->update($rekapData);
                    } else {
                        RekapProdi::create($rekapData);
                    }

                    //Input Mahasiswa Lulus
                    $check = RekapProdi::where('kode_prodi', $item->kode)->where('tahun',  $jts)->where('status', 'lulus')->where('semester', $sem)->first();

                    $rekapData = [
                        'status' => 'lulus',
                        'kode_prodi' => $item->kode,
                        'fakultas' => $item['fakultas'],
                        'jenjang' => $item['jenjang'],
                        'tahun' => $jts,
                        'semester' => $sem,
                        'pria' => $this->countByGender($mhs_lulus, 1),
                        'wanita' => $this->countByGender($mhs_lulus, 0),
                        'jumlah' => $this->countByGender($mhs_lulus, 1) + $this->countByGender($mhs_lulus, 0),
                    ];

                    if ($check) {
                        $check->update($rekapData);
                    } else {
                        RekapProdi::create($rekapData);
                    }
                });

                //Input Mahasiswa Bidikmisi
                $check = RekapProdi::where('kode_prodi', $item->kode)->where('tahun',  $jts)->where('status', 'bidikmisi')->where('semester', 0)->first();

                $rekapData = [
                    'status' => 'bidikmisi',
                    'kode_prodi' => $item->kode,
                    'fakultas' => $item['fakultas'],
                    'jenjang' => $item['jenjang'],
                    'tahun' => $jts,
                    'semester' => 0,
                    'pria' => $this->countByGender($mahasiswa_bidikmisi, 1),
                    'wanita' => $this->countByGender($mahasiswa_bidikmisi, 0),
                    'jumlah' => $this->countByGender($mahasiswa_bidikmisi, 1) + $this->countByGender($mahasiswa_bidikmisi, 0),
                ];

                if ($check) {
                    $check->update($rekapData);
                } else {
                    RekapProdi::create($rekapData);
                }

                //Input Mahasiswa Asing
                $check = RekapProdi::where('kode_prodi', $item->kode)->where('tahun',  $jts)->where('status', 'asing')->where('semester', 0)->first();

                $rekapData = [
                    'status' => 'asing',
                    'kode_prodi' => $item->kode,
                    'fakultas' => $item['fakultas'],
                    'jenjang' => $item['jenjang'],
                    'tahun' => $jts,
                    'semester' => 0,
                    'pria' => $this->countByGender($mhs_asing, 1),
                    'wanita' => $this->countByGender($mhs_asing, 0),
                    'jumlah' => $this->countByGender($mhs_asing, 1) + $this->countByGender($mhs_asing, 0),
                ];

                if ($check) {
                    $check->update($rekapData);
                } else {
                    RekapProdi::create($rekapData);
                }

                //Input Mahasiswa Baru
                $check = RekapProdi::where('kode_prodi', $item->kode)->where('tahun',  $jts)->where('status', 'baru')->where('semester', 0)->first();

                $rekapData = [
                    'status' => 'baru',
                    'kode_prodi' => $item->kode,
                    'fakultas' => $item['fakultas'],
                    'jenjang' => $item['jenjang'],
                    'tahun' => $jts,
                    'semester' => 0,
                    'pria' => $this->countByGender($maha_baru, 1),
                    'wanita' => $this->countByGender($maha_baru, 0),
                    'jumlah' => $this->countByGender($maha_baru, 1) + $this->countByGender($maha_baru, 0),
                ];

                if ($check) {
                    $check->update($rekapData);
                } else {
                    RekapProdi::create($rekapData);
                }
            });
        });

        $this->info('Data inserted successfully.');
    }

    // Fungsi untuk menghitung jumlah berdasarkan kelamin
    private function countByGender($data, $gender)
    {
        return $data->filter(function ($item) use ($gender) {
            return $item['kelamin'] == $gender;
        })->count();
    }

    // Fungsi untuk menghitung jumlah berdasarkan mahasiswa id
    private function countByMahasiswaId($data, $gender)
    {
        return $data->filter(function ($item) use ($gender) {
            return $item->mahasiswa['kelamin'] == $gender;
        })->count();
    }
}
