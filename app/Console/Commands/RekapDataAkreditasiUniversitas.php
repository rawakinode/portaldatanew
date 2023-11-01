<?php

namespace App\Console\Commands;

use App\Models\AkreditasiRekapUniversitas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\AuditKeuanganExternal;
use App\Models\Buku;
use App\Models\Dosen;
use App\Models\DosenHomebase;
use App\Models\DosenTidakTetap;
use App\Models\Faculty;
use App\Models\Hki;
use App\Models\Kerjasama;
use App\Models\Mahasiswa;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\Periode;
use App\Models\PerolehanDana;
use App\Models\Prestasi;
use App\Models\Prodi;
use App\Models\Profil;
use App\Models\Publikasi;
use App\Models\Rekognisi;
use App\Models\SeleksiMahasiswaBaru;
use App\Models\SertifikasiAkreditasiExternal;
use App\Models\StatusMahasiswa;
use App\Models\TracerStudy;
use Carbon\Carbon;

class RekapDataAkreditasiUniversitas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rekap-data-universitas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk mengambil data dan rekap ke database.';

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

        //Set variabel
        $data = collect();

        $periode = Periode::where('status', 1)->first();
        $ts = $periode['tahun'];

        //Akreditasi Internasional PS
        $this->info("Memproses Akreditasi Internasional");
        $akre_int_ps = Profil::where('akreditasi_internasional', 1)->with('prodi')->get();
        if ($akre_int_ps->count()) {
            $data['akreditasi_internasional'] = $akre_int_ps;
        }


        //Akreditasi Sertifikasi Eksternal
        $this->info("Memproses Sertifikasi Eksternal");
        $hasil = SertifikasiAkreditasiExternal::where('tahun_berakhir', '>=', $ts)->get();
        $data['akreditasi_sertifikasi_eksternal'] = $hasil;


        //Audit Keuangan Eksternal
        $this->info("Memproses Audit Keuangan Eksternal");
        $hasil = AuditKeuanganExternal::where('tahun', $ts)->get();
        $data['audit_keuangan_eksternal'] = $hasil;

        $this->info("Memproses Akreditasi Prodi");
        //Akreditasi PS
        $tabel = [
            'unggul' => [
                'akreditasi' => 'Terakreditasi Unggul',
                'S3' => 0,
                'S2' => 0,
                'S1' => 0,
                'PROF' => 0,
                'D4' => 0,
                'D3' => 0,
                'D2' => 0,
                'D1' => 0,
                'total' => 0,
            ],
            'a' => [
                'akreditasi' => 'Terakreditasi A',
                'S3' => 0,
                'S2' => 0,
                'S1' => 0,
                'PROF' => 0,
                'D4' => 0,
                'D3' => 0,
                'D2' => 0,
                'D1' => 0,
                'total' => 0,
            ],
            'baik_sekali' => [
                'akreditasi' => 'Terakreditasi Baik Sekali',
                'S3' => 0,
                'S2' => 0,
                'S1' => 0,
                'PROF' => 0,
                'D4' => 0,
                'D3' => 0,
                'D2' => 0,
                'D1' => 0,
                'total' => 0,
            ],
            'b' => [
                'akreditasi' => 'Terakreditasi B',
                'S3' => 0,
                'S2' => 0,
                'S1' => 0,
                'PROF' => 0,
                'D4' => 0,
                'D3' => 0,
                'D2' => 0,
                'D1' => 0,
                'total' => 0,
            ],
            'baik' => [
                'akreditasi' => 'Terakreditasi Baik',
                'S3' => 0,
                'S2' => 0,
                'S1' => 0,
                'PROF' => 0,
                'D4' => 0,
                'D3' => 0,
                'D2' => 0,
                'D1' => 0,
                'total' => 0,
            ],
            'c' => [
                'akreditasi' => 'Terakreditasi C',
                'S3' => 0,
                'S2' => 0,
                'S1' => 0,
                'PROF' => 0,
                'D4' => 0,
                'D3' => 0,
                'D2' => 0,
                'D1' => 0,
                'total' => 0,
            ],
            'tidak_akreditasi' => [
                'akreditasi' => 'Tidak Terakreditasi',
                'S3' => 0,
                'S2' => 0,
                'S1' => 0,
                'PROF' => 0,
                'D4' => 0,
                'D3' => 0,
                'D2' => 0,
                'D1' => 0,
                'total' => 0,
            ],
            'total' => [
                'akreditasi' => 'TOTAL',
                'S3' => 0,
                'S2' => 0,
                'S1' => 0,
                'PROF' => 0,
                'D4' => 0,
                'D3' => 0,
                'D2' => 0,
                'D1' => 0,
                'total' => 0,
            ],
        ];

        $prodi = Prodi::with('profil')->get();

        foreach ($prodi as $item) {

            if (isset($item['profil']['akreditasi']) && isset($item['jenjang'])) {
                $akreditasi = $item['profil']['akreditasi'];
                $jenjang = $item['jenjang'];

                if ($akreditasi == 0 || $akreditasi == null) {
                    $tabel['tidak_akreditasi']['total'] += 1;
                    $tabel['tidak_akreditasi'][$jenjang] += 1;
                } elseif ($akreditasi == 4) {
                    $tabel['unggul']['total'] += 1;
                    $tabel['unggul'][$jenjang] += 1;
                } elseif ($akreditasi == 1) {
                    $tabel['a']['total'] += 1;
                    $tabel['a'][$jenjang] += 1;
                } elseif ($akreditasi == 5) {
                    $tabel['baik_sekali']['total'] += 1;
                    $tabel['baik_sekali'][$jenjang] += 1;
                } elseif ($akreditasi == 2) {
                    $tabel['b']['total'] += 1;
                    $tabel['b'][$jenjang] += 1;
                } elseif ($akreditasi == 6) {
                    $tabel['baik']['total'] += 1;
                    $tabel['baik'][$jenjang] += 1;
                } elseif ($akreditasi == 3) {
                    $tabel['c']['total'] += 1;
                    $tabel['c'][$jenjang] += 1;
                }

                $tabel['total'][$jenjang] += 1;
                $tabel['total']['total'] += 1;
            }
        }

        $new_tabel = collect();
        $new_tabel->push(
            $tabel['unggul'],
            $tabel['a'],
            $tabel['baik_sekali'],
            $tabel['b'],
            $tabel['baik'],
            $tabel['c'],
            $tabel['tidak_akreditasi'],
            $tabel['total'],
        );
        $data['akreditasi_prodi'] = $new_tabel;


        //Mahasiswa Asing
        $this->info("Memproses Mahasiswa Asing");
        $fakultas = Faculty::all();
        $tabel = [];

        foreach ($fakultas as $item) {
            $tabel[] = [
                'fakultas' => $item['name'],
                'singkatan' => $item['singkatan'],
                'kode' => $item['code'],
                'ts' => 0,
                'ts1' => 0,
                'ts2' => 0,
                'jumlah' => 0,
            ];
        }

        $tabel[] = [
            'fakultas' => 'TOTAL',
            'singkatan' => 'total',
            'kode' => '',
            'ts' => 0,
            'ts1' => 0,
            'ts2' => 0,
            'jumlah' => 0,
        ];

        $mahasiswa = Mahasiswa::where('asing', 1)->with('prodi')->get();

        foreach ($mahasiswa as $item) {
            if (isset($item['prodi']['fakultas'])) {

                for ($i = 0; $i < count($tabel); $i++) {

                    if ($item['prodi']['fakultas'] == $tabel[$i]['kode']) {

                        $tabel[$i]['jumlah'] += 1;
                        $tabel[count($tabel) - 1]['jumlah'] += 1;

                        if ($item['tahun_masuk'] == $ts) {
                            $tabel[$i]['ts'] += 1;
                            $tabel[count($tabel) - 1]['ts'] += 1;
                        } else if ($item['tahun_masuk'] == ($ts - 1)) {
                            $tabel[$i]['ts1'] += 1;
                            $tabel[count($tabel) - 1]['ts1'] += 1;
                        } else if ($item['tahun_masuk'] == ($ts - 2)) {
                            $tabel[$i]['ts2'] += 1;
                            $tabel[count($tabel) - 1]['ts2'] += 1;
                        }
                    }
                }
            }
        }
        $data['mahasiswa_asing'] = $tabel;


        //Kecukupan Dosen PS
        $this->info("Memproses Kecukupan Dosen Prodi");
        $fakultas = Faculty::all();
        $tabel = [];

        foreach ($fakultas as $item) {
            $tabel[] = [
                'fakultas' => $item['name'],
                'singkatan' => $item['singkatan'],
                'kode' => $item['code'],
                'doctoral' => 0,
                'magister' => 0,
                'profesi' => 0,
                'jumlah' => 0,
            ];
        }

        $tabel[] = [
            'fakultas' => 'TOTAL',
            'singkatan' => 'total',
            'kode' => '',
            'doctoral' => 0,
            'magister' => 0,
            'profesi' => 0,
            'jumlah' => 0,
        ];

        $dosen = DosenHomebase::with('prodi_homebase')->get();

        foreach ($dosen as $item) {
            if (isset($item['prodi_homebase']['fakultas'])) {

                for ($i = 0; $i < count($tabel); $i++) {

                    if ($item['prodi_homebase']['fakultas'] == $tabel[$i]['kode']) {

                        $tabel[$i]['jumlah'] += 1;
                        $tabel[count($tabel) - 1]['jumlah'] += 1;

                        if ($item['pendidikan'] == 2) {
                            $tabel[$i]['magister'] += 1;
                            $tabel[count($tabel) - 1]['magister'] += 1;
                        } else if ($item['pendidikan'] == 3) {
                            $tabel[$i]['doctoral'] += 1;
                            $tabel[count($tabel) - 1]['doctoral'] += 1;
                        } else if ($item['pendidikan'] == 3) {
                            $tabel[$i]['profesi'] += 1;
                            $tabel[count($tabel) - 1]['profesi'] += 1;
                        }
                    }
                }
            }
        }

        $data['kecukupan_dosen'] = $tabel;


        //Jabatan Akademik Dosen Tetap
        $this->info("Memproses Jabatan Akademik Dosen Tetap");
        $pendidikan = ['Doktor/ Doktor Terapan/ Subspesialis', 'Magister/ Magister Terapan/ Spesialis', 'Profesi', 'TOTAL'];
        $tabel = [];

        foreach ($pendidikan as $item) {
            $tabel[] = [
                'pendidikan' => $item,
                'tenaga_pengajar' => 0,
                'guru_besar' => 0,
                'lektor_kepala' => 0,
                'lektor' => 0,
                'asisten_ahli' => 0,
                'jumlah' => 0,
            ];
        }

        $dosen = DosenHomebase::with('prodi_homebase')->get();

        foreach ($dosen as &$item) {

            $pendidikan_location = -1;

            if ($item['pendidikan'] == 3) {
                $pendidikan_location = 0;
            } else if ($item['pendidikan'] == 2) {
                $pendidikan_location = 1;
            } else if ($item['pendidikan'] == 4) {
                $pendidikan_location = 2;
            }

            $fungsional_location = null;

            if ($item['fungsional'] == 5) {
                $fungsional_location = 'tenaga_pengajar';
            } else if ($item['fungsional'] == 4) {
                $fungsional_location = 'guru_besar';
            } else if ($item['fungsional'] == 3) {
                $fungsional_location = 'lektor_kepala';
            } else if ($item['fungsional'] == 2) {
                $fungsional_location = 'lektor';
            } else if ($item['fungsional'] == 1) {
                $fungsional_location = 'asisten_ahli';
            }

            if ($pendidikan_location > -1 && $fungsional_location != null) {
                $tabel[$pendidikan_location][$fungsional_location] += 1;
                $tabel[3][$fungsional_location] += 1;
                $tabel[$pendidikan_location]['jumlah'] += 1;
                $tabel[3]['jumlah'] += 1;
            }
        }
        $data['jabatan_akademik_dosen'] = $tabel;


        //Sertifikasi Dosen Tetap
        $this->info("Memproses Sertifikasi Dosen Tetap");
        $fakultas = Faculty::all();
        $tabel = [];

        foreach ($fakultas as $item) {
            $tabel[] = [
                'fakultas' => $item['name'],
                'singkatan' => $item['singkatan'],
                'kode' => $item['code'],
                'dosen' => 0,
                'dosen_bersertifikat' => 0,
            ];
        }

        $tabel[] = [
            'fakultas' => 'TOTAL',
            'singkatan' => 'total',
            'kode' => '',
            'dosen' => 0,
            'dosen_bersertifikat' => 0,
        ];

        $dosen = DosenHomebase::with('prodi_homebase')->get();

        foreach ($dosen as $item) {

            if (isset($item['prodi_homebase']['fakultas'])) {

                for ($i = 0; $i < count($tabel); $i++) {

                    if ($item['prodi_homebase']['fakultas'] == $tabel[$i]['kode']) {

                        $tabel[$i]['dosen'] += 1;
                        $tabel[count($tabel) - 1]['dosen'] += 1;

                        if ($item['nomor_sertifikasi'] != null || $item['nomor_sertifikasi'] != "") {
                            $tabel[$i]['dosen_bersertifikat'] += 1;
                            $tabel[count($tabel) - 1]['dosen_bersertifikat'] += 1;
                        }
                    }
                }
            }
        }

        $data['sertifikasi_dosen'] = $tabel;


        //Produktivitas Penelitian Dosen
        $this->info("Memproses Produktivitas Penelitian Dosen");
        $sumber = ['Perguruan Tinggi / Mandiri', 'Lembaga dalam Negeri (diluar PT)', 'Lembaga Luar Negeri', 'TOTAL'];
        $tabel = [];

        foreach ($sumber as $item) {
            $tabel[] = [
                'sumber_dana' => $item,
                'ts' => 0,
                'ts1' => 0,
                'ts2' => 0,
                'jumlah' => 0,
            ];
        }

        $penelitian = Penelitian::all();

        for ($n = 0; $n < count($penelitian); $n++) {

            $sum_dan = -1;

            if ($penelitian[$n]['sumber_dana'] == 'mandiri' || $penelitian[$n]['sumber_dana'] == 'perguruan tinggi') {
                $sum_dan = 0;
            } else if ($penelitian[$n]['sumber_dana'] == 'nasional') {
                $sum_dan = 1;
            } else if ($penelitian[$n]['sumber_dana'] == 'internasional') {
                $sum_dan = 2;
            }

            $tahun_aktif = null;

            if ($penelitian[$n]['tahun'] == $ts) {
                $tahun_aktif = 'ts';
            } else if ($penelitian[$n]['tahun'] == $ts - 1) {
                $tahun_aktif = 'ts1';
            } else if ($penelitian[$n]['tahun'] == $ts - 2) {
                $tahun_aktif = 'ts2';
            }

            if ($sum_dan != -1 && $tahun_aktif != null) {
                $tabel[$sum_dan][$tahun_aktif] += 1;
                $tabel[3][$tahun_aktif] += 1;
                $tabel[$sum_dan]['jumlah'] += 1;
                $tabel[3]['jumlah'] += 1;
            }
        }

        $data['penelitian_dosen'] = $tabel;


        //Produktivitas Pengabdian Dosen
        $this->info("Memproses Produktivitas Pengabdian Dosen");
        $sumber = ['Perguruan Tinggi / Mandiri', 'Lembaga dalam Negeri (diluar PT)', 'Lembaga Luar Negeri', 'TOTAL'];
        $tabel = [];

        foreach ($sumber as $item) {
            $tabel[] = [
                'sumber_dana' => $item,
                'ts' => 0,
                'ts1' => 0,
                'ts2' => 0,
                'jumlah' => 0,
            ];
        }

        $pengabdian = Pengabdian::all();

        for ($n = 0; $n < count($pengabdian); $n++) {

            $sum_dan = -1;

            if ($pengabdian[$n]['sumber_dana'] == 'mandiri' || $pengabdian[$n]['sumber_dana'] == 'perguruan tinggi') {
                $sum_dan = 0;
            } else if ($pengabdian[$n]['sumber_dana'] == 'nasional') {
                $sum_dan = 1;
            } else if ($pengabdian[$n]['sumber_dana'] == 'internasional') {
                $sum_dan = 2;
            }

            $tahun_aktif = null;

            if ($pengabdian[$n]['tahun'] == $ts) {
                $tahun_aktif = 'ts';
            } else if ($pengabdian[$n]['tahun'] == $ts - 1) {
                $tahun_aktif = 'ts1';
            } else if ($pengabdian[$n]['tahun'] == $ts - 2) {
                $tahun_aktif = 'ts2';
            }

            if ($sum_dan != -1 && $tahun_aktif != null) {
                $tabel[$sum_dan][$tahun_aktif] += 1;
                $tabel[3][$tahun_aktif] += 1;
                $tabel[$sum_dan]['jumlah'] += 1;
                $tabel[3]['jumlah'] += 1;
            }
        }

        $data['pengabdian_dosen'] = $tabel;


        //Rekognisi Pengakuan Dosen
        $this->info("Memproses Rekognisi Dosen");
        $tabel = Rekognisi::whereBetween('tahun', [$ts - 2, $ts])->orderBy('tahun', 'DESC')->with('dosen_homebase')->get();
        $data['rekognisi_dosen'] = $tabel;


        //Prestasi Akademik Mahasiswa
        $this->info("Memproses Prestasi Akademik Mahasiswa");
        $tabel = Prestasi::where('bidang', 'akademik')->whereBetween('tahun', [$ts - 2, $ts])->orderBy('tahun', 'DESC')->get();

        if ($tabel->count()) {
            $tabel[] = [
                'wilayah' => Prestasi::where('bidang', 'akademik')->whereBetween('tahun', [$ts - 2, $ts])->where('tingkat', 'lokal')->count(),
                'nasional' => Prestasi::where('bidang', 'akademik')->whereBetween('tahun', [$ts - 2, $ts])->where('tingkat', 'nasional')->count(),
                'internasional' => Prestasi::where('bidang', 'akademik')->whereBetween('tahun', [$ts - 2, $ts])->where('tingkat', 'internasional')->count(),
            ];
        }

        $data['prestasi_mahasiswa'] = $tabel;


        //Prestasi Non Akademik Mahasiswa
        $this->info("Memproses Prestasi Non Akademik Mahasiswa");
        $tabel = Prestasi::where('bidang', 'non-akademik')->whereBetween('tahun', [$ts - 2, $ts])->orderBy('tahun', 'DESC')->get();

        if ($tabel->count()) {
            $tabel[] = [
                'wilayah' => Prestasi::where('bidang', 'non-akademik')->whereBetween('tahun', [$ts - 2, $ts])->where('tingkat', 'lokal')->count(),
                'nasional' => Prestasi::where('bidang', 'non-akademik')->whereBetween('tahun', [$ts - 2, $ts])->where('tingkat', 'nasional')->count(),
                'internasional' => Prestasi::where('bidang', 'non-akademik')->whereBetween('tahun', [$ts - 2, $ts])->where('tingkat', 'internasional')->count(),
            ];
        }

        $data['prestasi_non_akademik_mahasiswa'] = $tabel;


        //Lama Studi Mahasiswa Lulusan
        $this->info("Memproses Lama Studi Lulusan");
        $pendidikan = ['Doktor/ Doktor Terapan/ Subspesialis', 'Magister/ Magister Terapan/ Spesialis', 'Profesi', 'Sarjana/ Diploma Empat/ Sarjana Terapan', 'Diploma Tiga', 'Diploma Dua', 'Diploma Satu', 'TOTAL'];

        $tabel = [];

        foreach ($pendidikan as $item) {
            $tabel[] = [
                'pendidikan' => $item,
                'lulusan_ts2' => 0,
                'lulusan_ts1' => 0,
                'lulusan_ts' => 0,
                'masa_ts2' => 0,
                'masa_ts1' => 0,
                'masa_ts' => 0,
            ];
        }

        $lulusan = Mahasiswa::where('status_keluar', 'lulus')->whereBetween('tahun_keluar', [$ts - 2, $ts])->with('prodi')->get();

        for ($i = 0; $i < count($lulusan); $i++) {

            if (isset($lulusan[$i]['prodi']['jenjang']) && isset($lulusan[$i]['tanggal_yudisium']) && $lulusan[$i]['tanggal_yudisium'] > 0) {

                $jenjang = $lulusan[$i]['prodi']['jenjang'];

                $pend = -1;
                if ($jenjang == 'D1') {
                    $pend = 6;
                } else if ($jenjang == 'D2') {
                    $pend = 5;
                } else if ($jenjang == 'D3') {
                    $pend = 4;
                } else if ($jenjang == 'D4' || $jenjang == 'S1') {
                    $pend = 3;
                } else if ($jenjang == 'PROF') {
                    $pend = 2;
                } else if ($jenjang == 'S2') {
                    $pend = 1;
                } else if ($jenjang == 'S3') {
                    $pend = 0;
                }

                $tahun_aktif = null;
                $masastudi = null;
                if ($lulusan[$i]['tahun_keluar'] == $ts) {
                    $tahun_aktif = 'lulusan_ts';
                    $masastudi = 'masa_ts';
                } else if ($lulusan[$i]['tahun_keluar'] == $ts - 1) {
                    $tahun_aktif = 'lulusan_ts1';
                    $masastudi = 'masa_ts1';
                } else if ($lulusan[$i]['tahun_keluar'] == $ts - 2) {
                    $tahun_aktif = 'lulusan_ts2';
                    $masastudi = 'masa_ts2';
                }

                //Menghitung rata2 masa studi
                $tgl_msk = Carbon::createFromDate($lulusan[$i]['tahun_masuk'], 9, 1);
                $tgl_yds = Carbon::parse($lulusan[$i]['tanggal_yudisium']);

                if ($pend != -1 && $tahun_aktif != null && $masastudi != null) {
                    $tabel[$pend][$tahun_aktif] += 1;
                    $tabel[7][$tahun_aktif] += 1;

                    $tabel[$pend][$masastudi] += $tgl_msk->diffInDays($tgl_yds);
                    $tabel[7][$masastudi] += $tgl_msk->diffInDays($tgl_yds);
                }
            }
        }

        for ($m = 0; $m < count($tabel) - 1; $m++) {

            if ($tabel[$m]['masa_ts'] > 0 && $tabel[$m]['lulusan_ts'] > 0) {
                $tabel[$m]['masa_ts'] = ($tabel[$m]['masa_ts'] / $tabel[$m]['lulusan_ts']) / 365;
            }

            if ($tabel[$m]['masa_ts1'] > 0 && $tabel[$m]['lulusan_ts1'] > 0) {
                $tabel[$m]['masa_ts1'] = ($tabel[$m]['masa_ts1'] / $tabel[$m]['lulusan_ts1']) / 365;
            }

            if ($tabel[$m]['masa_ts2'] > 0 && $tabel[$m]['lulusan_ts2'] > 0) {
                $tabel[$m]['masa_ts2'] = ($tabel[$m]['masa_ts2'] / $tabel[$m]['lulusan_ts2']) / 365;
            }
        }

        $data['lama_studi_mahasiswa'] = $tabel;


        //Masa Tunggu Lulusan Sampai Mendapatkan Pekerjaan
        $this->info("Memproses Masa Tunggu Lulusan");
        $pendidikan = ['Doktor/ Doktor Terapan/ Subspesialis', 'Magister/ Magister Terapan/ Spesialis', 'Profesi', 'Sarjana/ Diploma Empat/ Sarjana Terapan', 'Diploma Tiga', 'Diploma Dua', 'Diploma Satu'];

        $tabel = [];

        foreach ($pendidikan as $item) {
            $tabel[] = [
                'pendidikan' => $item,
                'lulusan_ts4' => 0,
                'lulusan_ts3' => 0,
                'lulusan_ts2' => 0,

            ];
        }

        $tracer = Mahasiswa::where('status_keluar', 'lulus')->whereBetween('tahun_keluar', [$ts - 4, $ts - 2])->with('prodi', 'tracer')->get();

        $count = 0;
        $count_ts2 = 0;
        $count_ts3 = 0;
        $count_ts4 = 0;

        for ($i = 0; $i < count($tracer); $i++) {

            if (isset($tracer[$i]['prodi']['jenjang'])) {

                $jenjang = $tracer[$i]['prodi']['jenjang'];

                $pend = -1;
                if ($jenjang == 'D1') {
                    $pend = 6;
                } else if ($jenjang == 'D2') {
                    $pend = 5;
                } else if ($jenjang == 'D3') {
                    $pend = 4;
                } else if ($jenjang == 'D4' || $jenjang == 'S1') {
                    $pend = 3;
                } else if ($jenjang == 'PROF') {
                    $pend = 2;
                } else if ($jenjang == 'S2') {
                    $pend = 1;
                } else if ($jenjang == 'S3') {
                    $pend = 0;
                }

                $tahun_aktif = null;
                if ($tracer[$i]['tahun_keluar'] == $ts - 2) {
                    $tahun_aktif = 'lulusan_ts2';
                    $count_ts2 += 1;
                } else if ($tracer[$i]['tahun_keluar'] == $ts - 3) {
                    $tahun_aktif = 'lulusan_ts3';
                    $count_ts3 += 1;
                } else if ($tracer[$i]['tahun_keluar'] == $ts - 4) {
                    $tahun_aktif = 'lulusan_ts4';
                    $count_ts4 += 1;
                }

                if ($pend != -1 && $tahun_aktif != null && isset($tracer[$i]['tracer'][0]['waktu_tunggu_kerja'])) {
                    $tabel[$pend][$tahun_aktif] += $tracer[$i]['tracer'][0]['waktu_tunggu_kerja'];
                }
            }

            for ($s = 0; $s < count($tabel); $s++) {
                if ($count_ts2 > 0) {
                    $tabel[$s]['lulusan_ts2'] = $tabel[$s]['lulusan_ts2'] / $count_ts2;
                }
                if ($count_ts3 > 0) {
                    $tabel[$s]['lulusan_ts3'] = $tabel[$s]['lulusan_ts3'] / $count_ts3;
                }
                if ($count_ts4 > 0) {
                    $tabel[$s]['lulusan_ts4'] = $tabel[$s]['lulusan_ts4'] / $count_ts4;
                }
            }
        }

        $data['masa_tunggu_lulusan'] = $tabel;


        //Kesesuaian Bidang Kerja Mahasiswa Lulusan
        $this->info("Memproses Kesesuaian Bidang Kerja");
        $pendidikan = ['Doktor/ Doktor Terapan/ Subspesialis', 'Magister/ Magister Terapan/ Spesialis', 'Profesi', 'Sarjana/ Diploma Empat/ Sarjana Terapan', 'Diploma Tiga', 'Diploma Dua', 'Diploma Satu'];

        $tabel = [];

        foreach ($pendidikan as $item) {
            $tabel[] = [
                'pendidikan' => $item,
                'lulusan_ts4' => 0,
                'lulusan_ts3' => 0,
                'lulusan_ts2' => 0,
                'total_ts4' => 0,
                'total_ts3' => 0,
                'total_ts2' => 0,
            ];
        }

        $tracer = Mahasiswa::where('status_keluar', 'lulus')->whereBetween('tahun_keluar', [$ts - 4, $ts - 2])->with('prodi', 'tracer')->get();

        for ($i = 0; $i < count($tracer); $i++) {

            if (isset($tracer[$i]['prodi']['jenjang'])) {

                $jenjang = $tracer[$i]['prodi']['jenjang'];

                $pend = -1;
                if ($jenjang == 'D1') {
                    $pend = 6;
                } else if ($jenjang == 'D2') {
                    $pend = 5;
                } else if ($jenjang == 'D3') {
                    $pend = 4;
                } else if ($jenjang == 'D4' || $jenjang == 'S1') {
                    $pend = 3;
                } else if ($jenjang == 'PROF') {
                    $pend = 2;
                } else if ($jenjang == 'S2') {
                    $pend = 1;
                } else if ($jenjang == 'S3') {
                    $pend = 0;
                }

                $tahun_aktif = null;
                $total_score = null;

                if ($tracer[$i]['tahun_keluar'] == $ts - 2) {
                    $tahun_aktif = 'lulusan_ts2';
                    $total_score = 'total_ts2';
                } else if ($tracer[$i]['tahun_keluar'] == $ts - 3) {
                    $tahun_aktif = 'lulusan_ts3';
                    $total_score = 'total_ts3';
                } else if ($tracer[$i]['tahun_keluar'] == $ts - 4) {
                    $tahun_aktif = 'lulusan_ts4';
                    $total_score = 'total_ts4';
                }

                if ($pend != -1 && $tahun_aktif != null && isset($tracer[$i]['tracer'][0]['kesesuaian_bidang_ilmu'])) {

                    if ($tracer[$i]['tracer'][0]['kesesuaian_bidang_ilmu'] == 'sesuai') {
                        $tabel[$pend][$tahun_aktif] += 1;
                    }

                    $tabel[$pend][$total_score] += 1;
                }
            }
        }

        $data['kesesuaian_bidang_kerja'] = $tabel;


        //Jumlah Lulusan yang Dinilai oleh Pengguna Lulusan
        $this->info("Memproses Jumlah Lulusan yang di nilai");
        $pendidikan = ['Doktor/ Doktor Terapan/ Subspesialis', 'Magister/ Magister Terapan/ Spesialis', 'Profesi', 'Sarjana/ Diploma Empat/ Sarjana Terapan', 'Diploma Tiga', 'Diploma Dua', 'Diploma Satu'];

        $tabel = [];

        foreach ($pendidikan as $item) {
            $tabel[] = [
                'pendidikan' => $item,
                'lulusan_ts4' => 0,
                'lulusan_ts3' => 0,
                'lulusan_ts2' => 0,
                'dinilai_ts4' => 0,
                'dinilai_ts3' => 0,
                'dinilai_ts2' => 0,
            ];
        }

        $tracer = Mahasiswa::where('status_keluar', 'lulus')->whereBetween('tahun_keluar', [$ts - 4, $ts - 2])->with('prodi', 'tracer')->get();

        for ($i = 0; $i < count($tracer); $i++) {

            if (isset($tracer[$i]['prodi']['jenjang'])) {

                $jenjang = $tracer[$i]['prodi']['jenjang'];

                $pend = -1;
                if ($jenjang == 'D1') {
                    $pend = 6;
                } else if ($jenjang == 'D2') {
                    $pend = 5;
                } else if ($jenjang == 'D3') {
                    $pend = 4;
                } else if ($jenjang == 'D4' || $jenjang == 'S1') {
                    $pend = 3;
                } else if ($jenjang == 'PROF') {
                    $pend = 2;
                } else if ($jenjang == 'S2') {
                    $pend = 1;
                } else if ($jenjang == 'S3') {
                    $pend = 0;
                }

                $tahun_aktif = null;
                $total_score = null;

                if ($tracer[$i]['tahun_keluar'] == $ts - 2) {
                    $tahun_aktif = 'lulusan_ts2';
                    $total_score = 'dinilai_ts2';
                } else if ($tracer[$i]['tahun_keluar'] == $ts - 3) {
                    $tahun_aktif = 'lulusan_ts3';
                    $total_score = 'dinilai_ts3';
                } else if ($tracer[$i]['tahun_keluar'] == $ts - 4) {
                    $tahun_aktif = 'lulusan_ts4';
                    $total_score = 'dinilai_ts4';
                }

                if ($pend != -1 && $tahun_aktif != null) {

                    $tabel[$pend][$tahun_aktif] += 1;

                    if (isset($tracer[$i]['tracer'][0]['kesesuaian_bidang_ilmu'])) {
                        $tabel[$pend][$total_score] += 1;
                    }
                }
            }
        }

        $data['jumlah_lulusan_dinilai_pengguna'] = $tabel;


        //Kepuasan Pengguna Lulusan
        $this->info("Memproses kepuasan pengguna lulusan");
        $aspek = [
            ['Etika', 'etika'],
            ['Keahlian pada Bidang Ilmu (Kompetensi Utama)', 'kompetensi_utama'],
            ['Kemampuan Berbahasa Asing', 'bahasa_asing'],
            ['Penggunaan Teknologi Informasi', 'teknologi_informasi'],
            ['Kemampuan Berkomunikasi', 'komunikasi'],
            ['Kerjasama', 'kerjasama'],
            ['Pengembangan Diri', 'pengembangan_diri']
        ];

        $tabel = [];

        foreach ($aspek as $item) {
            $tabel[] = [
                'judul' => $item[0],
                'aspek' => $item[1],
                'sangat_baik' => 0,
                'baik' => 0,
                'cukup' => 0,
                'kurang' => 0,
                'total' => 0,
            ];
        }

        $tracer = Mahasiswa::where('status_keluar', 'lulus')->whereBetween('tahun_keluar', [$ts - 4, $ts - 2])->with('prodi', 'pengguna_lulusan')->get();

        for ($i = 0; $i < count($tracer); $i++) {

            if (isset($tracer[$i]['prodi']['jenjang'])) {

                for ($m = 0; $m < count($tabel); $m++) {

                    if (isset($tracer[$i]['pengguna_lulusan'][0])) {

                        if ($tracer[$i]['pengguna_lulusan'][0][$tabel[$m]['aspek']] == 'sangat baik') {
                            $tabel[$m]['sangat_baik'] += 1;
                        } else if ($tracer[$i]['pengguna_lulusan'][0][$tabel[$m]['aspek']] == 'baik') {
                            $tabel[$m]['baik'] += 1;
                        } else if ($tracer[$i]['pengguna_lulusan'][0][$tabel[$m]['aspek']] == 'cukup') {
                            $tabel[$m]['cukup'] += 1;
                        } else if ($tracer[$i]['pengguna_lulusan'][0][$tabel[$m]['aspek']] == 'kurang') {
                            $tabel[$m]['kurang'] += 1;
                        }

                        $tabel[$m]['total'] += 1;
                    }
                }
            }
        }

        $data['kepuasan_pengguna_lulusan'] = $tabel;


        //Tempat Kerja Lulusan
        $this->info("Memproses tempat kerja lulusan");
        $pendidikan = ['Doktor/ Doktor Terapan/ Subspesialis', 'Magister/ Magister Terapan/ Spesialis', 'Profesi', 'Sarjana/ Diploma Empat/ Sarjana Terapan', 'Diploma Tiga', 'Diploma Dua', 'Diploma Satu'];

        $tabel = [];

        foreach ($pendidikan as $item) {
            $tabel[] = [
                'pendidikan' => $item,
                'lokal' => 0,
                'nasional' => 0,
                'internasional' => 0,
                'total' => 0,
            ];
        }

        $tracer = Mahasiswa::where('status_keluar', 'lulus')->whereBetween('tahun_keluar', [$ts - 4, $ts - 2])->with('prodi', 'tracer')->get();

        for ($i = 0; $i < count($tracer); $i++) {

            if (isset($tracer[$i]['prodi']['jenjang'])) {

                $jenjang = $tracer[$i]['prodi']['jenjang'];

                $pend = -1;
                if ($jenjang == 'D1') {
                    $pend = 6;
                } else if ($jenjang == 'D2') {
                    $pend = 5;
                } else if ($jenjang == 'D3') {
                    $pend = 4;
                } else if ($jenjang == 'D4' || $jenjang == 'S1') {
                    $pend = 3;
                } else if ($jenjang == 'PROF') {
                    $pend = 2;
                } else if ($jenjang == 'S2') {
                    $pend = 1;
                } else if ($jenjang == 'S3') {
                    $pend = 0;
                }

                $tingkat = null;

                if (isset($tracer[$i]['tracer'][0]['tingkat'])) {
                    if ($tracer[$i]['tracer'][0]['tingkat'] == 'lokal / wilayah / berwirausaha tidak berbadan hukum') {
                        $tingkat = 'lokal';
                    } else if ($tracer[$i]['tracer'][0]['tingkat'] == 'nasional / berwirausaha berbadan hukum') {
                        $tingkat = 'nasional';
                    } else if ($tracer[$i]['tracer'][0]['tingkat'] == 'multinasional / internasional,melanjutkan studi') {
                        $tingkat = 'internasional';
                    }
                }


                if ($pend != -1 && $tingkat != null) {

                    $tabel[$pend][$tingkat] += 1;
                }
            }
        }

        $data['tempat_kerja_lulusan'] = $tabel;


        //Publikasi Ilmiah
        $this->info("Memproses publikasi ilmiah");
        $jenis = [
            'Jurnal Penelitian Tidak Terakreditasi',
            'Jurnal Penelitian Nasional Terakreditasi',
            'Jurnal Penelitian Internasional',
            'Jurnal Penelitian Internasional Bereputasi',
            'Seminar Wilayah / Lokal / Perguruan Tinggi',
            'Seminar Nasional',
            'Seminar Internasional',
            'Tulisan di Media Massa Nasional',
            'Tulisan di Media Massa Internasional',
            'TOTAL',
        ];

        $tabel = [];

        foreach ($jenis as $item) {
            $tabel[] = [
                'jenis' => $item,
                'ts2' => 0,
                'ts1' => 0,
                'ts' => 0,
                'total' => 0,
            ];
        }

        $publikasi = Publikasi::whereBetween('tahun', [$ts - 2, $ts])->get();

        for ($i = 0; $i < count($publikasi); $i++) {

            $get_jenis = -1;

            if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional tidak terakreditasi') {
                $get_jenis = 0;
            } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional terakreditasi') {
                $get_jenis = 1;
            } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                $get_jenis = 2;
            } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional bereputasi') {
                $get_jenis = 3;
            } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'wilayah / lokal / PT') {
                $get_jenis = 4;
            } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                $get_jenis = 5;
            } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                $get_jenis = 6;
            } else if ($publikasi[$i]['jenis'] == 'media massa' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                $get_jenis = 7;
            } else if ($publikasi[$i]['jenis'] == 'media massa' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                $get_jenis = 8;
            }

            $tahun = null;

            if ($publikasi[$i]['tahun'] == $ts) {
                $tahun = 'ts';
            } else if ($publikasi[$i]['tahun'] == $ts - 1) {
                $tahun = 'ts1';
            } else if ($publikasi[$i]['tahun'] == $ts - 2) {
                $tahun = 'ts2';
            }

            if ($get_jenis != -1 && $tahun != null) {
                $tabel[$get_jenis][$tahun] += 1;
                $tabel[$get_jenis]['total'] += 1;
                $tabel[count($jenis) - 1][$tahun] += 1;
                $tabel[count($jenis) - 1]['total'] += 1;
            }
        }

        $data['publikasi_ilmiah'] = $tabel;


        //Publikasi Ilmiah yang Di Sitasi
        $this->info("Memproses publikasi ilmiah yang di sitasi");
        $tabel = Publikasi::whereBetween('tahun', [$ts - 2, $ts])->where('sitasi', '>', '0')->orderBy('tahun', 'DESC')->get();
        $data['sitasi'] = $tabel;


        //Luaran HKI Paten
        $this->info("Memproses HKI paten");
        $tabel = Hki::whereBetween('tahun', [$ts - 2, $ts])->whereNotNull('nidn')->whereIn('jenis', ['paten', 'paten sederhana'])->orderBy('tahun', 'DESC')->get();
        $data['luaran_hki_paten'] = $tabel;


        //Luaran HKI Hak Cipta
        $this->info("Memproses HKI hak cipta");
        $tabel = Hki::whereBetween('tahun', [$ts - 2, $ts])->whereNotNull('nidn')->whereIn('jenis', ['hak cipta', 'desain industri', 'perlindungan varietas tanaman', 'desain tata letak sirkuit terpadu', 'indikasi geografis'])->orderBy('tahun', 'DESC')->get();
        $data['luaran_hki_hak_cipta'] = $tabel;


        //Luaran Teknologi Tepat Guna
        $this->info("Memproses Teknologi tepat guna");
        $tabel = Hki::whereBetween('tahun', [$ts - 2, $ts])->whereNotNull('nidn')->whereIn('jenis', ['teknologi tepat guna', 'produk', 'karya seni', 'rekayasa sosial'])->orderBy('tahun', 'DESC')->get();
        $data['luaran_teknologi_produk_seni'] = $tabel;


        //Luaran Buku Ber-ISBN / Book Chapter
        $this->info("Memproses buku ber isbn");
        $tabel = Buku::whereBetween('tahun', [$ts - 2, $ts])->whereNotNull('isbn')->orderBy('tahun', 'DESC')->get();
        $data['luaran_buku'] = $tabel;


        //Seleksi Mahasiswa Baru
        $this->info("Memproses seleksi mahasiswa baru");
        $jenjang = ['S3', 'S2', 'S1', 'PROF', 'D4', 'D3', 'D2', 'D1'];
        $tahun_ts = [0,1,2,3,4];

        $tabel = [];

        $this->info("Memproses seleksi mahasiswa baru 2");
        $mahasiswa_baru = Mahasiswa::where('daftar_ulang', 1)->whereIn('tahun_masuk', [$ts-0,$ts-1,$ts-2,$ts-3,$ts-4,$ts-5,$ts-6,$ts-7])->with('prodi')->get();
        $this->info("Memproses seleksi mahasiswa baru 3");
        $seleksi_mahasiswa = SeleksiMahasiswaBaru::with('prodi')->get();

        $this->info("Lakukan iterasi ..");

        foreach ($jenjang as $itemJenjang) {
            $this->info("Memproses jenjang " . $itemJenjang);

            foreach ($tahun_ts as $i => $itemTahun) {
                $this->info("Memproses tahun " . $itemTahun);

                $ts_fix = $ts + $i - 4;

                $status_mahasiswa = StatusMahasiswa::whereIn('tahun', [$ts_fix])->with(['mahasiswa' => function ($query) {
                    return $query->with('prodi');
                }])->get();

                $maba_by_jenjang = $mahasiswa_baru->where('tahun_masuk', $ts_fix)->filter(function ($item) use ($itemJenjang) {
                    if (isset($item->prodi->jenjang)) {
                        return $item->prodi->jenjang == $itemJenjang;
                    }
                })->count();

                $sel_mhs_by_jenjang_ts = $seleksi_mahasiswa->filter(function ($item) use ($itemJenjang, $ts_fix) {
                    if (isset($item->prodi->jenjang)) {
                        return $item->prodi->jenjang == $itemJenjang && $item->tahun == $ts_fix;
                    }
                });

                $cek_sem = $status_mahasiswa->where('status', 'aktif')->where('tahun', $ts_fix)->where('semester', 2)->count();
                // $tanggalMulaiAjaran = Carbon::create($ts_fix + 1, 2, 1);
                // $tanggalAkhirAjaran = Carbon::create($ts_fix + 1, 8, 31);

                if ($cek_sem != 0) {
                    $cek_sem = 2;
                } else {
                    $cek_sem = 1;
                    // $tanggalMulaiAjaran = Carbon::create($ts_fix, 9, 1);
                    // $tanggalAkhirAjaran = Carbon::create($ts_fix + 1, 1, 31);
                }

                $aktif_by_tahun = $status_mahasiswa->filter(function($i) use ($itemJenjang){
                    if (isset($i->mahasiswa->prodi->jenjang)) {
                        return $i->mahasiswa->prodi->jenjang == $itemJenjang;
                    }
                });

                $aktif_by_tahun = $aktif_by_tahun->where('status', 'aktif')->where('tahun', $ts_fix)->where('semester', $cek_sem)->count();

                // $aktif_by_tahun = $aktif_by_tahun->where('status', 'aktif')->where('tahun', $ts_fix)->where('semester', $cek_sem)->filter(function ($i) use ($tanggalMulaiAjaran, $tanggalAkhirAjaran) {

                //     if ($i->mahasiswa['tanggal_yudisium'] == null || $i->mahasiswa['tanggal_yudisium'] == 0) {
                //         return $i;
                //     }

                //     $tanggalLulus = Carbon::parse($i->mahasiswa['tanggal_yudisium']);

                //     if ($tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran)) {
                //         return false;
                //     }

                //     return $i;
                        
                // })->count();

                $tabel[$itemJenjang][$itemTahun] = [
                    'daya_tampung' => $sel_mhs_by_jenjang_ts->sum('daya_tampung'),
                    'pendaftar' => $sel_mhs_by_jenjang_ts->sum('mahasiswa_mendaftar'),
                    'lulus_seleksi' => $sel_mhs_by_jenjang_ts->sum('mahasiswa_lulus_seleksi'),
                    'baru_reguler' => $maba_by_jenjang,
                    'baru_transfer' => $sel_mhs_by_jenjang_ts->sum('mahasiswa_baru_transfer'),
                    'reguler' => $aktif_by_tahun,
                    'transfer' => $sel_mhs_by_jenjang_ts->sum('mahasiswa_aktif_transfer'),
                ];
            }
        }

        $data['seleksi_mahasiswa_baru'] = $tabel;


        //Kerjasama PT
        $this->info("Memproses kerjasama perguruan tinggi");
        $kerjasama = Kerjasama::where('tahun', $ts)->orderBy('tahun', 'DESC')->get();

        $kerjasama->push([
            'jumlah_internasional' => Kerjasama::where('tahun', $ts)->where('tingkat', 'internasional')->count(),
            'jumlah_nasional' => Kerjasama::where('tahun', $ts)->where('tingkat', 'nasional')->count(),
            'jumlah_lokal' => Kerjasama::where('tahun', $ts)->where('tingkat', 'lokal')->count(),
        ]);

        $data['kerjasama'] = $kerjasama;


        //Dosen Tidak Tetap Perguruan Tinggi
        $this->info("Memproses dosen tidak tetap");
        $pendidikan = ['Doktor/ Doktor Terapan/ Subspesialis', 'Magister/ Magister Terapan/ Spesialis', 'Profesi', 'TOTAL'];
        $tabel = [];

        foreach ($pendidikan as $item) {
            $tabel[] = [
                'pendidikan' => $item,
                'tenaga_pengajar' => 0,
                'guru_besar' => 0,
                'lektor_kepala' => 0,
                'lektor' => 0,
                'asisten_ahli' => 0,
                'jumlah' => 0,
            ];
        }

        $dosen = DosenTidakTetap::all();

        $duplikat = $dosen->groupBy('nidn')->filter(function ($group) {
            return $group->count() > 1;
        });

        $duplikat->each(function ($group) {
            $group->slice(1)->each(function ($dosen) {
                $dosen->delete();
            });
        });

        foreach ($dosen as &$item) {

            $pendidikan_location = -1;

            if ($item['pendidikan'] == 3) {
                $pendidikan_location = 0;
            } else if ($item['pendidikan'] == 2) {
                $pendidikan_location = 1;
            } else if ($item['pendidikan'] == 4) {
                $pendidikan_location = 2;
            }

            $fungsional_location = null;

            if ($item['fungsional'] == 5) {
                $fungsional_location = 'tenaga_pengajar';
            } else if ($item['fungsional'] == 4) {
                $fungsional_location = 'guru_besar';
            } else if ($item['fungsional'] == 3) {
                $fungsional_location = 'lektor_kepala';
            } else if ($item['fungsional'] == 2) {
                $fungsional_location = 'lektor';
            } else if ($item['fungsional'] == 1) {
                $fungsional_location = 'asisten_ahli';
            }

            if ($pendidikan_location > -1 && $fungsional_location != null) {
                $tabel[$pendidikan_location][$fungsional_location] += 1;
                $tabel[3][$fungsional_location] += 1;
                $tabel[$pendidikan_location]['jumlah'] += 1;
                $tabel[3]['jumlah'] += 1;
            }
        }
        $data['dosen_tidak_tetap'] = $tabel;


        //Perolehan Dana
        $this->info("Memproses perolehan dana");
        $for_ts = [
            'ts' => 0,
            'ts1' => 0,
            'ts2' => 0,
            'jumlah' => 0,
        ];

        $tabel = [];

        $sumber = ['Mahasiswa', 'Kementerian/ Yayasan', 'Perguruan Tinggi', 'Sumber Lain (dalam / luar negeri)', 'Penelitian & Pengabdian Masyarakat'];
        $jenis = [
            ['SPP', 'Sumbangan Lainnya', 'Lain-Lain', 'Total'],
            ['Anggaran Rutin', 'Anggaran Pembangunan', 'Hibah Penelitian', 'Hibah Pengabdian Masyarakat', 'Lain-Lain', 'Total'],
            ['Jasa Layanan Profesi / Keahlian ', 'Produk Institusi', 'Kerjasama Kelembagaan (pemerintah atau swasta)', 'Lain-Lain', 'Total'],
            ['Hibah', 'Dana lestari dan filantropis', 'Lain-Lain', 'Total'],
            ['Dana Penelitian', 'Dana Pengabdian Masyarakat', 'Total']
        ];

        foreach ($sumber as $key => $s) {
            $tabel[$key]['sumber'] = $s;

            foreach ($jenis[$key] as $j) {
                $tabel[$key]['jenis'][] = [
                    'nama' => $j,
                    'data' => $for_ts
                ];
            }
        }

        $dana = PerolehanDana::whereBetween('tahun', [$ts - 2, $ts])->get();

        for ($i = 0; $i < count($dana); $i++) {

            if (isset($dana[$i]['sumber']) && isset($dana[$i]['jenis']) && isset($dana[$i]['jumlah']) && $dana[$i]['jumlah'] > 0) {

                $sb = -1;
                $jn = -1;

                if ($dana[$i]['sumber'] == 'mahasiswa') {
                    $sb = 0;
                    if ($dana[$i]['jenis'] == 'spp') {
                        $jn = 0;
                    } else if ($dana[$i]['jenis'] == 'sumbangan lain') {
                        $jn = 1;
                    } else if ($dana[$i]['jenis'] == 'lain-lain') {
                        $jn = 2;
                    }
                } else if ($dana[$i]['sumber'] == 'kementerian & yayasan') {
                    $sb = 1;
                    if ($dana[$i]['jenis'] == 'anggaran rutin') {
                        $jn = 0;
                    } else if ($dana[$i]['jenis'] == 'anggaran pembangunan') {
                        $jn = 1;
                    } else if ($dana[$i]['jenis'] == 'hibah penelitian') {
                        $jn = 2;
                    } else if ($dana[$i]['jenis'] == 'hibah pkm') {
                        $jn = 3;
                    } else if ($dana[$i]['jenis'] == 'lain-lain') {
                        $jn = 4;
                    }
                } else if ($dana[$i]['sumber'] == 'perguruan tinggi') {
                    $sb = 2;
                    if ($dana[$i]['jenis'] == 'jasa layanan profesi dan keahlian') {
                        $jn = 0;
                    } else if ($dana[$i]['jenis'] == 'produk institusi') {
                        $jn = 1;
                    } else if ($dana[$i]['jenis'] == 'kerjasama kelembagaan') {
                        $jn = 2;
                    } else if ($dana[$i]['jenis'] == 'lain-lain') {
                        $jn = 3;
                    }
                } else if ($dana[$i]['sumber'] == 'sumber lain') {
                    $sb = 3;
                    if ($dana[$i]['jenis'] == 'hibah') {
                        $jn = 0;
                    } else if ($dana[$i]['jenis'] == 'dana lestari dan filantropis') {
                        $jn = 1;
                    } else if ($dana[$i]['jenis'] == 'lain-lain') {
                        $jn = 2;
                    }
                }

                $th = null;
                if ($dana[$i]['tahun'] == $ts) {
                    $th = 'ts';
                } else if ($dana[$i]['tahun'] == $ts - 1) {
                    $th = 'ts1';
                } else if ($dana[$i]['tahun'] == $ts - 2) {
                    $th = 'ts2';
                }

                if ($sb != -1 && $jn != -1 && $th != null) {
                    $tabel[$sb]['jenis'][$jn]['data'][$th] += $dana[$i]['jumlah'];

                    $tabel[$sb]['jenis'][$jn]['data']['jumlah'] += $dana[$i]['jumlah'];
                    $tabel[$sb]['jenis'][count($tabel[$sb]['jenis']) - 1]['data'][$th] += $dana[$i]['jumlah'];
                    $tabel[$sb]['jenis'][count($tabel[$sb]['jenis']) - 1]['data']['jumlah'] += $dana[$i]['jumlah'];
                }
            }
        }

        $dana_pen = Penelitian::whereBetween('tahun', [$ts - 2, $ts])->get();

        for ($m = 0; $m < count($dana_pen); $m++) {

            if ($dana_pen[$m]['jumlah_dana'] > 0) {

                $th = null;
                if ($dana_pen[$m]['tahun'] == $ts) {
                    $th = 'ts';
                } else if ($dana_pen[$m]['tahun'] == $ts - 1) {
                    $th = 'ts1';
                } else if ($dana_pen[$m]['tahun'] == $ts - 2) {
                    $th = 'ts2';
                }

                if ($th != null) {
                    $tabel[4]['jenis'][0]['data'][$th] += $dana_pen[$m]['jumlah_dana'];
                    $tabel[4]['jenis'][0]['data']['jumlah'] += $dana_pen[$m]['jumlah_dana'];

                    $tabel[4]['jenis'][2]['data'][$th] += $dana_pen[$m]['jumlah_dana'];
                    $tabel[4]['jenis'][2]['data']['jumlah'] += $dana_pen[$m]['jumlah_dana'];
                }
            }
        }

        $dana_pkm = Pengabdian::whereBetween('tahun', [$ts - 2, $ts])->get();

        for ($m = 0; $m < count($dana_pkm); $m++) {

            if ($dana_pkm[$m]['jumlah_dana'] > 0) {

                $th = null;
                if ($dana_pkm[$m]['tahun'] == $ts) {
                    $th = 'ts';
                } else if ($dana_pkm[$m]['tahun'] == $ts - 1) {
                    $th = 'ts1';
                } else if ($dana_pkm[$m]['tahun'] == $ts - 2) {
                    $th = 'ts2';
                }

                if ($th != null) {
                    $tabel[4]['jenis'][1]['data'][$th] += $dana_pkm[$m]['jumlah_dana'];
                    $tabel[4]['jenis'][1]['data']['jumlah'] += $dana_pkm[$m]['jumlah_dana'];

                    $tabel[4]['jenis'][2]['data'][$th] += $dana_pkm[$m]['jumlah_dana'];
                    $tabel[4]['jenis'][2]['data']['jumlah'] += $dana_pkm[$m]['jumlah_dana'];
                }
            }
        }

        $data['perolehan_dana'] = $tabel;


        //IPK Mahasiswa Lulusan
        $this->info("Memproses ipk mahasiswa lulusan");
        $pendidikan = ['Doktor/ Doktor Terapan/ Subspesialis', 'Magister/ Magister Terapan/ Spesialis', 'Profesi', 'Sarjana/ Diploma Empat/ Sarjana Terapan', 'Diploma Tiga', 'Diploma Dua', 'Diploma Satu', 'TOTAL'];

        $tabel = [];

        foreach ($pendidikan as $item) {
            $tabel[] = [
                'pendidikan' => $item,
                'lulusan_ts2' => 0,
                'lulusan_ts1' => 0,
                'lulusan_ts' => 0,
                'ipk_ts2' => 0,
                'ipk_ts1' => 0,
                'ipk_ts' => 0,
                'jumlah_prodi' => 0,
            ];
        }

        $lulusan = Mahasiswa::where('status_keluar', 'lulus')->whereBetween('tahun_keluar', [$ts - 2, $ts])->with('prodi')->get();

        for ($i = 0; $i < count($lulusan); $i++) {

            if (isset($lulusan[$i]['prodi']['jenjang']) && isset($lulusan[$i]['ipk']) && $lulusan[$i]['ipk'] != null) {

                $jenjang = $lulusan[$i]['prodi']['jenjang'];

                $pend = -1;
                if ($jenjang == 'D1') {
                    $pend = 6;
                } else if ($jenjang == 'D2') {
                    $pend = 5;
                } else if ($jenjang == 'D3') {
                    $pend = 4;
                } else if ($jenjang == 'D4' || $jenjang == 'S1') {
                    $pend = 3;
                } else if ($jenjang == 'PROF') {
                    $pend = 2;
                } else if ($jenjang == 'S2') {
                    $pend = 1;
                } else if ($jenjang == 'S3') {
                    $pend = 0;
                }

                $tahun_aktif = null;
                $masastudi = null;
                if ($lulusan[$i]['tahun_keluar'] == $ts) {
                    $tahun_aktif = 'lulusan_ts';
                    $masastudi = 'ipk_ts';
                } else if ($lulusan[$i]['tahun_keluar'] == $ts - 1) {
                    $tahun_aktif = 'lulusan_ts1';
                    $masastudi = 'ipk_ts1';
                } else if ($lulusan[$i]['tahun_keluar'] == $ts - 2) {
                    $tahun_aktif = 'lulusan_ts2';
                    $masastudi = 'ipk_ts2';
                }


                if ($pend != -1 && $tahun_aktif != null) {
                    $tabel[$pend][$tahun_aktif] += 1;
                    $tabel[7][$tahun_aktif] += 1;

                    $tabel[$pend][$masastudi] += $lulusan[$i]['ipk'];
                    $tabel[7][$masastudi] += $lulusan[$i]['ipk'];
                }
            }
        }

        for ($m = 0; $m < count($tabel) - 1; $m++) {

            if ($tabel[$m]['ipk_ts'] > 0 && $tabel[$m]['lulusan_ts'] > 0) {
                $tabel[$m]['ipk_ts'] = $tabel[$m]['ipk_ts'] / $tabel[$m]['lulusan_ts'];
            }

            if ($tabel[$m]['ipk_ts1'] > 0 && $tabel[$m]['lulusan_ts1'] > 0) {
                $tabel[$m]['ipk_ts1'] = $tabel[$m]['ipk_ts1'] / $tabel[$m]['lulusan_ts1'];
            }

            if ($tabel[$m]['ipk_ts2'] > 0 && $tabel[$m]['lulusan_ts2'] > 0) {
                $tabel[$m]['ipk_ts2'] = $tabel[$m]['ipk_ts2'] / $tabel[$m]['lulusan_ts2'];
            }
        }

        //Menambahkan Jumlah Prodi
        $tabel[0]['jumlah_prodi'] = Prodi::where('jenjang', 'S3')->count();
        $tabel[1]['jumlah_prodi'] = Prodi::where('jenjang', 'S2')->count();
        $tabel[2]['jumlah_prodi'] = Prodi::where('jenjang', 'PROF')->count();
        $tabel[3]['jumlah_prodi'] = Prodi::where('jenjang', ['S1', 'D4'])->count();
        $tabel[4]['jumlah_prodi'] = Prodi::where('jenjang', 'D3')->count();
        $tabel[5]['jumlah_prodi'] = Prodi::where('jenjang', 'D2')->count();
        $tabel[6]['jumlah_prodi'] = Prodi::where('jenjang', 'D1')->count();
        $tabel[7]['jumlah_prodi'] = Prodi::count();

        $data['ipk_mahasiswa'] = $tabel;


        //Rasio Dosen dan Mahasiswa
        $this->info("Memproses rasio dosen mahasiswa");

        $fakultas = Faculty::all();

        $tabel = $fakultas->map(function ($i) {
            $p = Prodi::where('fakultas', $i->code)->get();
            $nims = $p->pluck('kode')->all();

            $m = StatusMahasiswa::where('status', 'aktif')->where('tahun', 2022)->where('semester', 2)->whereHas('mahasiswa', function ($query) use ($nims) {
                $query->whereIn('kode_prodi', $nims);
            })->get();

            $d = DosenHomebase::whereIn('homebase', $nims)->get();

            $a = [
                "kode" => $i->code,
                "fakultas" => $i->name,
                "singkatan" => $i->singkatan,
                "jumlah_dosen" => $d->count(),
                "jumlah_mahasiswa" => $m->count(),
            ];
            return $a;
        });


        $tabel->push([
            'fakultas' => 'TOTAL',
            'singkatan' => 'total',
            'kode' => '',
            'jumlah_dosen' => $tabel->sum('jumlah_dosen'),
            'jumlah_mahasiswa' => $tabel->sum('jumlah_mahasiswa'),
        ]);

        $data['rasio_dosen_mahasiswa'] = $tabel;


        //Lulusan Tepat Waktu Mahasiswa
        $this->info("Memproses lulus tepat waktu");
        $sumber = ['TS-6', 'TS-5', 'TS-4', 'TS-3', 'TS-2', 'TS-1', 'TS'];
        $tabel = [];

        $lulusan = Mahasiswa::where('status_keluar', 'lulus')->whereBetween('tahun_masuk', [$ts - 6, $ts])->orderBy('tanggal_yudisium', 'DESC')->whereNotNull('tanggal_yudisium')->get();

        $lulusan = $lulusan->filter(function ($i) {
            if ($i['tanggal_yudisium'] === null || $i['tanggal_yudisium'] === 0) {
                return false; // Skip this entry
            } else {
                return true;
            }
        });

        foreach ($sumber as $key => $item) {
            $tabel[] = [
                'nama' => $item,
                'ts' => $lulusan->where('tahun_masuk', $ts - 6 + $key)->filter(function ($i) use ($ts) {

                    $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                    $tanggalMulaiAjaran = Carbon::create($ts, 9, 1);
                    $tanggalAkhirAjaran = Carbon::create($ts + 1, 8, 31);

                    return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                })->count(),
                'ts1' => $lulusan->where('tahun_masuk', $ts - 6 + $key)->filter(function ($i) use ($ts) {

                    $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                    $tanggalMulaiAjaran = Carbon::create($ts - 1, 9, 1);
                    $tanggalAkhirAjaran = Carbon::create($ts - 1 + 1, 8, 31);

                    return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                })->count(),
                'ts2' => $lulusan->where('tahun_masuk', $ts - 6 + $key)->filter(function ($i) use ($ts) {
                    $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                    $tanggalMulaiAjaran = Carbon::create($ts - 2, 9, 1);
                    $tanggalAkhirAjaran = Carbon::create($ts - 2 + 1, 8, 31);

                    return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                })->count(),
                'ts3' => $lulusan->where('tahun_masuk', $ts - 6 + $key)->filter(function ($i) use ($ts) {
                    $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                    $tanggalMulaiAjaran = Carbon::create($ts - 3, 9, 1);
                    $tanggalAkhirAjaran = Carbon::create($ts - 3 + 1, 8, 31);

                    return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                })->count(),
                'ts4' => $lulusan->where('tahun_masuk', $ts - 6 + $key)->filter(function ($i) use ($ts) {
                    $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                    $tanggalMulaiAjaran = Carbon::create($ts - 4, 9, 1);
                    $tanggalAkhirAjaran = Carbon::create($ts - 4 + 1, 8, 31);

                    return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                })->count(),
                'ts5' => $lulusan->where('tahun_masuk', $ts - 6 + $key)->filter(function ($i) use ($ts) {
                    $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                    $tanggalMulaiAjaran = Carbon::create($ts - 5, 9, 1);
                    $tanggalAkhirAjaran = Carbon::create($ts - 5 + 1, 8, 31);

                    return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                })->count(),
                'ts6' => $lulusan->where('tahun_masuk', $ts - 6 + $key)->filter(function ($i) use ($ts) {
                    $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                    $tanggalMulaiAjaran = Carbon::create($ts - 6, 9, 1);
                    $tanggalAkhirAjaran = Carbon::create($ts - 6 + 1, 8, 31);

                    return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                })->count(),
                'jumlah' => $lulusan->where('tahun_masuk', $ts - 6 + $key)->count(),
            ];
        }

        $data['lulusan_tepat_waktu'] = $tabel;

        //kirim data ke database
        $this->info("Mengirim data JSON ke database ... ");
        $check_data = AkreditasiRekapUniversitas::first();
        if ($check_data) {

            $check_data->update([
                'instrumen_akreditasi_universitas' => json_encode($data),
                'updated_at' => now(),
            ]);
            $this->info('Data updated.');
        } else {
            AkreditasiRekapUniversitas::create([
                'instrumen_akreditasi_universitas' => json_encode($data)
            ]);
            $this->info('Data inserted successfully.');
        }
    }
}
