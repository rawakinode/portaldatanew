<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class ImportMahasiswaKeluar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:mahasiswa-keluar';

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
        $path = public_path('json/mahasiswa_keluar/semua.json');
        $getfile = File::get($path);
        $collection = collect(json_decode($getfile));

        $counter = 0;
        $berhasil = 0;
        $gagal = 0;

        foreach ($collection as $m) {
            $counter++;
            $this->info($counter);
            
            try {
                $s = Mahasiswa::where('nim', $m->nim)->first();
                if ($s) {

                    $status = null;
                    if ($m->status == "Lulus") {
                        $status = "lulus";
                    } else if ($m->status == "Mengundurkan diri") {
                        $status = "mengundurkan diri";
                    } else if ($m->status == "Dikeluarkan") {
                        $status = "dropout";
                    } else if ($m->status == "Hilang") {
                        $status = "hilang";
                    } else if ($m->status == "Lainnya") {
                        $status = "lainnya";
                    } else if ($m->status == "Mutasi") {
                        $status = "lainnya";
                    } else if ($m->status == "Wafat") {
                        $status = "lainnya";
                    } else if ($m->status == "Putus Studi") {
                        $status = "lainnya";
                    }

                    try {
                        $date = Carbon::parse($m->yudisium);
                        $date = $date->format('Y-m-d');
                    } catch (\Throwable $th) {
                        $date = null;
                    }

                    $s->update([
                        "status_keluar" => $status,
                        "tanggal_yudisium" => $date,
                        "ipk" => round($m->ipk, 2),
                    ]);

                    $berhasil++;
                }
            } catch (\Throwable $th) {
                $gagal++;
            }
        }

        $this->info("Berhasil : " . $berhasil . " / Gagal : " . $gagal);

    }
}
