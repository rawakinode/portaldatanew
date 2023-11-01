<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Models\StatusMahasiswa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportPerkuliahan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:perkuliahan';

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
         $path = public_path('json/perkuliahan/perkuliahan_feeder_20222.json');

         // Membaca isi file JSON ke dalam string
         $jsonString = File::get($path);
 
         // Mengubah JSON menjadi koleksi (collection)
         $collection = collect(json_decode($jsonString));

         $collection = $collection[0];

         $counter = 0;
         $sukses = 0;
         $gagal = 0;

        //  $mahasiswa = Mahasiswa::where('daftar_ulang', 1)->get();
        //  $mahasiswa_compress = $mahasiswa->map(function($i){
        //     return collect([
        //         'id' => $i->id,
        //         'nim' => $i->nim,
        //         'kode_prodi' => $i->kode_prodi,
        //     ]);
        //  });

         foreach ($collection as $value) {
            $counter++;
            $this->line($counter . ' / ' .count($collection));

            try {
                $cek_mhs = Mahasiswa::where('nim', $value->nipd)->first();

                if ($cek_mhs) {

                    $status = 'nonaktif';
                    if ($value->nm_stat_mhs == 'Aktif') {
                        $status = 'aktif';
                    }else if ($value->nm_stat_mhs == 'Cuti'){
                        $status = 'cuti';
                    }

                    StatusMahasiswa::create([
                        'kode_prodi' => $cek_mhs->kode_prodi,
                        'mahasiswa_id' => $cek_mhs->id,
                        'tahun' => substr($value->id_smt,0,4),
                        'semester' => substr($value->id_smt, -1),
                        'ipk' => round($value->ipk, 2),
                        'sks' => $value->sks_total,
                        'status' => $status
                    ]);
                }

                $sukses++;

            } catch (\Throwable $th) {
                $gagal++;
            }
         }

         $this->info('Sukses : ' . $sukses . '. Gagal : ' . $gagal);
    }
}
