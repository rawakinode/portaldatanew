<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class MahasiswaController extends Controller
{
    public function index_aktif()
    {
        return view('portaldata.mahasiswa_aktif');
    }

    public function mahasiswa_aktif_get(Request $request)
    {
        $status = $request->status;
        $fakultas = $request->fakultas;
        $periode = Str::substr($request->tahun, 0, 4);
        $semester = Str::substr($request->tahun, 4, 1);
        $jenjang = $request->jenjang;

        $data = [];

        // Query data dengan filter fakultas dan jenjang sesuai parameter
        $query = Faculty::query();
        if ($fakultas != 0) {
            $query->where('code', $fakultas);
        }
        $query->with(['prodi' => function ($query) use ($periode, $semester, $status) {
            $query->with(['status_mahasiswa' => function ($query) use ($periode, $semester, $status) {
                $query->where('status', $status)->where('tahun', $periode)->where('semester', $semester)->with('mahasiswa');
            }]);
        }]);
        if ($jenjang != null) {
            $query->with(['prodi' => function ($query) use ($periode, $semester, $status,$jenjang) {
                $query->whereJenjang($jenjang)->with(['status_mahasiswa' => function ($query) use ($periode, $semester, $status) {
                    $query->where('status', $status)->where('tahun', $periode)->where('semester', $semester)->with('mahasiswa');
                }]);
            }]);
        }

        $data = $query->get();

        $all_status = collect([
            'angkatan' => collect(),
            'jalurmasuk' => collect([
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
            ]),
            'jeniskelamin' => collect(['pria' => 0, 'wanita' => 0, 'total' => 0]),
            'ipk' => collect(['a' => 0, 'b' => 0, 'c' => 0, 'd' => 0, 'e' => 0]),
        ]);

        //Perulangan fakulas
        foreach ($data as $fak) {

            //Menambahkan array baru untuk fakultas
            $fak['status'] = collect([
                'angkatan' => collect(),
                'jalurmasuk' => collect([
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
                ]),
                'jeniskelamin' => collect(['pria' => 0, 'wanita' => 0, 'total' => 0]),
                'ipk' => collect(['a' => 0, 'b' => 0, 'c' => 0, 'd' => 0, 'e' => 0]),
            ]);

            $fak['total_status_mahasiswa'] = 0;

            //Variable
            $angkatan = collect(['2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026',]);
            $jalurmasuk = collect(['snmptn', 'sbmptn', 'smmptn', 'lainnya']);

            //Perulangan Prodi
            foreach ($fak->prodi as $pro) {

                $mhs = $pro->mahasiswa;
                $status = $pro->status_mahasiswa;

                $fak['total_status_mahasiswa'] += $status->count();
                $pro['total_status_mahasiswa'] += $status->count();

                foreach ($mhs as $ms) {
                    $pro['jumlah_mahasiswa'] += 1;
                }

                //Menambahkan array baru untuk prodi
                $pro['status'] = collect([
                    'angkatan' => collect(),
                    'jalurmasuk' => collect(),
                    'jeniskelamin' => collect(['pria' => 0, 'wanita' => 0, 'total' => 0]),
                    'ipk' => collect(['a' => 0, 'b' => 0, 'c' => 0, 'd' => 0, 'e' => 0]),
                ]);

                //Perulangan Angkatan
                foreach ($angkatan as $ang) {

                    $pria = 0;
                    $wanita = 0;

                    foreach ($pro['status_mahasiswa'] as $sm) {
                        if ($sm['mahasiswa']['tahun_masuk'] == $ang && $sm['mahasiswa']['kelamin'] == 1) {
                            $pria += 1;
                        } else if ($sm['mahasiswa']['tahun_masuk'] == $ang && $sm['mahasiswa']['kelamin'] == 0) {
                            $wanita += 1;
                        }
                    }

                    if ($pria != 0 || $wanita != 0) {
                        $pro['status']['angkatan']->push(collect(['angkatan' => $ang, 'pria' => $pria, 'wanita' => $wanita, 'total' => $pria + $wanita]));
                    }

                    if ($pria != 0 || $wanita != 0) {
                        $check_data = $fak['status']['angkatan']->where('angkatan', $ang)->all();
                        if (count($check_data) == 0) {
                            $fak['status']['angkatan']->push(collect(['angkatan' => $ang, 'pria' => $pria, 'wanita' => $wanita, 'total' => $pria + $wanita]));
                        } else {

                            foreach ($fak['status']['angkatan'] as $items) {
                                if ($items['angkatan'] == $ang) {
                                    $items['pria'] += $pria;
                                    $items['wanita'] += $wanita;
                                    $items['total'] = $items['pria'] + $items['wanita'];
                                }
                            }
                        }
                    }

                    if ($pria != 0 || $wanita != 0) {
                        $checking = $all_status['angkatan']->where('angkatan', $ang)->all();
                        if (count($checking) == 0) {
                            $all_status['angkatan']->push(collect(['angkatan' => $ang, 'pria' => $pria, 'wanita' => $wanita, 'total' => $pria + $wanita]));
                        } else {

                            foreach ($all_status['angkatan'] as $items) {
                                if ($items['angkatan'] == $ang) {
                                    $items['pria'] += $pria;
                                    $items['wanita'] += $wanita;
                                    $items['total'] = $items['pria'] + $items['wanita'];
                                }
                            }
                        }
                    }
                }

                //Perulangan Jalur Masuk
                foreach ($jalurmasuk as $jm) {
                    $cowo = 0;
                    $cewe = 0;

                    foreach ($pro['status_mahasiswa'] as $sms) {
                        if ($sms['mahasiswa']['jalur_masuk'] == $jm && $sms['mahasiswa']['kelamin'] == 1) {
                            $cowo += 1;
                        } else if ($sms['mahasiswa']['jalur_masuk'] == $jm && $sms['mahasiswa']['kelamin'] == 0) {
                            $cewe += 1;
                        }
                    }

                    $pro['status']['jalurmasuk'][$jm] = collect(['jalur' => $jm, 'cowo' => $cowo, 'cewe' => $cewe, 'total' => $cowo + $cewe]);

                    $fak['status']['jalurmasuk'][$jm]['cowo'] += $cowo;
                    $fak['status']['jalurmasuk'][$jm]['cewe'] += $cewe;
                    $fak['status']['jalurmasuk'][$jm]['total'] = $fak['status']['jalurmasuk'][$jm]['cowo'] + $fak['status']['jalurmasuk'][$jm]['cewe'];

                    $all_status['jalurmasuk'][$jm]['cowo'] += $cowo;
                    $all_status['jalurmasuk'][$jm]['cewe'] += $cewe;
                    $all_status['jalurmasuk'][$jm]['total'] += $cowo;
                    $all_status['jalurmasuk'][$jm]['total'] += $cewe;
                }

                //Perulangan Jenis Kelamin
                $pria = 0;
                $wanita = 0;

                foreach ($pro['status_mahasiswa'] as $sm) {
                    if ($sm['mahasiswa']['kelamin'] == 1) {
                        $pria += 1;
                    } else if ($sm['mahasiswa']['kelamin'] == 0) {
                        $wanita += 1;
                    }
                }

                $pro['status']['jeniskelamin']['pria'] = $pria;
                $pro['status']['jeniskelamin']['wanita'] = $wanita;
                $pro['status']['jeniskelamin']['total'] = $pria + $wanita;

                $fak['status']['jeniskelamin']['pria'] += $pria;
                $fak['status']['jeniskelamin']['wanita'] += $wanita;
                $fak['status']['jeniskelamin']['total'] += $pria;
                $fak['status']['jeniskelamin']['total'] += $wanita;

                $all_status['jeniskelamin']['pria'] += $pria;
                $all_status['jeniskelamin']['wanita'] += $wanita;
                $all_status['jeniskelamin']['total'] += $pria;
                $all_status['jeniskelamin']['total'] += $wanita;

                //Perualangan IPK
                foreach ($pro['status_mahasiswa'] as $sm) {
                    if ($sm['ipk'] != null) {
                        if ($sm['ipk'] <= 2) {
                            $pro['status']['ipk']['a'] += 1;
                            $fak['status']['ipk']['a'] += 1;
                            $all_status['ipk']['a'] += 1;
                        } else if ($sm['ipk'] > 2 && $sm['ipk'] <= 2.5) {
                            $pro['status']['ipk']['b'] += 1;
                            $fak['status']['ipk']['b'] += 1;
                            $all_status['ipk']['b'] += 1;
                        } else if ($sm['ipk'] > 2.5 && $sm['ipk'] <= 3) {
                            $pro['status']['ipk']['c'] += 1;
                            $fak['status']['ipk']['c'] += 1;
                            $all_status['ipk']['c'] += 1;
                        } else if ($sm['ipk'] > 3 && $sm['ipk'] <= 3.5) {
                            $pro['status']['ipk']['d'] += 1;
                            $fak['status']['ipk']['d'] += 1;
                            $all_status['ipk']['d'] += 1;
                        } else if ($sm['ipk'] > 3.5 && $sm['ipk'] <= 4) {
                            $pro['status']['ipk']['e'] += 1;
                            $fak['status']['ipk']['e'] += 1;
                            $all_status['ipk']['e'] += 1;
                        }
                    }
                }
            }
        }

        return response()->json(['data' => $data->all(), 'status' => $all_status], 200);
    }
}
