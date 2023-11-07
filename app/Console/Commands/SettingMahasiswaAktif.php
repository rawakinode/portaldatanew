<?php

namespace App\Console\Commands;

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
        $prodi = Prodi::all();

        // $prodi = 44201;
        $semester = 20221;

        $time_start = new \DateTime();
        
        foreach ($prodi as $item) {

            $this->info("Menghitung mahasiswa prodi : ". $item->nama);

            $kodeprodi = $item->kode;
            $aktif = StatusMahasiswa::whereHas('mahasiswa', function($query) use ($kodeprodi){
                $query->where('kode_prodi', $kodeprodi);
            })->where('status', 'aktif')->where('tahun', substr($semester, 0,4))->where('semester', substr($semester, -1))->get();
    
            $nonaktif = StatusMahasiswa::whereHas('mahasiswa', function($query) use ($kodeprodi){
                $query->where('kode_prodi', $kodeprodi);
            })->where('status', 'nonaktif')->where('tahun', substr($semester, 0,4))->where('semester', substr($semester, -1))->get();
    
            $cuti = StatusMahasiswa::whereHas('mahasiswa', function($query) use ($kodeprodi){
                $query->where('kode_prodi', $kodeprodi);
            })->where('status', 'cuti')->where('tahun', substr($semester, 0,4))->where('semester', substr($semester, -1))->get();

            $check = PortalMahasiswaAktif::where('kode_prodi', $kodeprodi)->where('tahun', substr($semester, 0,4))->where('semester', substr($semester, -1))->first();

            if (!$check) {
                PortalMahasiswaAktif::create([
                    "kode_prodi" => $kodeprodi,
                    "fakultas" => $item->fakultas,
                    "jenjang" => $item->jenjang,
                    "tahun" => substr($semester, 0,4),
                    "semester" => substr($semester, -1),
                    "aktif" => count($aktif),
                    "nonaktif" => count($nonaktif),
                    "cuti" => count($cuti),
                ]);
            }else{
                $check->update([
                    "aktif" => count($aktif),
                    "nonaktif" => count($nonaktif),
                    "cuti" => count($cuti),
                ]);
            }
        }
        

        $time_end = new \DateTime();
        $execution_time = $time_start->diff($time_end)->format('%H:%I:%S');
        
        $this->info("Selesai dalam : " . $execution_time);
    }
}
