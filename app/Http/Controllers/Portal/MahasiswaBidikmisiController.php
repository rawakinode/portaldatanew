<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class MahasiswaBidikmisiController extends Controller
{
    public function index()
    {
        return view('portaldata.mahasiswa_bidikmisi');
    }

    public function get_data(Request $request)
    {
        $fakultas = $request->fakultas;
        $jenjang = $request->jenjang;

        $data = [];
        $all_data = collect();

        // Query data dengan filter fakultas, jenjang, dan status sesuai parameter
        $query = Faculty::query();

        if ($fakultas != 0) {
            $query->where('code', $fakultas);
        } 

        $query->with(['prodi' => function ($query) {
            $query->with(['mahasiswa' => function ($query) {
                    $query->where('bidikmisi', 1)->where('daftar_ulang', 1);
            }]);
        }]);

        if ($jenjang != null) {
            $query->with(['prodi' => function ($query) use ($jenjang) {
                $query->where('jenjang', $jenjang)->with(['mahasiswa' => function ($query) {
                    $query->where('bidikmisi', 1)->where('daftar_ulang', 1);
                }]);
            }]);
        }
        $data = $query->get();

        //Membuat variabel di collection $data
        $all_data['total_mahasiswa'] = 0;
        $all_data['jenis_kelamin'] = collect([
            'pria' => 0,
            'wanita' => 0,
            'total' => 0
        ]);

        $all_data['jalur_masuk'] = collect();
        $jalur = ['snmptn', 'sbmptn', 'smmptn', 'lainnya'];
        foreach ($jalur as $j) {
            $all_data['jalur_masuk'][$j] = collect([
                'jalur' => $j,
                'cowo' => 0,
                'cewe' => 0,
                'total' => 0
            ]);
        }

        $tahun_masuk = collect(['2022','2021','2020','2019','2018','2017','2016','2015','2014']);
        $all_data['tahun_masuk'] = collect();
        foreach ($tahun_masuk as $t) {
            $all_data['tahun_masuk'][$t] = 0;
        }

        //Perulangan Fakultas
        foreach ($data as $d) {

            $d['total_mahasiswa'] = 0;
            $d['jenis_kelamin'] = collect([
                'pria' => 0,
                'wanita' => 0,
                'total' => 0
            ]);

            $d['jalur_masuk'] = collect();
            $jalur = ['snmptn', 'sbmptn', 'smmptn', 'lainnya'];
            foreach ($jalur as $j) {
                $d['jalur_masuk'][$j] = collect([
                    'jalur' => $j,
                    'cowo' => 0,
                    'cewe' => 0,
                    'total' => 0
                ]);
            }

            $d['tahun_masuk'] = collect();
            foreach ($tahun_masuk as $t) {
                $d['tahun_masuk'][$t] = 0;
            }

            foreach ($d['prodi'] as $p) {

                $p['total_mahasiswa'] = 0;
                $p['jenis_kelamin'] = collect([
                    'pria' => 0,
                    'wanita' => 0,
                    'total' => 0
                ]);

                $p['jalur_masuk'] = collect();
                $jalur = ['snmptn', 'sbmptn', 'smmptn', 'lainnya'];
                foreach ($jalur as $j) {
                    $p['jalur_masuk'][$j] = collect([
                        'jalur' => $j,
                        'cowo' => 0,
                        'cewe' => 0,
                        'total' => 0
                    ]);
                }

                $p['tahun_masuk'] = collect();
                foreach ($tahun_masuk as $t) {
                    $p['tahun_masuk'][$t] = 0;
                }

                //Mengolah data //loop mahasiswa
                foreach ($p['mahasiswa'] as $m) {

                    $all_data['total_mahasiswa'] += 1;
                    $d['total_mahasiswa'] += 1;
                    $p['total_mahasiswa'] += 1;

                    //Mengolah data Jenis Kelamin

                    $p['jenis_kelamin']['total'] += 1;
                    $d['jenis_kelamin']['total'] += 1;
                    $all_data['jenis_kelamin']['total'] += 1;

                    if ($m['kelamin'] == 0) {
                        $p['jenis_kelamin']['wanita'] += 1;
                        $d['jenis_kelamin']['wanita'] += 1;
                        $all_data['jenis_kelamin']['wanita'] += 1;
                    } elseif ($m['kelamin'] == 1) {
                        $p['jenis_kelamin']['pria'] += 1;
                        $d['jenis_kelamin']['pria'] += 1;
                        $all_data['jenis_kelamin']['pria'] += 1;
                    }

                    //Mengolah data Jalur masuk
                    $p['jalur_masuk'][$m['jalur_masuk']]['total'] += 1;
                    $d['jalur_masuk'][$m['jalur_masuk']]['total'] += 1;
                    $all_data['jalur_masuk'][$m['jalur_masuk']]['total'] += 1;

                    if ($m['kelamin'] == 1) {
                        $p['jalur_masuk'][$m['jalur_masuk']]['cowo'] += 1;
                        $d['jalur_masuk'][$m['jalur_masuk']]['cowo'] += 1;
                        $all_data['jalur_masuk'][$m['jalur_masuk']]['cowo'] += 1;
                    } elseif ($m['kelamin'] == 0) {
                        $p['jalur_masuk'][$m['jalur_masuk']]['cewe'] += 1;
                        $d['jalur_masuk'][$m['jalur_masuk']]['cewe'] += 1;
                        $all_data['jalur_masuk'][$m['jalur_masuk']]['cewe'] += 1;
                    }

                    if(isset($p['tahun_masuk'][$m['tahun_masuk']])){
                        $p['tahun_masuk'][$m['tahun_masuk']] += 1;
                    }
                }
            }
        }

        return response()->json(['data' => $data->all(), 'status' => $all_data->all()], 200);
    }
}
