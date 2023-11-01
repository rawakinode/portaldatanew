<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class PengabdianController extends Controller
{
    public function index()
    {
        return view('portaldata.pengabdian');
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
            $query->with('pengabdian');
        }]);
        $data = $query->get();

        //Membuat variabel di collection $data
        $all_data['total_pengabdian'] = 0;

        $tahun = ['2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015', '2014', '2013', '2012', '2011', '2010'];
        $all_data['tahun'] = collect();
        foreach ($tahun as $p) {
            $all_data['tahun'][$p] = 0;
        }

        $sumber_dana = [
            'Mandiri',
            'Perguruan Tinggi',
            'Nasional',
            'Internasional',
        ];
        $all_data['sumber_dana'] = collect();
        foreach ($sumber_dana as $dana) {
            $all_data['sumber_dana']->push(collect([
                'nama' => $dana,
                'jumlah' => 0
            ]));
        }

        $kategori_dana = [
            'Dibawah 5 Juta',
            'Diatas 5 Juta - 10 Juta',
            'Diatas 10 Juta - 15 Juta',
            'Diatas 15 Juta - 20 Juta',
            'Diatas 20 Juta - 30 Juta',
            'Diatas 30 Juta - 50 Juta',
            'Diatas 50 Juta',
        ];
        $all_data['jumlah_dana'] = collect();
        foreach ($kategori_dana as $dana) {
            $all_data['jumlah_dana']->push(collect([
                'nama' => $dana,
                'jumlah' => 0
            ]));
        }


        //Perulangan Fakultas
        foreach ($data as $d) {

            //Membuat variabel di collection $data
            $d['total_pengabdian'] = 0;

            $d['tahun'] = collect();
            foreach ($tahun as $p) {
                $d['tahun'][$p] = 0;
            }

            $d['sumber_dana'] = collect();
            foreach ($sumber_dana as $dana) {
                $d['sumber_dana']->push(collect([
                    'nama' => $dana,
                    'jumlah' => 0
                ]));
            }
    
            $d['jumlah_dana'] = collect();
            foreach ($kategori_dana as $dana) {
                $d['jumlah_dana']->push(collect([
                    'nama' => $dana,
                    'jumlah' => 0
                ]));
            }

            foreach ($d['prodi'] as $p) {

                //Membuat variabel di collection $data
                $p['total_pengabdian'] = 0;

                $p['tahun'] = collect();
                foreach ($tahun as $px) {
                    $p['tahun'][$px] = 0;
                }

                $p['sumber_dana'] = collect();
                foreach ($sumber_dana as $dana) {
                    $p['sumber_dana']->push(collect([
                        'nama' => $dana,
                        'jumlah' => 0
                    ]));
                }
        
                $p['jumlah_dana'] = collect();
                foreach ($kategori_dana as $dana) {
                    $p['jumlah_dana']->push(collect([
                        'nama' => $dana,
                        'jumlah' => 0
                    ]));
                }

                //Mengolah data $data
                foreach ($p['pengabdian'] as $m) {

                    $all_data['total_pengabdian'] += 1;
                    $d['total_pengabdian'] += 1;
                    $p['total_pengabdian'] += 1;

                    //Mengolah data berdasarkan Tahun Terbit
                    $thns = $m['tahun'];
                    if (isset($p['tahun'][$thns])) {
                        $p['tahun'][$thns] += 1;
                        $d['tahun'][$thns] += 1;
                        $all_data['tahun'][$thns] += 1;
                    }

                    //Mengolah data berdasarkan Sumber Dana
                    $sumber = 999;

                    if ($m['sumber_dana'] == 'mandiri') {
                        $sumber = 0;
                    }elseif ($m['sumber_dana'] == 'perguruan tinggi') {
                        $sumber = 1;
                    }elseif ($m['sumber_dana'] == 'nasional') {
                        $sumber = 2;
                    }elseif ($m['sumber_dana'] == 'internasional') {
                        $sumber = 3;
                    }

                    if ($sumber != 999) {
                        $all_data['sumber_dana'][$sumber]['jumlah'] += 1;
                        $d['sumber_dana'][$sumber]['jumlah'] += 1;
                        $p['sumber_dana'][$sumber]['jumlah'] += 1;
                    }


                    //Mengolah data berdasarkan Jumlah Dana
                    $dana = 999;
                    $jd = $m['jumlah_dana'];
                    if ($jd <= 5000000) {
                        $dana = 0;
                    } elseif ($jd > 5000000 && $jd <= 10000000) {
                        $dana = 1;
                    } elseif ($jd > 10000000 && $jd <= 15000000) {
                        $dana = 2;
                    } elseif ($jd > 15000000 && $jd <= 20000000) {
                        $dana = 3;
                    } elseif ($jd > 20000000 && $jd <= 30000000) {
                        $dana = 4;
                    } elseif ($jd > 30000000 && $jd <= 40000000) {
                        $dana = 5;
                    } elseif ($jd > 50000000) {
                        $dana = 6;
                    }

                    if ($dana != 999) {
                        $all_data['jumlah_dana'][$dana]['jumlah'] += 1;
                        $d['jumlah_dana'][$dana]['jumlah'] += 1;
                        $p['jumlah_dana'][$dana]['jumlah'] += 1;
                    }
                }
            }
        }

        return response()->json(['data' => $data->all(), 'status' => $all_data->all()], 200);
    }
}
