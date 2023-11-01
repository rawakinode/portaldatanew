<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index()
    {
        return view('portaldata.prestasi');
    }

    public function get_data(Request $request)
    {
        $fakultas = $request->fakultas;

        $data = [];
        $all_data = collect();

        // Query data dengan filter fakultas, jenjang, dan status sesuai parameter
        $query = Faculty::query();
        if ($fakultas != 0) {
            $query->where('code', $fakultas);
        }
        $query->with(['prodi' => function ($query) {
            $query->with('prestasi');
        }]);
        $data = $query->get();

        //Membuat variabel di collection $data
        $all_data['total_prestasi'] = 0;

        $tahun = ['2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015', '2014', '2013', '2012', '2011', '2010'];
        $all_data['tahun'] = collect();
        foreach ($tahun as $p) {
            $all_data['tahun'][$p] = 0;
        }

        $bidang = [
            'Akademik',
            'Non-Akademik',
        ];
        $all_data['bidang'] = collect();
        foreach ($bidang as $key) {
            $all_data['bidang']->push(collect([
                'nama' => $key,
                'jumlah' => 0
            ]));
        }

        $tingkat = [
            'Lokal',
            'Nasional',
            'Internasional',
        ];
        $all_data['tingkat'] = collect();
        foreach ($tingkat as $key) {
            $all_data['tingkat']->push(collect([
                'nama' => $key,
                'jumlah' => 0
            ]));
        }


        //Perulangan Fakultas
        foreach ($data as $d) {

            //Membuat variabel di collection $data
            $d['total_prestasi'] = 0;

            $d['tahun'] = collect();
            foreach ($tahun as $p) {
                $d['tahun'][$p] = 0;
            }

            $d['bidang'] = collect();
            foreach ($bidang as $key) {
                $d['bidang']->push(collect([
                    'nama' => $key,
                    'jumlah' => 0
                ]));
            }

            $d['tingkat'] = collect();
            foreach ($tingkat as $key) {
                $d['tingkat']->push(collect([
                    'nama' => $key,
                    'jumlah' => 0
                ]));
            }

            foreach ($d['prodi'] as $p) {

                //Membuat variabel di collection $data
                $p['total_prestasi'] = 0;

                $p['tahun'] = collect();
                foreach ($tahun as $px) {
                    $p['tahun'][$px] = 0;
                }

                $p['bidang'] = collect();
                foreach ($bidang as $key) {
                    $p['bidang']->push(collect([
                        'nama' => $key,
                        'jumlah' => 0
                    ]));
                }

                $p['tingkat'] = collect();
                foreach ($tingkat as $key) {
                    $p['tingkat']->push(collect([
                        'nama' => $key,
                        'jumlah' => 0
                    ]));
                }

                //Mengolah data $data
                foreach ($p['prestasi'] as $m) {

                    $all_data['total_prestasi'] += 1;
                    $d['total_prestasi'] += 1;
                    $p['total_prestasi'] += 1;

                    //Mengolah data berdasarkan Tahun Terbit
                    $thns = $m['tahun'];
                    if (isset($p['tahun'][$thns])) {
                        $p['tahun'][$thns] += 1;
                        $d['tahun'][$thns] += 1;
                        $all_data['tahun'][$thns] += 1;
                    }

                    //Mengolah data berdasarkan Bidang
                    $sumber = 999;

                    if ($m['bidang'] == 'akademik') {
                        $sumber = 0;
                    } elseif ($m['bidang'] == 'non-akademik') {
                        $sumber = 1;
                    }

                    if ($sumber != 999) {
                        $all_data['bidang'][$sumber]['jumlah'] += 1;
                        $d['bidang'][$sumber]['jumlah'] += 1;
                        $p['bidang'][$sumber]['jumlah'] += 1;
                    }

                    //Mengolah data berdasarkan Tingkat
                    $tings = 999;

                    if ($m['tingkat'] == 'lokal') {
                        $tings = 0;
                    } elseif ($m['tingkat'] == 'nasional') {
                        $tings = 1;
                    } elseif ($m['tingkat'] == 'internasional') {
                        $tings = 2;
                    }

                    if ($tings != 999) {
                        $all_data['tingkat'][$tings]['jumlah'] += 1;
                        $d['tingkat'][$tings]['jumlah'] += 1;
                        $p['tingkat'][$tings]['jumlah'] += 1;
                    }
                }
            }
        }

        return response()->json(['data' => $data->all(), 'status' => $all_data->all()], 200);
    }
}
