<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function index()
    {
        return view('portaldata.kurikulum');
    }

    public function get_data(Request $request)
    {
        $prodi = $request->prodi;

        $data = [];

        // Query data dengan filter sesuai parameter
        $query = Prodi::query();
        $query->where('id', $prodi);
        $query->with('matakuliah');
        $data = $query->first();

        //Menambahkan variabel kedalam collection data

        $semester = [
            'Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5',
            'Semester 6', 'Semester 7', 'Semester 8',
        ];
        $data['data_semester'] = collect();
        foreach ($semester as $key) {
            $data['data_semester']->push(collect([
                'nama' => $key,
                'jumlah_mk' => 0,
                'jumlah_sks' => 0,
                'jumlah_sks_praktikum' => 0,
                'jumlah_sks_tanpa_praktikum' => 0,
            ]));
        }

        $keys = ['mku', 'inti', 'pilihan'];
        $names = ['Mata Kuliah Umum', 'Mata Kuliah Inti Prodi', 'Mata Kuliah Pilihan'];
        $data['data_jenis'] = collect();
        foreach ($keys as $i => $key) {
            $data['data_jenis']->put($key, collect([
                'nama' => $names[$i],
                'jumlah_mk' => 0,
                'jumlah_sks' => 0,
                'jumlah_sks_praktikum' => 0,
                'jumlah_sks_tanpa_praktikum' => 0,
            ]));
        }

        $data['data_wajib'] = collect([
            'wajib' => collect([
                'nama' => 'Mata Kuliah Wajib',
                'jumlah_mk' => 0,
                'jumlah_sks' => 0,
                'jumlah_sks_praktikum' => 0,
                'jumlah_sks_tanpa_praktikum' => 0,
            ]),
            'tidak_wajib' => collect([
                'nama' => 'Mata Kuliah Tidak Wajib',
                'jumlah_mk' => 0,
                'jumlah_sks' => 0,
                'jumlah_sks_praktikum' => 0,
                'jumlah_sks_tanpa_praktikum' => 0,
            ])
        ]);

        //Perulangan untuk memproses data
        //Memproses data semester
        $mk = $data['matakuliah'];
        foreach ($mk as $matkul) {

            $arr = 999;
            if ($matkul['semester'] == 1) {
                $arr = 0;
            } elseif ($matkul['semester'] == 2) {
                $arr = 1;
            } elseif ($matkul['semester'] == 3) {
                $arr = 2;
            } elseif ($matkul['semester'] == 4) {
                $arr = 3;
            } elseif ($matkul['semester'] == 5) {
                $arr = 4;
            } elseif ($matkul['semester'] == 6) {
                $arr = 5;
            } elseif ($matkul['semester'] == 7) {
                $arr = 6;
            } elseif ($matkul['semester'] == 8) {
                $arr = 7;
            }

            if ($arr != 999) {
                $data['data_semester'][$arr]['jumlah_mk'] += 1;
                $data['data_semester'][$arr]['jumlah_sks'] += $matkul['sks'];
                $data['data_semester'][$arr]['jumlah_sks_praktikum'] += $matkul['sks_praktikum'];
                $temps = $matkul['sks'] - $matkul['sks_praktikum'];
                $data['data_semester'][$arr]['jumlah_sks_tanpa_praktikum'] += $temps;
            }

            //Memproses data jenis matakuliah
            $temp_jenis = '';
            if ($matkul['jenis'] == 'mku') {
                $temp_jenis = 'mku';
            } elseif ($matkul['jenis'] == 'inti') {
                $temp_jenis = 'inti';
            } elseif ($matkul['jenis'] == 'pilihan') {
                $temp_jenis = 'pilihan';
            }

            if ($temp_jenis != '') {
                $data['data_jenis'][$temp_jenis]['jumlah_mk'] += 1;
                $data['data_jenis'][$temp_jenis]['jumlah_sks'] += $matkul['sks'];
                $data['data_jenis'][$temp_jenis]['jumlah_sks_praktikum'] += $matkul['sks_praktikum'];
                $jens = $matkul['sks'] - $matkul['sks_praktikum'];
                $data['data_jenis'][$temp_jenis]['jumlah_sks_tanpa_praktikum'] += $jens;
            }

            //Memproses data matakuliah wajib atau tidak
            $temp_wajib = 999;
            if ($matkul['status'] == 1) {
                $temp_wajib = 'wajib';
            } elseif ($matkul['status'] == 0) {
                $temp_wajib = 'tidak_wajib';
            }

            if ($temp_wajib != 999) {
                $data['data_wajib'][$temp_wajib]['jumlah_mk'] += 1;
                $data['data_wajib'][$temp_wajib]['jumlah_sks'] += $matkul['sks'];
                $data['data_wajib'][$temp_wajib]['jumlah_sks_praktikum'] += $matkul['sks_praktikum'];
                $wjb = $matkul['sks'] - $matkul['sks_praktikum'];
                $data['data_wajib'][$temp_wajib]['jumlah_sks_tanpa_praktikum'] += $wjb;
            }
        }

        //Mengambalikan data kedalam json
        return response()->json(['data' => $data], 200);
    }

    public function get_prodi_list(Request $request)
    {
        return Prodi::where('fakultas', $request->fakultas)->where('jenjang', $request->jenjang)->get();
    }
}
