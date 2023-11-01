<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\StatusMahasiswa;
use Illuminate\Support\Facades\File;

class AktivitasMahasiswaMatematikaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Mengambil path file JSON
        $filePath = public_path('json/transkrip.json');

        // Membaca isi file JSON ke dalam string
        $jsonString = File::get($filePath);

        // Mengubah JSON menjadi koleksi (collection)
        $transkrip = collect(json_decode($jsonString));

        foreach ($transkrip as &$t) {

            $t->data = collect($t->data);

            foreach ($t->data as &$m) {

                $m->SKS = intval($m->SKS);
                $m->Tahun = intval($m->Tahun);
                $m->Bobot = floatval($m->Bobot);
                $m->Semester = intval(substr($m->Tahun, -1));
            }

            //Menghapus MK yang nilai E / 0
            $t->data = $t->data->filter(function($s){
                return $s->Bobot > 0;
            });

            //Menghilangkan MK yang dobel , ambil nilai tertingginya.
            $data_temp = $t->data->groupBy('Kode');
            $data_temp->each(function($i){

                $i = collect($i);
                if (count($i) > 1) {
                    $cb = $i->max('Bobot');
                    $i->filter(function($t) use ($cb){
                        return $t->Bobot == $cb;
                    });
                }
            });
            $t->data = $data_temp->flatten()->values();

            //Grup MK berdasarkan Tahun Semester
            $group = $t->data->groupBy('Tahun');

            //Mendefinisikan Tahun Semester
            $tahun = [];
            foreach ($group as $key => $item) {
                $tahun[] = $key;
            }
            sort($tahun);

            //Melakukan Perhitungan Pada Tiap Tiap Tahun Semester
            $sks = 0;
            $nb = 0;
            $data_sem = collect();
            foreach ($tahun as $th) {
                $mk = $t->data->where('Tahun', $th);
                $ipk = 0;
                foreach ($mk as $k => $w) {
                    $nb += $w->Bobot * $w->SKS;
                    $sks += $w->SKS;
                }

                if ($nb != 0 && $sks != 0) {
                    $ipk = $nb / $sks;
                }

                $data_sem->push(collect([
                    'tahun' => $th,
                    'ipk' => round($ipk, 2),
                    'sks' => $sks,
                ]));
            }

            $t->data = $data_sem;    

        }

        //Menyimpan Aktivitas Kuliah Ke Database
        foreach ($transkrip as $tk) {
            $mhs = $tk->nim;
            $cek_mhs = Mahasiswa::where('nim', $mhs)->first();
            if ($cek_mhs) {
                foreach ($tk->data as $tkd) {
                    $to_tahun = substr($tkd['tahun'], 0, 4);
                    $to_semester = substr($tkd['tahun'], -1);
                    $to_mhs_id = $cek_mhs->id;
                    $to_ipk = $tkd['ipk'];
                    $to_sks = $tkd['sks'];
                    $to_status = 'aktif';
                    $to_prodi = 44201;

                    $cek_aktivitas = StatusMahasiswa::where('mahasiswa_id', $to_mhs_id)->where('tahun', $to_tahun)->where('semester', $to_semester)->first();

                    if ($cek_aktivitas) {
                        $cek_aktivitas->update([
                            'ipk' => $to_ipk,
                            'sks' => $to_sks,
                            'status' => $to_status
                        ]);
                    }else{
                        StatusMahasiswa::create([
                            'kode_prodi' => $to_prodi,
                            'mahasiswa_id' => $to_mhs_id,
                            'tahun' => $to_tahun,
                            'semester' => $to_semester,
                            'ipk' => $to_ipk,
                            'sks' => $to_sks,
                            'status' => $to_status
                        ]);
                    }
                }
            }
            
        }
    }
}
