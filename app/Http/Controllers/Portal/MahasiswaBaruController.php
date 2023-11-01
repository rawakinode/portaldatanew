<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class MahasiswaBaruController extends Controller
{
    public function index()
    {
        return view('portaldata.mahasiswa_baru');
    }

    public function get_data(Request $request)
    {
        $status = $request->status;
        $fakultas = $request->fakultas;
        $periode = $request->tahun;
        $jenjang = $request->jenjang;

        $data = [];
        $all_data = collect();

        // Query data dengan filter fakultas, jenjang, dan status sesuai parameter
        $query = Faculty::query();

        if ($fakultas != 0) {
            $query->where('code', $fakultas);
        } 

        $query->with(['prodi' => function ($query) use ($periode, $status) {
            $query->with(['mahasiswa' => function ($query) use ($periode, $status) {
                if ($status == 0) {
                    $query->where('tahun_masuk', $periode);
                } else {
                    $query->where('tahun_masuk', $periode)->where('daftar_ulang', 1);
                }
            }]);
        }]);

        if ($jenjang != null) {
            $query->with(['prodi' => function ($query) use ($periode, $status, $jenjang) {
                $query->where('jenjang', $jenjang)->with(['mahasiswa' => function ($query) use ($periode, $status) {
                    if ($status == 0) {
                        $query->where('tahun_masuk', $periode);
                    } else {
                        $query->where('tahun_masuk', $periode)->where('daftar_ulang', 1);
                    }
                }]);
            }]);
        }

        $data = $query->get();

        //return $data;

        $all_data['total_mahasiswa'] = 0;
        $all_data['jenis_kelamin'] = collect([
            'pria' => 0,
            'wanita' => 0,
            'total' => 0
        ]);

        $all_data['jalur_masuk'] = collect([
            'snmptn' => collect([
                'jalur' => 'snmptn',
                'cowo' => 0,
                'cewe' => 0,
                'total' => 0
            ]),
            'sbmptn' => collect([
                'jalur' => 'sbmptn',
                'cowo' => 0,
                'cewe' => 0,
                'total' => 0
            ]),
            'smmptn' => collect([
                'jalur' => 'smmptn',
                'cowo' => 0,
                'cewe' => 0,
                'total' => 0
            ]),
            'lainnya' => collect([
                'jalur' => 'lainnya',
                'cowo' => 0,
                'cewe' => 0,
                'total' => 0
            ]),
        ]);

        //Perulangan Fakultas
        foreach ($data as $d) {

            $d['total_mahasiswa'] = 0;
            $d['jenis_kelamin'] = collect([
                'pria' => 0,
                'wanita' => 0,
                'total' => 0
            ]);

            $d['jalur_masuk'] = collect([
                'snmptn' => collect([
                    'jalur' => 'snmptn',
                    'cowo' => 0,
                    'cewe' => 0,
                    'total' => 0
                ]),
                'sbmptn' => collect([
                    'jalur' => 'sbmptn',
                    'cowo' => 0,
                    'cewe' => 0,
                    'total' => 0
                ]),
                'smmptn' => collect([
                    'jalur' => 'smmptn',
                    'cowo' => 0,
                    'cewe' => 0,
                    'total' => 0
                ]),
                'lainnya' => collect([
                    'jalur' => 'lainnya',
                    'cowo' => 0,
                    'cewe' => 0,
                    'total' => 0
                ]),
            ]);

            foreach ($d['prodi'] as $p) {

                $p['total_mahasiswa'] = 0;
                $p['jenis_kelamin'] = collect([
                    'pria' => 0,
                    'wanita' => 0,
                    'total' => 0
                ]);

                $p['jalur_masuk'] = collect([
                    'snmptn' => collect([
                        'jalur' => 'snmptn',
                        'cowo' => 0,
                        'cewe' => 0,
                        'total' => 0
                    ]),
                    'sbmptn' => collect([
                        'jalur' => 'sbmptn',
                        'cowo' => 0,
                        'cewe' => 0,
                        'total' => 0
                    ]),
                    'smmptn' => collect([
                        'jalur' => 'smmptn',
                        'cowo' => 0,
                        'cewe' => 0,
                        'total' => 0
                    ]),
                    'lainnya' => collect([
                        'jalur' => 'lainnya',
                        'cowo' => 0,
                        'cewe' => 0,
                        'total' => 0
                    ]),
                ]);

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
                }
            }
        }

        return response()->json(['data' => $data->all(), 'status' => $all_data->all()], 200);
    }
}
