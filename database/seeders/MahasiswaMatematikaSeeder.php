<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MahasiswaMatematikaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = public_path('json/fix/mahasiswa_matematika.json');
        $jsonString = File::get($filePath);
        $mahasiswa = collect(json_decode($jsonString));

        foreach ($mahasiswa as $m) {

            $rules = [
                'nama' => $m->nama,
                'nim' => $m->nim,
                'kelamin' => $m->kelamin,
                'bidikmisi' => $m->bidikmisi,
                'daftar_ulang' => $m->daftar_ulang,
                'jalur_masuk' => $m->jalur_masuk,
                'tahun_masuk' => $m->tahun_masuk,
                'tahun_keluar' => $m->tahun_keluar,
                'status_keluar' => $m->status_keluar,
                'asing' => $m->asing,
                'asing_part_time' => $m->asing_part_time,
                'ipk' => $m->ipk,
                'masastudi' => $m->masastudi,
                'tanggal_yudisium' => $m->tanggal_yudisium,
            ];

            $rules['kode_prodi'] = 44201;

            Mahasiswa::create($rules);
        }
    }
}
