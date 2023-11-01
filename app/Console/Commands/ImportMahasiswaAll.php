<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportMahasiswaAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:mahasiswa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Semua Mahasiswa yang datanya ada di json public';

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
        $filePath = public_path('json/mahasiswa_untad_all.json');

        // Membaca isi file JSON ke dalam string
        $jsonString = File::get($filePath);

        // Mengubah JSON menjadi koleksi (collection)
        $mahasiswaCollection = collect(json_decode($jsonString));

        $mahasiswaCollection = $mahasiswaCollection->filter(function($i){
            return intval($i->tahun_masuk) > 2014;
        })->values();

        $con = 0;
        $count_success = 0;
        $count_error = 0;

        foreach ($mahasiswaCollection as $value) {

            $con++;
            $this->info($con .' / '. count($mahasiswaCollection));

            try {

                $kodeprodi = Prodi::where('kode', $value->kode)->first();

                if ($kodeprodi) {

                    $mahasiswa = Mahasiswa::where('nim', $value->nim)->first();

                    $validasi = [];
                    $validasi['kode_prodi'] = $value->kode;
                    $validasi['nim'] = $value->nim;
                    $validasi['nama'] = strtoupper($value->nama);
                    $validasi['daftar_ulang'] = 1;
                    $validasi['bidikmisi'] = 0;
                    $validasi['kelamin'] = $value->kelamin;
                    $validasi['tahun_masuk'] = intval($value->tahun_masuk);

                    if (!$mahasiswa) {
                        DB::transaction(function () use ($value) {
                            Mahasiswa::create([
                                'kode_prodi' => $value->kode,
                                'nama' => $value->nama,
                                'nim' =>$value->nim,
                                'kelamin' => $value->kelamin,
                                'bidikmisi' => 0,
                                'daftar_ulang' => 1,
                                'jalur_masuk' => 'lainnya',
                                'tahun_masuk' => intval($value->tahun_masuk),
                                'tahun_keluar' => null,
                                'status_keluar' => null,
                                'asing' => 0,
                                'asing_part_time' => 0,
                                'ipk' => null,
                                'masastudi' => null,
                                'tanggal_yudisium' => null,
                            ]);
                        });
                        $count_success++;
                    }
                }
            } catch (\Throwable $th) {
                $this->info($value->nim. ' Error !');
                $count_error++;
                break;
            }
        }

        $this->info('Sukses: '. $count_success);
        $this->info('Gagal: '. $count_error);
    }
}
