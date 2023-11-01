<?php

namespace App\Console\Commands;

use App\Models\DosenHomebase;
use App\Models\Prodi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SettingDosenUniversitas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:dosen-untad';

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
       
        $this->info('Setting dimulai ... ');

        $this->info('Menghilangkan Profesi menjadi S1 ... ');
        
        //Merubah Profesi Menjadi S1
        $dosen_profesi = DosenHomebase::where('pendidikan', 4)->get();
        if ($dosen_profesi) {
            foreach ($dosen_profesi as $dosprof) {
                $dosprof->update(['pendidikan' => 1]);
            }
        }

        //Setting Dosen fakultas dengan Pendidikan
        $fakultas = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]);
        $s3 = [111, 56, 70, 49, 71, 52, 26, 28, 6, 41, 6, 44, 0, 0];
        $s2 = [165, 95, 81, 67, 41, 125, 69, 20, 51, 36, 30, 0, 10, 11];

        $data = $fakultas->map(function ($value, $index) use ($s2, $s3){

            return collect([
                'fakultas' => $value,
                'S3' => $s3[$index],
                'S2' => $s2[$index],
            ]);

        });

        $this->info('Setting Pendidikan Dosen beberapa Fakultas ... ');
        foreach ($data as &$i) {
            
            //Mencari Dosen S3
            $dosen_s3 = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                $query->where('fakultas', $i['fakultas']);
            })->where('pendidikan', 3)->get();

            
            if ($i['S3'] > $dosen_s3->count()) { //Jika Kurang
                $selisih = $i['S3'] - $dosen_s3->count();

                $cari = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                    $query->where('fakultas', $i['fakultas']);
                })->where('pendidikan', 2)->limit($selisih)->get();

                $cari->each(function($i){
                    $i->update([
                        'pendidikan' => 3
                    ]);
                });

            } else if($i['S3'] < $dosen_s3->count()){ //Jika Lebih
                $selisih = $dosen_s3->count() - $i['S3'];
                
                $cari = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                    $query->where('fakultas', $i['fakultas']);
                })->where('pendidikan', 3)->where('fungsional', '!=', 4)->limit($selisih)->get();

                $cari->each(function($i){
                    $i->update([
                        'pendidikan' => 2
                    ]);
                });

                $tersisa = $selisih - count($cari);
                if ($tersisa > 0) {
                    $cari_sisanya = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                        $query->where('fakultas', $i['fakultas']);
                    })->where('pendidikan', 3)->limit($tersisa)->get();

                    $cari_sisanya->each(function($i){
                        $i->update([
                            'pendidikan' => 2
                        ]);
                    });
                }
            }

            //Mencari Dosen S2
            $dosen_s2 = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                $query->where('fakultas', $i['fakultas']);
            })->where('pendidikan', 2)->get();

            if ($i['S2'] > $dosen_s2->count()) { //Jika Kurang
                $selisih = $i['S2'] - $dosen_s2->count();

                $cari = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                    $query->where('fakultas', $i['fakultas']);
                })->whereNotIn('pendidikan', [3, 2])->limit($selisih)->get();

                $cari->each(function($i){
                    $i->update([
                        'pendidikan' => 2
                    ]);
                });

                $tersisa = $selisih - count($cari);
                
                $cari_lagi = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                    $query->where('fakultas', '!=', $i['fakultas']);
                })->whereNotIn('pendidikan', [3, 2])->limit($tersisa)->get();

                $set_homebase = Prodi::where('fakultas', $i['fakultas'])->get();
                $random = $set_homebase->random(1);
                $homebase = $random[0]->kode;

                $cari_lagi->each(function($i) use ($homebase){
                    $i->update([
                        'pendidikan' => 2,
                        'homebase' => $homebase
                    ]);
                });

            } else if($i['S2'] < $dosen_s2->count()){ //Jika Lebih
                $selisih = $dosen_s2->count() - $i['S2'];
                
                $cari = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                    $query->where('fakultas', $i['fakultas']);
                })->where('pendidikan', 2)->limit($selisih)->get();

                $cari->each(function($i){
                    $i->update([
                        'pendidikan' => 1
                    ]);
                });

            }

            //Mendefinisikan kembali
            $i['hasil_s3'] = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                $query->where('fakultas', $i['fakultas']);
            })->where('pendidikan', 3)->count();

            $i['s3_status'] = $i['hasil_s3'] - $i['S3'];

            $i['hasil_s2'] = DosenHomebase::whereHas('prodi_homebase', function($query) use($i){
                $query->where('fakultas', $i['fakultas']);
            })->where('pendidikan', 2)->count();

            $i['s2_status'] = $i['hasil_s2'] - $i['S2'];
        }

        $this->info('Menghilangkan Dosen Selain S2 dan S3 ... ');
        //Hapus Dosen yang bukan S3 dan S2
        $get_dosen = DosenHomebase::whereNotIn('pendidikan', [3,2])->get();
        $get_dosen->each(function($i){
            $i->delete();
        });

        $fungsional = [
            [16, 262],
            [211, 255],
            [232, 84],
            [82, 0],
            [19, 200]
        ];

        $this->info('Setting Jabatan Fungsional Dosen ... ');
        foreach ($fungsional as $index => $value) {

            $cari_dos_fun = DosenHomebase::whereIn('pendidikan', [2,3])->where('fungsional', $index+1)->get();

            foreach ($value as $n => $v) {

                $filter_cari_dosen_fun= $cari_dos_fun->filter(function($i) use ($n){
                    return $i->pendidikan == 3 - $n;
                })->values();

                $hitung_selisih = 0;
                $fung_dipilih = 0;
                $fung_diubah = 0;

                if (count($filter_cari_dosen_fun) > $v) {
                    $hitung_selisih = count($filter_cari_dosen_fun) - $v;
                    $fung_diubah =  $index + 2;
                    $fung_dipilih = $index + 1;
                }else if (count($filter_cari_dosen_fun) < $v) {
                    $hitung_selisih = $v - count($filter_cari_dosen_fun);
                    $fung_diubah = $index + 1;
                    $fung_dipilih = $index + 2;
                }

                $search = DosenHomebase::where('pendidikan', 3 - $n)->where('fungsional', $fung_dipilih)->get();
                $search_random = $search->random($hitung_selisih);
                $search_random->each(function($i) use ($fung_diubah){
                    $i->update([
                        'fungsional' => $fung_diubah
                    ]);
                });
                

            }

        }

        $this->info('Setting selesai .');
    }
}
