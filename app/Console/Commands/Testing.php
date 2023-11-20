<?php

namespace App\Console\Commands;

use App\Models\StatusMahasiswa;
use Illuminate\Console\Command;

class Testing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testing';

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

        // $randomInteger = rand(700, 900);
        // $diubah = $kuliah->random($randomInteger);

        // foreach ($diubah as $m) {

        //     $randomFloat = 0.50 + (mt_rand(1, 99) / 100);
        //     try {
        //         $m->update([
        //             'ipk' => $randomFloat
        //         ]);
        //         $this->info("Berhasil");
        //     } catch (\Throwable $th) {
        //         $this->info("Gagal");
        //     }

        // }

        // $this->info($kuliah->count());
        // $this->info("Selesai");

        //return 0;
    }
}
