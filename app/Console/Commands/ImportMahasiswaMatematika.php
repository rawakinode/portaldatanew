<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportMahasiswaMatematika extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:mahasiswa-matematika';

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

        // Mengambil path file JSON
        $filePath = public_path('json/fix/mahasiswa_matematika.json');

        // Membaca isi file JSON ke dalam string
        $jsonString = File::get($filePath);

        // Mengubah JSON menjadi koleksi (collection)
        $mahasiswaCollection = collect(json_decode($jsonString));

        $counter = 0;

        foreach ($mahasiswaCollection as $m) {

            $counter++;

            $mhs = Mahasiswa::where('kode_prodi', $m->kode_prodi)->where('nim', $m->nim)->first();
            if ($mhs) {
                $mhs->update([
                    "ipk" => $m->ipk,
                    "tahun_keluar" => $m->tahun_keluar,
                    "status_keluar" => $m->status_keluar,
                    "tanggal_yudisium" => $m->tanggal_yudisium,
                ]);
            }

            $this->info($counter . " / " . count($mahasiswaCollection));
        }

        return 0;
    }
}
