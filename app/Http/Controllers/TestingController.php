<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DosenHomebase;
use App\Models\Faculty;
use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\Prodi;
use App\Models\RekapProdi;
use App\Models\StatusMahasiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class TestingController extends Controller
{

    public function index()
    {

        // // Mengambil path file JSON
        // $filePath = public_path('json/mahasiswa_untad_all.json');

        // // Membaca isi file JSON ke dalam string
        // $jsonString = File::get($filePath);

        // // Mengubah JSON menjadi koleksi (collection)
        // $mahasiswaCollection = collect(json_decode($jsonString));

        // $mahasiswaCollection = $mahasiswaCollection->unique('nim');

        // $mahasiswaCollection = $mahasiswaCollection->filter(function ($i) {
        //     return intval($i->tahun_masuk) > 2014;
        // })->values();



        // foreach ($mahasiswaCollection as $value) {

        //     try {

        //         $kodeprodi = Prodi::where('kode', $value->kode)->first();

        //         if ($kodeprodi) {

        //             $validasi = [];
        //             $validasi['kode_prodi'] = $value->kode;
        //             $validasi['nim'] = $value->nim;
        //             $validasi['nama'] = strtoupper($value->nama);
        //             $validasi['daftar_ulang'] = 1;
        //             $validasi['bidikmisi'] = 0;
        //             $validasi['kelamin'] = $value->kelamin;
        //             $validasi['tahun_masuk'] = intval($value->tahun_masuk);

        //             $html = $value->kode . ',' .
        //                     $value->nim . ',' .
        //                     $value->nama . ',' .
        //                     $value->kelamin . ',0,1,' .
        //                     intval($value->tahun_masuk) . ',null,null,0,0,null,null,null <br>';

        //             echo $html;


        //             // DB::transaction(function () use ($value) {
        //             //     Mahasiswa::create([
        //             //         'kode_prodi' => $value->kode,
        //             //         'nama' => $value->nama,
        //             //         'nim' => $value->nim,
        //             //         'kelamin' => $value->kelamin,
        //             //         'bidikmisi' => 0,
        //             //         'daftar_ulang' => 1,
        //             //         'jalur_masuk' => 'lainnya',
        //             //         'tahun_masuk' => intval($value->tahun_masuk),
        //             //         'tahun_keluar' => null,
        //             //         'status_keluar' => null,
        //             //         'asing' => 0,
        //             //         'asing_part_time' => 0,
        //             //         'ipk' => null,
        //             //         'masastudi' => null,
        //             //         'tanggal_yudisium' => null,
        //             //     ]);
        //             // });
        //         }
        //     } catch (\Throwable $th) {
        //     }
        // }

        $fakultas = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]);
        $mhs_aktif = collect([7668, 3659, 4607, 2863, 2751, 4258, 2143, 1143, 762, 1615, 865, 1064, 379, 188]);

        $fakultas = Faculty::all();

        $fakultas = $fakultas->map(function ($i, $index) use ($mhs_aktif) {
            $p = Prodi::where('fakultas', $i->code)->get();
            $nims = $p->pluck('kode')->all();

            $m = StatusMahasiswa::whereIn('status', ['aktif', 'nonaktif', 'cuti'])->where('tahun', 2021)->where('semester', 1)->whereHas('mahasiswa', function ($query) use ($nims) {
                $query->whereIn('kode_prodi', $nims);
            })->count();

            $a = [
                "code" => $i->code,
                "name" => $i->name,
                "singkatan" => $i->singkatan,
                // "prodi" => $nims,
                "m_aktif" => $m,
                "m_aktif_set" => $mhs_aktif[$index],
                "m_aktif_selisih" => $mhs_aktif[$index] - $m
            ];

            return $a;
        });

        return $fakultas;

        
    }
}
