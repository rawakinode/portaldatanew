<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\SeleksiMahasiswaBaru;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class SettingLulusTepatWaktu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:lulus-tepat-waktu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $setting_prodi = collect([
            [
                "prodi" => 44201,
                "tahun_lulus" => [
                    [
                        "tahun" => 2022,
                        "angkatan" => [
                            [
                                "masuk" => 2019,
                                "lulus" => 26,
                            ],
                            [
                                "masuk" => 2018,
                                "lulus" => 24,
                            ],
                            [
                                "masuk" => 2017,
                                "lulus" => 6,
                            ],
                            [
                                "masuk" => 2016,
                                "lulus" => 0,
                            ]
                        ]
                    ],
                    [
                        "tahun" => 2021,
                        "angkatan" => [
                            [
                                "masuk" => 2018,
                                "lulus" => 31,
                            ],
                            [
                                "masuk" => 2017,
                                "lulus" => 18,
                            ],
                            [
                                "masuk" => 2016,
                                "lulus" => 5,
                            ],
                            [
                                "masuk" => 2015,
                                "lulus" => 0,
                            ]
                        ]
                    ],
                    [
                        "tahun" => 2020,
                        "angkatan" => [
                            [
                                "masuk" => 2017,
                                "lulus" => 27,
                            ],
                            [
                                "masuk" => 2016,
                                "lulus" => 17,
                            ],
                            [
                                "masuk" => 2015,
                                "lulus" => 7,
                            ],
                            [
                                "masuk" => 2014,
                                "lulus" => 0,
                            ]
                        ]
                    ],
                    [
                        "tahun" => 2019,
                        "angkatan" => [
                            [
                                "masuk" => 2016,
                                "lulus" => 25,
                            ],
                            [
                                "masuk" => 2015,
                                "lulus" => 19,
                            ],
                            [
                                "masuk" => 2014,
                                "lulus" => 15,
                            ],
                            [
                                "masuk" => 2013,
                                "lulus" => 0,
                            ]
                        ]
                    ],
                    [
                        "tahun" => 2018,
                        "angkatan" => [
                            [
                                "masuk" => 2015,
                                "lulus" => 24,
                            ],
                            [
                                "masuk" => 2014,
                                "lulus" => 19,
                            ],
                            [
                                "masuk" => 2013,
                                "lulus" => 13,
                            ],
                            [
                                "masuk" => 2012,
                                "lulus" => 0,
                            ]
                        ]
                    ]
                ]
            ],
            [
                "prodi" => 45201,
                "tahun_lulus" => [
                    [
                        "tahun" => 2021,
                        "angkatan" => [
                            [
                                "masuk" => 2018,
                                "lulus" => 28,
                            ],
                            [
                                "masuk" => 2017,
                                "lulus" => 17,
                            ],
                            [
                                "masuk" => 2016,
                                "lulus" => 6,
                            ],
                            [
                                "masuk" => 2015,
                                "lulus" => 2,
                            ]
                        ]
                    ],
                    [
                        "tahun" => 2020,
                        "angkatan" => [
                            [
                                "masuk" => 2017,
                                "lulus" => 22,
                            ],
                            [
                                "masuk" => 2016,
                                "lulus" => 21,
                            ],
                            [
                                "masuk" => 2015,
                                "lulus" => 2,
                            ],
                            [
                                "masuk" => 2014,
                                "lulus" => 5,
                            ]
                        ]
                    ],
                    [
                        "tahun" => 2019,
                        "angkatan" => [
                            [
                                "masuk" => 2016,
                                "lulus" => 23,
                            ],
                            [
                                "masuk" => 2015,
                                "lulus" => 20,
                            ],
                            [
                                "masuk" => 2014,
                                "lulus" => 0,
                            ],
                            [
                                "masuk" => 2013,
                                "lulus" => 0,
                            ]
                        ]
                    ],
                    [
                        "tahun" => 2018,
                        "angkatan" => [
                            [
                                "masuk" => 2015,
                                "lulus" => 22,
                            ],
                            [
                                "masuk" => 2014,
                                "lulus" => 6,
                            ],
                            [
                                "masuk" => 2013,
                                "lulus" => 3,
                            ],
                            [
                                "masuk" => 2012,
                                "lulus" => 0,
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        foreach ($setting_prodi as $prodi) {

            //$mahasiswa = Mahasiswa::where('kode_prodi', $prodi['prodi'])->get();

            $prodi_tahun = collect($prodi['tahun_lulus'])->sortBy('tahun')->values();

            foreach ($prodi_tahun as $th) {

                foreach ($th['angkatan'] as $akt) {

                    // cek mahasiswa lulus sebelum di setting
                    $lulus = Mahasiswa::where('kode_prodi', $prodi['prodi'])->where('tahun_masuk', $akt['masuk'])->get()->filter(function ($i) use ($th) {

                        $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                        $tanggalMulaiAjaran = Carbon::create($th['tahun'], 9, 1);
                        $tanggalAkhirAjaran = Carbon::create($th['tahun'] + 1, 8, 31);

                        return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                    })->values();

                    // Setting
                    if ($lulus->count() != $akt['lulus']) {

                        if ($akt['lulus'] > $lulus->count()) {
                            $selisih = $akt['lulus'] - $lulus->count();
                            $this->info("selisih : " . $selisih);
                            $cari_lulus_lain = Mahasiswa::where('kode_prodi', $prodi['prodi'])->where('tahun_masuk', $akt['masuk'])->get()->filter(function ($i) use ($th) {

                                if ($i['tanggal_yudisium'] == null) {
                                    return false;
                                }
                                $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                                $tanggalMulaiAjaran = Carbon::create($th['tahun'] + 1, 9, 1);
                                $tanggalAkhirAjaran = Carbon::create($th['tahun'] + 1 + 6, 8, 31);

                                return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                            })->sortBy('tanggal_yudisium')->values();

                            $pick = $cari_lulus_lain->take($selisih);

                            $cari_tidak_ada_yudisium = collect();
                            if ($pick->count() < $selisih) {
                                $sel2 = $selisih - $pick->count();
                                $cari_tidak_ada_yudisium = Mahasiswa::where('kode_prodi', $prodi['prodi'])->where('tahun_masuk', $akt['masuk'])->where('tanggal_yudisium', null)->where('status_keluar', 'lulus')->get()->shuffle()->take($sel2)->values();
                            }

                            $total_pick = $pick->merge($cari_tidak_ada_yudisium);

                            $cari_belum_lulus = collect();
                            if ($total_pick->count() < $selisih) {
                                $sel3 = $selisih - $total_pick->count();
                                $cari_belum_lulus = Mahasiswa::where('kode_prodi', $prodi['prodi'])->where('tahun_masuk', $akt['masuk'])->where('tanggal_yudisium', null)->where('status_keluar', null)->get()->shuffle()->take($sel3)->values();
                            }

                            $total_pick = $total_pick->merge($cari_belum_lulus);

                            $cari_yang_hilang = collect();
                            if ($total_pick->count() < $selisih) {
                                $sel3 = $selisih - $total_pick->count();
                                $cari_yang_hilang = Mahasiswa::where('kode_prodi', $prodi['prodi'])->where('tahun_masuk', $akt['masuk'])->where('tanggal_yudisium', null)->whereIn('status_keluar', ['hilang', 'lainnya', 'mengundurkan diri', null])->get()->shuffle()->take($sel3)->values();
                            }

                            $total_pick = $total_pick->merge($cari_yang_hilang);

                            foreach ($total_pick as $tp) {
                                $tp->update([
                                    "tanggal_yudisium" => Carbon::create($th['tahun'], rand(9, 12), rand(1, 30)),
                                    "status_keluar" => "lulus",
                                    "tahun_keluar" => $th['tahun']
                                ]);
                            }

                            // $mahasiswa->each(function (&$item) use ($total_pick, $th) {
                            //     $sel = $total_pick->where('nim', $item->nim)->first();
                            //     if ($sel) {
                            //         $item->tanggal_yudisium = Carbon::create($th['tahun'], rand(9, 12), rand(1, 30));
                            //     }
                            //     return $item;
                            // });

                        } else {

                            $selisih = $lulus->count() - $akt['lulus'];
                            $total_pick = $lulus->shuffle()->take($selisih);

                            if ($akt['lulus'] != 0) {

                                foreach ($total_pick as $tp) {
                                    $tp->update([
                                        "tanggal_yudisium" => Carbon::create($th['tahun'] + 1, rand(9, 12), rand(1, 30)),
                                        "status_keluar" => "lulus",
                                        "tahun_keluar" => $th['tahun']
                                    ]);
                                }

                                // $mahasiswa->each(function (&$item) use ($total_pick, $th) {
                                //     $sel = $total_pick->where('nim', $item->nim)->first();
                                //     if ($sel) {
                                //         $item->tanggal_yudisium = Carbon::create($th['tahun'] + 1, rand(9, 12), rand(1, 30));
                                //     }
                                //     return $item;
                                // });

                            } else {

                                foreach ($total_pick as $tp) {
                                    $tp->update([
                                        "tanggal_yudisium" => null,
                                        "status_keluar" => "hilang",
                                        "tahun_keluar" => null
                                    ]);
                                }

                                // $mahasiswa->each(function (&$item) use ($total_pick, $th) {
                                //     $sel = $total_pick->where('nim', $item->nim)->first();
                                //     if ($sel) {
                                //         $item->tanggal_yudisium = null;
                                //         $item->status_keluar = 'hilang';
                                //     }
                                //     return $item;
                                // });
                            }
                        }
                    }

                    // cek ulang mahasiswa lulus setelah di setting
                    $lulus_after = Mahasiswa::where('kode_prodi', $prodi['prodi'])->where('tahun_masuk', $akt['masuk'])->get()->filter(function ($i) use ($th) {

                        $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                        $tanggalMulaiAjaran = Carbon::create($th['tahun'], 9, 1);
                        $tanggalAkhirAjaran = Carbon::create($th['tahun'] + 1, 8, 31);

                        return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                    })->count();

                    $this->info("Prodi : " . $prodi['prodi'] . " Tahun Lulus : " . $th['tahun'] . " Angkatan : " . $akt['masuk'] . " Setting Lulus : " . $akt['lulus'] . " Lulus Asli : " . $lulus->count() . " Lulus After : " . $lulus_after);
                }
            }
        }

        return 0;
    }
}
