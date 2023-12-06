<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Mahasiswa;
use App\Models\PortalMahasiswaAktif;
use App\Models\Prodi;
use App\Models\StatusMahasiswa;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TestingController extends Controller
{

    public function index()
    {

        $sel3 = 100;
        $cari_yang_hilang = Mahasiswa::where('kode_prodi', 44201)->where('tahun_masuk', 2019)->where('tanggal_yudisium', null)->where('status_keluar', null)->get()->shuffle()->take($sel3)->values();

        return $cari_yang_hilang;

        // $path = public_path('json/mahasiswa_keluar/semua.json');
        // $getfile = File::get($path);
        // $collection = collect(json_decode($getfile));

        // $berhasil = 0;
        // $gagal = 0;

        // foreach ($collection as $m) {
        //     try {
        //         $s = Mahasiswa::where('nim', $m->nim)->first();
        //         if ($s) {

        //             $status = null;
        //             if ($m->status == "Lulus") {
        //                 $status = "lulus";
        //             } else if ($m->status == "Mengundurkan diri") {
        //                 $status = "mengundurkan diri";
        //             } else if ($m->status == "Dikeluarkan") {
        //                 $status = "dropout";
        //             } else if ($m->status == "Hilang") {
        //                 $status = "hilang";
        //             } else if ($m->status == "Lainnya") {
        //                 $status = "lainnya";
        //             } else if ($m->status == "Mutasi") {
        //                 $status = "lainnya";
        //             } else if ($m->status == "Wafat") {
        //                 $status = "lainnya";
        //             } else if ($m->status == "Putus Studi") {
        //                 $status = "lainnya";
        //             }

        //             try {
        //                 $date = Carbon::parse($m->yudisium);
        //                 $date = $date->format('Y-m-d');
        //             } catch (\Throwable $th) {
        //                 $date = null;
        //             }

        //             $s->update([
        //                 "status_keluar" => $status,
        //                 "tanggal_yudisium" => $date,
        //                 "ipk" => round($m->ipk, 2),
        //             ]);

        //             $berhasil++;
        //         }
        //     } catch (\Throwable $th) {
        //         $gagal++;
        //     }
        // }

        // return "Berhasil : " . $berhasil . " / Gagal : " . $gagal; 

        // return $collection->count();



        // $date_start = '2020-09-01';
        // $date_end = '2021-08-31';

        // $mahasiswa_lulus = Mahasiswa::where('status_keluar', 'lulus')
        // ->whereBetween('tanggal_yudisium', [$date_start, $date_end])
        // ->get();

        // return $mahasiswa_lulus->count();


        // $data = collect();
        // $file_name = collect(['2023_2022_2021', '2020', '2019', '2018_2017', '2016_2015_2014']);

        // foreach ($file_name as $name) {
        //     $filePath = public_path('json/mahasiswa_keluar/'.$name.'.json');
        //     $jsonString = File::get($filePath);
        //     $mahasiswa_keluar = collect(json_decode($jsonString));

        //     $data = $data->concat($mahasiswa_keluar);
        // }

        // $new_data = collect();
        // foreach ($data as $d) {
        //     $new_data->push([
        //         "nim" => $d->nipd,
        //         "ipk" => $d->ipk,
        //         "prodi" => $d->id_jur,
        //         "status" => $d->ket_keluar,
        //         "yudisium" => $d->tgl_sk_yudisium,
        //     ]);
        // }

        // // $mahasiswa_keluar = $mahasiswa_keluar->groupBy('ket_keluar');

        // $keterangan_lulus = ["Lulus","Mengundurkan diri","Mutasi","Hilang","Wafat","Lainnya","Dikeluarkan","Putus Studi"];

        // // return $mahasiswa_keluar->count();
        // return $new_data;
    }
}
