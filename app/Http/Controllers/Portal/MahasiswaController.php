<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Periode;
use App\Models\PortalMahasiswaAktif;
use App\Models\Prodi;
use App\Models\StatusMahasiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class MahasiswaController extends Controller
{
    public function index_aktif()
    {
        return view('portaldata.mahasiswa_aktif');
    }

    public function getMahasiswaAktif(Request $request)
    {
        $st = $request->status;
        $fk = $request->fakultas;
        $pd = $request->prodi;
        $pr = Str::substr($request->tahun, 0, 4);
        $sm = Str::substr($request->tahun, 4, 1);
        $jj = $request->jenjang;

        if ($pd != null) {

            $ps = Prodi::where('id', $pd)->first();

            $akt = PortalMahasiswaAktif::query();
            $akt->where('kode_prodi', $ps->kode);
            $akt->where('status', $st);
            $akt->where('tahun', $pr);
            $akt->where('semester', $sm);
            $akt = $akt->first();

            if (!$akt) {
                return 404;
            }
            $akt->jalur_masuk = json_decode($akt->jalur_masuk);
            $akt->tahun_masuk = json_decode($akt->tahun_masuk);
            $akt->jenis_kelamin = json_decode($akt->jenis_kelamin);
            $akt->ipk = json_decode($akt->ipk);

            $akt->jenis_kelamin->unit = $ps->nama;

            return response()->json([
                "chart" => [
                    "total" => $akt->total,
                    "label" => [$ps->nama],
                    "value" => [$akt->total],
                ],
                "data" => [
                    "tahun_masuk" => [
                        "chart" => [
                            "label" => collect($akt->tahun_masuk)->pluck('tahun')->toArray(),
                            "value" => collect($akt->tahun_masuk)->pluck('total')->toArray(),
                        ],
                        "tabel" => $akt->tahun_masuk,
                    ],
                    "jalur_masuk" => [
                        "chart" => [
                            "label" => collect($akt->jalur_masuk)->values()->pluck('jalur')->toArray(),
                            "value" => collect($akt->jalur_masuk)->values()->pluck('total')->toArray(),
                        ],
                        "tabel" => collect($akt->jalur_masuk)->values(),
                    ],
                    "jenis_kelamin" => [
                        "chart" => [
                            "label" => ['Laki-Laki', 'Perempuan'],
                            "value" => [$akt->jenis_kelamin->pria, $akt->jenis_kelamin->wanita],
                        ],
                        "tabel" => [$akt->jenis_kelamin],
                    ],
                    "ipk" => [
                        "chart" => [
                            "label" => ['0.00 - 2.00', '2.01 - 2.50', '2.51 - 3.00', '3.01 - 3.50', '3.51 - 4.00'],
                            "value" => collect($akt->ipk)->values(),
                        ],
                        "tabel" => collect($akt->ipk)->values()
                    ]
                ]
            ], 200);
        } else {

            $akt = PortalMahasiswaAktif::query();
            if ($fk != 0) {
                $akt->where('fakultas', $fk);
            }
            $akt->where('status', $st);
            $akt->where('tahun', $pr);
            $akt->where('semester', $sm);
            if ($jj != null) {
                $akt->where('jenjang', $jj);
            }
            $akt->with('prodi');
            $akt->with('faculty');
        
            $akt = $akt->get();

            if (!$akt->count()) {
                return 404;
            }

            $akt = $akt->map(function ($i) {
                $i->jalur_masuk = json_decode($i->jalur_masuk);
                $i->tahun_masuk = json_decode($i->tahun_masuk);
                $i->jenis_kelamin = json_decode($i->jenis_kelamin);
                $i->ipk = json_decode($i->ipk);
                return $i;
            });

            //Mendefinisikan Tahun Angkatan
            $tahun_masuk_chart_label = collect($akt[0]->tahun_masuk)->pluck('tahun')->toArray();
            $tahun_masuk_chart_value = collect();
            $tahun_masuk_tabel = collect();
            foreach ($tahun_masuk_chart_label as $tm) {
                $sum = $akt->sum(function ($i) use ($tm) {
                    $ue = collect($i->tahun_masuk)->filter(function ($h) use ($tm) {
                        return $h->tahun == $tm;
                    })->values();
                    return $ue[0]->total;
                });
                $pria = $akt->sum(function ($i) use ($tm) {
                    $ue = collect($i->tahun_masuk)->filter(function ($h) use ($tm) {
                        return $h->tahun == $tm;
                    })->values();
                    return $ue[0]->pria;
                });
                $wanita = $akt->sum(function ($i) use ($tm) {
                    $ue = collect($i->tahun_masuk)->filter(function ($h) use ($tm) {
                        return $h->tahun == $tm;
                    })->values();
                    return $ue[0]->wanita;
                });
                $tahun_masuk_chart_value->push($sum);
                $tahun_masuk_tabel->push([
                    "tahun" => $tm,
                    "pria" => $pria,
                    "wanita" => $wanita,
                    "total" => $sum
                ]);
            }

            //Mendefinisikan Jalur Masuk
            $jalur_masuk_chart_label = collect($akt[0]->jalur_masuk)->values()->pluck('jalur')->toArray();
            $jalur_masuk_chart_value = collect();
            $jalur_masuk_tabel = collect();
            foreach ($jalur_masuk_chart_label as $jm) {

                $sum = $akt->sum(function ($i) use ($jm) {
                    $ue = collect($i->jalur_masuk)->values()->filter(function ($h) use ($jm) {
                        return $h->jalur == $jm;
                    })->values();
                    return $ue[0]->total;
                });
                $pria = $akt->sum(function ($i) use ($jm) {
                    $ue = collect($i->jalur_masuk)->values()->filter(function ($h) use ($jm) {
                        return $h->jalur == $jm;
                    })->values();
                    return $ue[0]->cowo;
                });
                $wanita = $akt->sum(function ($i) use ($jm) {
                    $ue = collect($i->jalur_masuk)->values()->filter(function ($h) use ($jm) {
                        return $h->jalur == $jm;
                    })->values();
                    return $ue[0]->cewe;
                });

                $jalur_masuk_chart_value->push($sum);
                $jalur_masuk_tabel->push([
                    "jalur" => $jm,
                    "cowo" => $pria,
                    "cewe" => $wanita,
                    "total" => $sum
                ]);
            }

            //Mendefinisikan Jenis Kelamin Berdasarkan Unit
            $jenis_kelamin_chart_value_pria = 0;
            $jenis_kelamin_chart_value_wanita = 0;
            $jenis_kelamin_chart_tabel = collect();

            if ($fk != 0) {
                $df = Prodi::where('fakultas', $fk)->get();
                foreach ($df as $d) {
                    $b = $akt->where('kode_prodi', $d->kode)->first();
                    $jenis_kelamin_chart_value_pria += $b->jenis_kelamin->pria;
                    $jenis_kelamin_chart_value_wanita += $b->jenis_kelamin->wanita;

                    $jenis_kelamin_chart_tabel->push([
                        "unit" => $d->nama,
                        "pria" => $b->jenis_kelamin->pria,
                        "wanita" => $b->jenis_kelamin->wanita,
                        "total" => $b->jenis_kelamin->total,
                    ]);
                }

            }else{
                $df = Faculty::all();
                foreach ($df as $d) {

                    $b = $akt->where('fakultas', $d->code);
                    $jk_p = 0;
                    $jk_w = 0;

                    foreach ($b as $bp) {
                        $jenis_kelamin_chart_value_pria += $bp->jenis_kelamin->pria;
                        $jenis_kelamin_chart_value_wanita += $bp->jenis_kelamin->wanita;
                        $jk_p += $bp->jenis_kelamin->pria;
                        $jk_w += $bp->jenis_kelamin->wanita;
                    };

                    $jenis_kelamin_chart_tabel->push([
                        "unit" => $d->name,
                        "pria" => $jk_p,
                        "wanita" => $jk_w,
                        "total" => $jk_p + $jk_w,
                    ]);
                }
            }

            //Mendefinisikan IPK
            $ipk_chart_label = collect(['0.00 - 2.00', '2.01 - 2.50', '2.51 - 3.00', '3.01 - 3.50', '3.51 - 4.00']);
            $ipk_chart_value = collect();
            $coll_for_ipk = collect(['a', 'b', 'c', 'd', 'e']);
            foreach ($coll_for_ipk as $index => $ci) {

                $sum = $akt->sum(function ($i) use ($ci) {
                    return $i->ipk->$ci;
                });

                $ipk_chart_value->push($sum);
            }

            //Chart Utama
            if ($fk != 0) {
                $chart_utama = [
                    "total" => $akt->sum('total'),
                    "label" => $akt->pluck('prodi.nama')->toArray(),
                    "value" => $akt->pluck('total')->toArray(),
                ];
            }else{
                $chart_utama = [
                    "total" => $akt->sum('total'),
                    "label" => $akt->groupBy('fakultas')->map(function($i){
                        return $i[0]['faculty']['name'];
                    })->values(),
                    "value" => $akt->groupBy('fakultas')->map(function($i){
                        return $i->sum('total');
                    })->values(),
                ];
            }

            return response()->json([
                "chart" => $chart_utama,
                "data" => [
                    "tahun_masuk" => [
                        "chart" => [
                            "label" => $tahun_masuk_chart_label,
                            "value" => $tahun_masuk_chart_value,
                        ],
                        "tabel" => $tahun_masuk_tabel,
                    ],
                    "jalur_masuk" => [
                        "chart" => [
                            "label" => $jalur_masuk_chart_label,
                            "value" => $jalur_masuk_chart_value,
                        ],
                        "tabel" => $jalur_masuk_tabel,
                    ],
                    "jenis_kelamin" => [
                        "chart" => [
                            "label" => ['Laki-Laki', 'Perempuan'],
                            "value" => [$jenis_kelamin_chart_value_pria, $jenis_kelamin_chart_value_wanita],
                        ],
                        "tabel" => $jenis_kelamin_chart_tabel,
                    ],
                    "ipk" => [
                        "chart" => [
                            "label" => $ipk_chart_label,
                            "value" => $ipk_chart_value,
                        ],
                        "tabel" => $ipk_chart_value
                    ]
                ]
            ], 200);
        }
    }


    // public function mahasiswa_aktif_get(Request $request)
    // {
    //     $status = $request->status;
    //     $fakultas = $request->fakultas;
    //     $periode = Str::substr($request->tahun, 0, 4);
    //     $semester = Str::substr($request->tahun, 4, 1);
    //     $jenjang = $request->jenjang;

    //     $data = [];

    //     // Query data dengan filter fakultas dan jenjang sesuai parameter
    //     $query = Faculty::query();
    //     if ($fakultas != 0) {
    //         $query->where('code', $fakultas);
    //     }
    //     $query->with('prodi');
    //     $data = $query->get();

    //     $aktivitas = StatusMahasiswa::where('status', $status)->where('tahun', $periode)->where('semester', $semester)->with(['mahasiswa' => function ($query) {
    //         return $query->with('prodi');
    //     }])->get();

    //     if ($jenjang != null) {
    //         $aktivitas = $aktivitas->filter(function ($item) use ($jenjang) {
    //             return $item->mahasiswa->prodi->jenjang == $jenjang;
    //         });
    //     }

    //     $aktivitas = $aktivitas->filter(function ($i) {
    //         return isset($i->mahasiswa->prodi->jenjang);
    //     });

    //     //Filter mahasiswa lulus pada semeseter dan periode khusus mahasiswa aktif
    //     if ($status == 'aktif') {

    //         $aktivitas = $aktivitas->filter(function ($i) use ($periode, $semester) {

    //             if ($i->mahasiswa['tanggal_yudisium'] == null || $i->mahasiswa['tanggal_yudisium'] == 0) {
    //                 return $i;
    //             }

    //             $tanggalLulus = Carbon::parse($i->mahasiswa['tanggal_yudisium']);
    //             $tanggalMulaiAjaran = Carbon::create($periode, 9, 1);
    //             $tanggalAkhirAjaran = Carbon::create($periode + 1, 1, 31);

    //             if ($semester == 2) {
    //                 $tanggalMulaiAjaran = Carbon::create($periode + 1, 2, 1);
    //                 $tanggalAkhirAjaran = Carbon::create($periode + 1, 8, 31);
    //             }

    //             if ($tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran)) {
    //                 return false;
    //             }

    //             return $i;
    //         });
    //     }

    //     $data_status = $this->hitung_data('universitas', $aktivitas, $periode, $data);
    //     $total_status = $aktivitas->count();

    //     foreach ($data as $d) {
    //         $d['status'] = $this->hitung_data('fakultas', $aktivitas, $periode, $d);
    //         $d['total_status_mahasiswa'] = $aktivitas->filter(function ($i) use ($d) {
    //             return $i->mahasiswa->prodi->fakultas == $d->code;
    //         })->count();
    //         $prodi = $d['prodi'];
    //         foreach ($prodi as $p) {
    //             $p['nama'] = Str::upper($p['nama']);
    //             $p['status'] = $this->hitung_data('prodi', $aktivitas, $periode, $p);
    //             $p['total_status_mahasiswa'] = $aktivitas->filter(function ($i) use ($p) {
    //                 return $i->mahasiswa->prodi->kode == $p->kode;
    //             })->count();
    //         }
    //     }

    //     //Kemabalikan dalam bentuk JSON
    //     return response()->json(['data' => $data->all(), 'status' => $data_status, 'total_status_mahasiswa' => $total_status], 200);
    // }

    // //Internal fungsi untuk menghitung
    // private function hitung_data($tipe, $aktivitas, $periode, $data)
    // {
    //     $a = $aktivitas;
    //     if ($tipe == 'fakultas') {
    //         $a = $aktivitas->filter(function ($i) use ($data) {
    //             return $i->mahasiswa->prodi->fakultas == $data->code;
    //         });
    //     } else if ($tipe == 'prodi') {
    //         $a = $aktivitas->filter(function ($i) use ($data) {
    //             return $i->mahasiswa->prodi->kode == $data->kode;
    //         });
    //     }

    //     //Tahun Angkatan
    //     $tahun_angkatan = collect([$periode - 6, $periode - 5, $periode - 4, $periode - 3, $periode - 2, $periode - 1, $periode - 0]);
    //     $angkatan = collect();

    //     foreach ($tahun_angkatan as $t) {
    //         $angkatan->push([
    //             'tahun' => $t,
    //             'pria' => $a->filter(function ($i) use ($t) {
    //                 return $i->mahasiswa->tahun_masuk == $t && $i->mahasiswa->kelamin == 1;
    //             })->count(),
    //             'wanita' => $a->filter(function ($i) use ($t) {
    //                 return $i->mahasiswa->tahun_masuk == $t && $i->mahasiswa->kelamin == 0;
    //             })->count(),
    //             'total' => $a->filter(function ($i) use ($t) {
    //                 return $i->mahasiswa->tahun_masuk == $t;
    //             })->count(),
    //         ]);
    //     }

    //     //Jalur Masuk
    //     $jalur = [];
    //     $j = collect(['snmptn', 'sbmptn', 'smmptn', 'lainnya']);
    //     foreach ($j as $item) {
    //         $jalur[$item] = [
    //             'jalur' => $item,
    //             'cowo' => $a->filter(function ($i) use ($item) {
    //                 return $i->mahasiswa->jalur_masuk == $item && $i->mahasiswa->kelamin == 1;
    //             })->count(),
    //             'cewe' => $a->filter(function ($i) use ($item) {
    //                 return $i->mahasiswa->jalur_masuk == $item && $i->mahasiswa->kelamin == 0;
    //             })->count(),
    //             'total' => $a->filter(function ($i) use ($item) {
    //                 return $i->mahasiswa->jalur_masuk == $item;
    //             })->count(),
    //         ];
    //     }

    //     //Jenis Kelamin
    //     $kelamin = collect(
    //         [
    //             'pria' => $a->filter(function ($i) use ($item) {
    //                 return $i->mahasiswa->kelamin == 1;
    //             })->count(),
    //             'wanita' => $a->filter(function ($i) use ($item) {
    //                 return $i->mahasiswa->kelamin == 0;
    //             })->count(),
    //             'total' => $a->count(),
    //         ]
    //     );

    //     //IPK
    //     $ipk = collect(
    //         [
    //             'a' => $a->filter(function ($i) {
    //                 return $i->ipk <= 2;
    //             })->count(),
    //             'b' => $a->filter(function ($i) {
    //                 return $i->ipk > 2 && $i->ipk <= 2.5;
    //             })->count(),
    //             'c' => $a->filter(function ($i) {
    //                 return $i->ipk > 2.5 && $i->ipk <= 3;
    //             })->count(),
    //             'd' => $a->filter(function ($i) {
    //                 return $i->ipk > 3 && $i->ipk <= 3.5;
    //             })->count(),
    //             'e' => $a->filter(function ($i) {
    //                 return $i->ipk > 3.5 && $i->ipk <= 4;
    //             })->count(),
    //         ]
    //     );

    //     $m = collect([
    //         'angkatan' => $angkatan,
    //         'jalurmasuk' => $jalur,
    //         'jeniskelamin' => $kelamin,
    //         'ipk' => $ipk,
    //     ]);

    //     return $m;
    // }
}
