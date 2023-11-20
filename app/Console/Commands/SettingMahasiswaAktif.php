<?php

namespace App\Console\Commands;

use App\Models\Faculty;
use App\Models\Mahasiswa;
use App\Models\PortalMahasiswaAktif;
use App\Models\Prodi;
use App\Models\StatusMahasiswa;
use Illuminate\Console\Command;

class SettingMahasiswaAktif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:mahasiswa-aktif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting Mahasiswa Aktif Perkuliahan Universitas';

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
        //SETTING JUMLAH MAHASISWA AKTIF

        $this->info("Memulai ...");
        $this->info("Setting Jumlah Mahasiswa Aktif ...");
        $fakultas = Faculty::with('prodi')->get();

        $setting = collect([
            [
                "tahun" => 2021,
                "semester" => 2,
                "setting" => [7668, 3659, 4607, 2863, 2751, 4258, 2143, 1143, 762, 1615, 865, 1064, 379, 188]
            ],
            [
                "tahun" => 2021,
                "semester" => 1,
                "setting" => [7659, 3663, 4607, 2858, 2743, 4264, 2166, 1189, 777, 1618, 869, 1071, 382, 184]
            ],
            [
                "tahun" => 2020,
                "semester" => 2,
                "setting" => [7768, 3707, 4667, 2900, 2787, 4313, 2171, 1158, 772, 1636, 876, 1077, 383, 196]
            ],
            [
                "tahun" => 2020,
                "semester" => 1,
                "setting" => [7796, 3720, 4683, 2910, 2796, 4329, 2178, 1162, 774, 1641, 879, 1081, 385, 198]
            ],
            [
                "tahun" => 2019,
                "semester" => 2,
                "setting" => [7891, 3765, 4741, 2946, 2831, 4381, 2205, 1176, 784, 1662, 890, 1094, 390, 198]
            ],
            [
                "tahun" => 2019,
                "semester" => 1,
                "setting" => [7930, 3784, 4764, 2961, 2845, 4403, 2216, 1182, 788, 1670, 894, 1100, 391, 201]
            ],
            [
                "tahun" => 2018,
                "semester" => 2,
                "setting" => [7987, 3811, 4799, 2982, 2865, 4435, 2232, 1190, 793, 1682, 901, 1108, 394, 202]
            ],
            [
                "tahun" => 2018,
                "semester" => 1,
                "setting" => [8098, 3864, 4865, 3023, 2905, 4497, 2263, 1207, 804, 1705, 913, 1123, 400, 207]
            ],
            [
                "tahun" => 2017,
                "semester" => 2,
                "setting" => [7659, 3655, 4602, 2859, 2748, 4253, 2140, 1141, 761, 1613, 864, 1062, 378, 194]
            ],
            [
                "tahun" => 2017,
                "semester" => 1,
                "setting" => [7702, 3675, 4627, 2875, 2763, 4277, 2152, 1148, 765, 1622, 868, 1068, 380, 197]
            ]

        ]);

        foreach ($setting as $ms) {

            $periode = $ms['tahun'];
            $semester = $ms['semester'];

            //Mendapatkan data mahasiswa aktif per semester periode dan tahun
            $this->info("Mendapatkan data status mahasiswa per periode semester : " . $periode . $semester);
            $status = StatusMahasiswa::where('tahun', $periode)
                ->where('semester', $semester)
                ->with('mahasiswa')
                ->whereIn('status', ['aktif', 'nonaktif'])
                ->get();

            //Hitung jumlah mahasiswa aktif per fakultas
            $this->info("Hitung jumlah mahasiswa aktif per fakultas");
            $fakultas = $fakultas->map(function ($item, $index) use ($status, $ms) {
                $prodi = $item->prodi->pluck('kode')->toArray();
                $item->array_prodi = $prodi;
                $m_aktif = $status->where('status', 'aktif')->whereIn('kode_prodi', $prodi);
                $m_nonaktif = $status->where('status', 'nonaktif')->whereIn('kode_prodi', $prodi);
                $item->aktif = $m_aktif->count();
                $item->nonaktif =  $m_nonaktif->count();
                $item->setting = $ms['setting'][$index];
                $item->selisih = $m_aktif->count() - $ms['setting'][$index];

                return $item;
            });

            //Menambah atau mengurangi selisih mahasiswa aktif fakultas
            $this->info("Menambah atau mengurangi selisih mahasiswa aktif");
            foreach (collect($fakultas) as $fak) {
                $this->info("Setting Fakultas : " . $fak->name);
                $hit = 0;
                if ($fak['selisih'] < 0) {
                    $this->info("Menambahkan ...");
                    $p = $fak->prodi->pluck('kode')->toArray();
                    $m = $status->whereIn('kode_prodi', $p)->where('status', 'nonaktif')->sortByDesc(function ($i) {
                        return $i->mahasiswa->tahun_masuk;
                    })->values()->take(abs($fak['selisih']));

                    // $con += $m->count();
                    $m->each(function ($f) use (&$hit) {
                        $f->update([
                            "status" => "aktif",
                            "ipk" => (mt_rand(250, 350) / 100),
                        ]);
                        $hit++;
                    });

                    if ($hit < abs($fak['selisih'])) {
                        $mahasiswa_id = $status->whereIn('kode_prodi', $p)->pluck('mahasiswa_id')->toArray();
                        $mahasiswa_dummy = Mahasiswa::whereIn('kode_prodi', $p)
                            ->whereNotIn('id', $mahasiswa_id)
                            ->whereIn('tahun_masuk', [$periode, $periode - 1, $periode - 2, $periode - 3, $periode - 4, $periode - 5])
                            ->orderBy('tahun_masuk', 'DESC')
                            ->get();
                        $mahasiswa_dummy_selected = $mahasiswa_dummy->take($hit - abs($fak['selisih']));
                        $mahasiswa_dummy_selected->each(function ($i) use ($periode, $semester) {
                            StatusMahasiswa::create([
                                'kode_prodi' => $i->kode_prodi,
                                'mahasiswa_id' => $i->id,
                                'tahun' => $periode,
                                'semester' => $semester,
                                'ipk' => (mt_rand(250, 350) / 100),
                                'sks' => 0,
                                'status' => 'aktif',
                            ]);
                        });
                    }
                } else if ($fak['selisih'] > 0) {
                    $this->info("Mengurangi ...");

                    $p = $fak->prodi->pluck('kode')->toArray();
                    $m = $status->whereIn('kode_prodi', $p)
                        ->where('status', 'aktif')
                        ->sortBy(function ($i) {
                            return $i->mahasiswa->tahun_masuk;
                        })
                        ->values()
                        ->take(abs($fak['selisih']));

                    $m->each(function ($f) {
                        $f->delete();
                    });
                }
            }

            $this->info("Selesai ...");
        }
        $this->info("Selesai setting mahasiswa aktif ");

        //SETTING IPK MAHASISWA AKTIF
        $tahun = collect([2022, 2021, 2020, 2018, 2017]);
        $periode = collect([1, 2]);

        foreach ($tahun as $th) {

            foreach ($periode as $pdo) {

                $all_status = StatusMahasiswa::where('tahun', $th)
                ->where('semester', $pdo)
                ->where('status', 'aktif')
                ->get();

                $total = $all_status->count();
                $set_ipk5 = floor($total * 25 / 100);
                $set_ipk4 = floor($total * 35 / 100);
                $set_ipk3 = floor($total * 24 / 100);
                $set_ipk2 = floor($total * 13 / 100);
                $set_ipk1 = floor($total - $set_ipk2 - $set_ipk3- $set_ipk3 - $set_ipk5);

                $setting = [
                    [
                        "tipe" => 1,
                        "ipk" => 5,
                        "rand_min" => 3510,
                        "rand_max" => 4000,
                        "jumlah_set" => $set_ipk5
                    ],
                    [
                        "tipe" => 1,
                        "ipk" => 4,
                        "rand_min" => 3010,
                        "rand_max" => 3500,
                        "jumlah_set" => $set_ipk4
                    ],
                    [
                        "tipe" => 1,
                        "ipk" => 3,
                        "rand_min" => 2510,
                        "rand_max" => 3000,
                        "jumlah_set" => $set_ipk3
                    ],
                    [
                        "tipe" => 1,
                        "ipk" => 2,
                        "rand_min" => 2010,
                        "rand_max" => 2500,
                        "jumlah_set" => $set_ipk2
                    ],
                    [
                        "tipe" => 2,
                        "ipk" => 1,
                        "rand_min" => 0,
                        "rand_max" => 2000,
                        "jumlah_set" => $set_ipk1
                    ],
                ];

                for ($i=0; $i < count($setting); $i++) { 

                    if ($setting[$i]['tipe'] == 1) {
                        $cek_current = StatusMahasiswa::where('tahun', $th)
                        ->where('semester', $pdo)
                        ->where('status', 'aktif')
                        ->where('ipk', '>', round($setting[$i]['rand_min'] / 1000, 2))
                        ->where('ipk', '<=', round($setting[$i]['rand_max'] / 1000, 2))
                        ->get();

                        $cek_before = StatusMahasiswa::where('tahun', $th)
                        ->where('semester', $pdo)
                        ->where('status', 'aktif')
                        ->where('ipk', '>', round($setting[$i+1]['rand_min'] / 1000, 2))
                        ->where('ipk', '<=', round($setting[$i+1]['rand_max'] / 1000, 2))
                        ->get();

                        $this->info("Setting IPK Kategori" . $setting[$i]['ipk']);
                        if ($cek_current->count() > $setting[$i]['jumlah_set']) {
                            $t = $cek_current->sortBy('ipk');
                            $pick = $t->take($cek_current->count() - $setting[$i]['jumlah_set']);
                            $this->info($pick->count());
                            $randomFloat = round((rand($setting[$i+1]['rand_min'], $setting[$i+1]['rand_max']) / 1000), 2);
                            foreach ($pick as $tofu) {
                                $tofu->update([
                                    'ipk' => $randomFloat
                                ]);
                            }
                        } else if ($cek_current->count() < $setting[$i]['jumlah_set']) {
                            $t = $cek_before->sortBy('ipk');
                            $pick = $t->take($setting[$i]['jumlah_set'] - $cek_current->count());
                            $this->info($pick->count());
                            $randomFloat = round((rand($setting[$i]['rand_min'], $setting[$i]['rand_max']) / 1000), 2);
                            foreach ($pick as $tofu) {
                                $tofu->update([
                                    'ipk' => $randomFloat
                                ]);
                            }
                        }
                    }else{
                        
                    }
                    
                }
            }
        }

        $this->info("Selesai.");
        return 0;


    }
}
