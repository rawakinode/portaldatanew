<?php

namespace App\Console\Commands;

use App\Models\DosenHomebase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportDosenAllKepegawaian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dosen-kepegawaian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data semua dosen untad dari data kepegawaian untad .';

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
        $filePath = public_path('json/jsonformatter.json');
        $jsonString = File::get($filePath);
        $dosen_kepeg = collect(json_decode($jsonString));

        foreach ($dosen_kepeg as $dosen) {

            switch ($dosen->pendidikan) {
                case 'S3':
                    $pendidikan = 3;
                    break;
                case 'S2':
                    $pendidikan = 2;
                    break;
                case 'Profesi':
                    $pendidikan = 4;
                    break;
                default:
                    $pendidikan = 0;
                    break;
            }

            switch ($dosen->fungsional) {
                case 'Asisten Ahli':
                    $fungsional = 1;
                    break;
                case 'Lektor':
                    $fungsional = 2;
                    break;
                case 'Lektor Kepala':
                    $fungsional = 3;
                    break;
                case 'Guru Besar':
                    $fungsional = 4;
                    break;
                case 'Tenaga Pengajar':
                    $fungsional = 5;
                    break;
                default:
                    $fungsional = 0;
                    break;
            }

            $find = DosenHomebase::where('nidn', $dosen->nidn)->first();
            if ($find) {
                $find->update([
                    'nama' => $dosen->nama,
                    'nidn' => $dosen->nidn,
                    'pendidikan' => $pendidikan,
                    'bidang_keahlian' => '',
                    'kesesuaian_kompetensi' => true,
                    'kesesuaian_matakuliah' => true,
                    'nomor_sertifikasi' => $dosen->no_sertifikasi,
                    'fungsional' => $fungsional,
                    'golongan' => $dosen->golongan,
                    'bidang_keahlian' => $dosen->bidang_keahlian,
                ]);

                $this->info("Berhasil Update Dosen : " . $dosen->nama);
            }
        }

        $this->info("Selesai ...");
    }
}
