<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\SeleksiMahasiswaBaru;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingSeleksiMahasiswaBaru extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:seleksi-mahasiswa-baru';

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
        //Setting tambahan untuk prodi (Opsional)

        $prodi_setting = collect(
            [
                [
                    "kode" => 45201, // Fisika Mipa
                    "masuk" => [
                        [
                            "tahun" => 2021,
                            "data" => [40, 398, 36, 33, 168, 5]
                        ],
                        [
                            "tahun" => 2020,
                            "data" => [40, 360, 34, 31, 177, 20]
                        ],
                        [
                            "tahun" => 2019,
                            "data" => [55, 326, 51, 51, 191, 10]
                        ],
                        [
                            "tahun" => 2018,
                            "data" => [55, 295, 55, 54, 181, 10]
                        ],
                        [
                            "tahun" => 2017,
                            "data" => [50, 256, 41, 39, 158, 12]
                        ],
                    ]
                ],
                [
                    "kode" => 44201, // Matematika Mipa
                    "masuk" => [
                        [
                            "tahun" => 2022,
                            "data" => [60, 375, 60, 59, 280, 14]
                        ],
                        [
                            "tahun" => 2021,
                            "data" => [50, 337, 50, 48, 275, 11]
                        ],
                        [
                            "tahun" => 2020,
                            "data" => [50, 362, 62, 57, 278, 10]
                        ],
                        [
                            "tahun" => 2019,
                            "data" => [50, 336, 57, 50, 280, 7]
                        ],
                        [
                            "tahun" => 2018,
                            "data" => [70, 405, 73, 66, 286, 8]
                        ]

                    ]
                ]
            ]
        );

        $seleksi_mahasiswa = collect([
            [
                "jenjang" => "S1",
                "masuk" => [
                    ["tahun" => 2015, "data" => [8000, 36545, 8120, 7627, 30221, 0]],
                    ["tahun" => 2016, "data" => [9600, 48723, 9543, 9256, 31029, 0]],
                    ["tahun" => 2017, "data" => [10600, 52070, 10528, 10029, 32741, 0]],
                    ["tahun" => 2018, "data" => [11600, 57298, 11556, 11037, 34180, 0]],
                    ["tahun" => 2019, "data" => [9000, 47854, 8985, 8423, 33532, 0]],
                    ["tahun" => 2020, "data" => [9000, 46965, 8906, 8434, 32540, 0]],
                    ["tahun" => 2021, "data" => [9300, 46901, 9214, 8690, 32176, 0]],
                ]
            ],
            [
                "jenjang" => "S3",
                "masuk" => [
                    ["tahun" => 2015, "data" => [30, 55, 27, 26, 88, 0]],
                    ["tahun" => 2016, "data" => [80, 163, 78, 75, 121, 0]],
                    ["tahun" => 2017, "data" => [55, 106, 53, 53, 149, 0]],
                    ["tahun" => 2018, "data" => [80, 156, 64, 58, 203, 0]],
                    ["tahun" => 2019, "data" => [55, 104, 48, 44, 184, 0]],
                    ["tahun" => 2020, "data" => [65, 122, 53, 51, 195, 0]],
                    ["tahun" => 2021, "data" => [90, 172, 81, 78, 158, 0]],
                ]
            ],
            [
                "jenjang" => "S2",
                "masuk" => [
                    ["tahun" => 2017, "data" => [425, 851, 425, 423, 709, 0]],
                    ["tahun" => 2018, "data" => [480, 827, 480, 479, 521, 0]],
                    ["tahun" => 2019, "data" => [550, 1243, 550, 533, 522, 0]],
                    ["tahun" => 2020, "data" => [500, 1005, 499, 443, 663, 0]],
                    ["tahun" => 2021, "data" => [550, 1109, 503, 484, 907, 0]],
                ]
            ],
            [
                "jenjang" => "D3",
                "masuk" => [
                    ["tahun" => 2017, "data" => [115, 345, 115, 114, 238, 0]],
                    ["tahun" => 2018, "data" => [110, 381, 110, 106, 241, 0]],
                    ["tahun" => 2019, "data" => [205, 642, 211, 204, 345, 0]],
                    ["tahun" => 2020, "data" => [200, 681, 200, 187, 420, 0]],
                    ["tahun" => 2021, "data" => [300, 1055, 289, 279, 564, 0]],
                ]
            ],
            [
                "jenjang" => "PROF",
                "masuk" => [
                    ["tahun" => 2017, "data" => [175, 916, 184, 174, 92, 0]],
                    ["tahun" => 2018, "data" => [250, 1343, 250, 238, 236, 0]],
                    ["tahun" => 2019, "data" => [500, 2634, 500, 499, 371, 0]],
                    ["tahun" => 2020, "data" => [400, 2709, 400, 370, 593, 0]],
                    ["tahun" => 2021, "data" => [1100, 5832, 1100, 1078, 160, 0]],
                ]
            ]
        ]);

        foreach ($seleksi_mahasiswa as $sm) {

            $prodi = Prodi::where('jenjang', $sm['jenjang'])->get();
            $prodi_pluck = $prodi->pluck('kode');

            // $setting_prodi_pluck = $prodi_setting->pluck('kode');
            // $pluck_hapus_prodi = collect($prodi_pluck)->forget(array_search($setting_prodi_pluck->toArray(), $prodi_pluck->toArray()))->toArray();
            // $prodi_pluck = array_merge($setting_prodi_pluck->toArray(), $pluck_hapus_prodi);
            // $prodi_pluck = collect($prodi_pluck);

            foreach ($sm['masuk'] as $key => $ms) {

                $tahun_periode = $ms['tahun'];
                $mahasiswa = Mahasiswa::where('tahun_masuk', $tahun_periode)->whereIn('kode_prodi', $prodi_pluck)->get();

                $daya_tampung = $ms["data"][0];
                $pendaftar = $ms["data"][1];
                $lulus_seleksi = $ms["data"][2];
                $maba_reguler = $ms["data"][3];
                $maaktif_reguler = $ms["data"][4];

                $count_1 = 0;
                $count_2 = 0;
                $count_3 = 0;
                $count_4 = 0;
                $count_5 = 0;
                
                foreach ($prodi_pluck as $index => $pp) {

                    $this->info("Menghitung Jenjang " . $sm['jenjang'] . " dan Prodi " . $pp . " dan Periode " . $tahun_periode);

                    if ($index + 1 == $prodi_pluck->count()) {
                        $alokasi_daya_tampung = $daya_tampung - $count_1;
                        $alokasi_pendaftar = $pendaftar  - $count_2;
                        $alokasi_lulus_seleksi = $lulus_seleksi - $count_3;
                        $alokasi_maba_reguler = $maba_reguler - $count_4;
                        $alokasi_maaktif_reguler = $maaktif_reguler - $count_5;
                    } else {
                        $jumlah_mhs_pd = $mahasiswa->where('kode_prodi', $pp)->count();
                        $persen = $jumlah_mhs_pd / $mahasiswa->count();

                        $alokasi_daya_tampung = floor($persen * $daya_tampung);
                        $alokasi_pendaftar = floor($persen * $pendaftar);
                        $alokasi_lulus_seleksi = floor($persen * $lulus_seleksi);
                        $alokasi_maba_reguler = floor($persen * $maba_reguler);
                        $alokasi_maaktif_reguler = floor($persen * $maaktif_reguler);
                    }

                    $cek_pd = $prodi_setting->where('kode', $pp)->first();
                    $cek_pd_tahun = collect($cek_pd['masuk'])->where('tahun', $tahun_periode)->first();

                    $maaktif_luar_provinsi = 0;

                    if ($cek_pd_tahun) {
                        $alokasi_daya_tampung = $cek_pd_tahun['data'][0];
                        $alokasi_pendaftar = $cek_pd_tahun['data'][1];
                        $alokasi_lulus_seleksi = $cek_pd_tahun['data'][2];
                        $alokasi_maba_reguler = $cek_pd_tahun['data'][3];
                        $alokasi_maaktif_reguler = $cek_pd_tahun['data'][4];
                        $maaktif_luar_provinsi = $cek_pd_tahun['data'][5];
                    }

                    $rules = [
                        'kode_prodi' => $pp,
                        'tahun' => $tahun_periode,
                        'daya_tampung' => $alokasi_daya_tampung,
                        'mahasiswa_mendaftar' => $alokasi_pendaftar,
                        'mahasiswa_lulus_seleksi' => $alokasi_lulus_seleksi,
                        'mahasiswa_baru_reguler' => $alokasi_maba_reguler,
                        'mahasiswa_baru_transfer' => 0,
                        'mahasiswa_aktif_reguler' => $alokasi_maaktif_reguler,
                        'mahasiswa_aktif_transfer' => 0,
                        'mahasiswa_aktif_luar_provinsi' => $maaktif_luar_provinsi,
                        'mahasiswa_aktif_luar_negeri' => 0,
                    ];

                    $random = Str::random(10) . '-' . Str::random(10) . '-' . Str::random(10) . '-' . Str::random(10);
                    $rules['ids'] = strtolower($random);

                    $cek_before = SeleksiMahasiswaBaru::where('kode_prodi', $pp)->where('tahun', $tahun_periode)->first();

                    if ($cek_before) {
                        DB::transaction(function () use ($cek_before, $rules, $maaktif_luar_provinsi) {
                            $cek_before->update([
                                'daya_tampung' => $rules['daya_tampung'],
                                'mahasiswa_mendaftar' => $rules['mahasiswa_mendaftar'],
                                'mahasiswa_lulus_seleksi' => $rules['mahasiswa_lulus_seleksi'],
                                'mahasiswa_baru_reguler' => $rules['mahasiswa_baru_reguler'],
                                'mahasiswa_baru_transfer' => 0,
                                'mahasiswa_aktif_reguler' => $rules['mahasiswa_aktif_reguler'],
                                'mahasiswa_aktif_transfer' => 0,
                                'mahasiswa_aktif_luar_provinsi' => $maaktif_luar_provinsi,
                                'mahasiswa_aktif_luar_negeri' => 0,
                            ]);
                        });
                    } else {
                        DB::transaction(function () use ($rules) {
                            SeleksiMahasiswaBaru::create($rules);
                        });
                    }

                    $count_1 += $alokasi_daya_tampung;
                    $count_2 += $alokasi_pendaftar;
                    $count_3 += $alokasi_lulus_seleksi;
                    $count_4 += $alokasi_maba_reguler;
                    $count_5 += $alokasi_maaktif_reguler;
                }
            }


            $this->info("Selesai");
        }

        return 0;
    }
}
