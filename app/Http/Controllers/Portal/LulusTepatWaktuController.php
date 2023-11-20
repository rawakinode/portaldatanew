<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Faculty;
use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\Prodi;
use Carbon\Carbon;

class LulusTepatWaktuController extends Controller
{
    public function index()
    {
        return view('portaldata.lulus_tepat_waktu');
    }

    public function get_data(Request $request)
    {

        $periode = $request->tahun;
        $fakultas = $request->fakultas;
        $prodi = $request->prodi;


        if ($prodi != null) {

            $ps = Prodi::where('id', $prodi)->first();

            $mahasiswa_lulus = Mahasiswa::where('kode_prodi', $ps->kode)
                ->where('status_keluar', 'lulus')
                ->whereNotNull('tanggal_yudisium')
                ->get();

            $mahasiswa_lulus_periode = $mahasiswa_lulus->filter(function ($i) use ($periode) {

                $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                $tanggalMulaiAjaran = Carbon::create($periode, 9, 1);
                $tanggalAkhirAjaran = Carbon::create($periode + 1, 8, 31);

                return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
            });

            $mahasiswa_lulus_periode_tepat_waktu = $mahasiswa_lulus_periode->filter(function ($i) use ($periode) {
                $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                $tanggalMulaiAjaran = Carbon::create($periode - 4, 9, 1);
                $tanggalAkhirAjaran = Carbon::create($periode + 1, 8, 31);
                return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
            });

            $malutewa = $mahasiswa_lulus_periode_tepat_waktu;

            // Data By Tahun Masuk
            $tahun_masuk_label = collect();
            $tahun_masuk_value = collect();
            $tahun_masuk_table = collect();

            for ($i = 0; $i < 4; $i++) {
                $tahun_masuk_label->push($periode - $i);
                $pria = $malutewa->where('tahun_masuk', $periode - $i)->where('kelamin', 0)->count();
                $wanita = $malutewa->where('tahun_masuk', $periode - $i)->where('kelamin', 1)->count();
                $tahun_masuk_value->push($pria + $wanita);
                $tahun_masuk_table->push([
                    "tahun" => $periode - $i,
                    "pria" => $pria,
                    "wanita" => $wanita,
                    "total" => $pria + $wanita,
                ]);
            }

            // Data By Jalur Masuk
            $jalur = collect(['snmptn', 'sbmptn', 'smmptn', 'lainnya']);
            $jalur_masuk_label = collect();
            $jalur_masuk_value = collect();
            $jalur_masuk_table = collect();

            foreach ($jalur as $j) {
                $jalur_masuk_label->push(strtoupper($j));
                $pria = $malutewa->where('jalur_masuk', $j)->where('kelamin', 0)->count();
                $wanita = $malutewa->where('jalur_masuk', $j)->where('kelamin', 1)->count();
                $jalur_masuk_value->push($pria + $wanita);
                $jalur_masuk_table->push([
                    "jalur" => "$j",
                    "pria" => $pria,
                    "wanita" => $wanita,
                    "total" => $pria + $wanita,
                ]);
            }

            // Data By Jenis Kelamin
            $jenis_kelamin_value = collect();
            $jenis_kelamin_table = collect();
            $jk_pria = $malutewa->where('kelamin', 0)->count();
            $jk_wanita = $malutewa->where('kelamin', 1)->count();
            $jenis_kelamin_value->push($jk_pria);
            $jenis_kelamin_value->push($jk_wanita);
            $jenis_kelamin_table->push([
                "unit" => $ps['nama'],
                "pria" => $jk_pria,
                "wanita" => $jk_wanita,
                "total" => $jk_pria + $jk_wanita,
            ]);

            // Data By IPK
            $ipk_label = collect([[0.00, 2.00], [2.01, 2.50], [2.51, 3.00], [3.01, 3.50], [3.51, 4.00]]);
            $ipk_value = collect();
            $ipk_table = collect();

            foreach ($ipk_label as $ib) {
                $jm = $malutewa->filter(function ($i) use ($ib) {
                    return $i->ipk >= $ib[0] && $i->ipk < $ib[1];
                })->count();
                $ipk_value->push($jm);
                $ipk_table->push($jm);
            }

            return response()->json([
                "chart" => [
                    "total" => $malutewa->count(),
                    "label" => [$ps->nama ." ". $ps->jenjang],
                    "value" => [$malutewa->count()],
                ],
                "data" => [
                    "tahun_masuk" => [
                        "chart" => [
                            "label" => $tahun_masuk_label,
                            "value" => $tahun_masuk_value,
                        ],
                        "tabel" => $tahun_masuk_table,
                    ],
                    "jalur_masuk" => [
                        "chart" => [
                            "label" => $jalur_masuk_label,
                            "value" => $jalur_masuk_value,
                        ],
                        "tabel" => $jalur_masuk_table,
                    ],
                    "jenis_kelamin" => [
                        "chart" => [
                            "label" => ['Laki-Laki', 'Perempuan'],
                            "value" => $jenis_kelamin_value,
                        ],
                        "tabel" => $jenis_kelamin_table,
                    ],
                    "ipk" => [
                        "chart" => [
                            "label" => ['0.00 - 2.00', '2.01 - 2.50', '2.51 - 3.00', '3.01 - 3.50', '3.51 - 4.00'],
                            "value" => $ipk_value,
                        ],
                        "tabel" => $ipk_table
                    ]
                ]
            ], 200);
        } else {

            // Mengambil Fakultas
            $fak = Faculty::query();
            if ($fakultas != 0) {
                $fak->where('code', $fakultas);
            }
            $fak->with('prodi');
            $fak = $fak->get();

            //Mengambil Mahasiswa Lulus
            $mahasiswa_lulus = Mahasiswa::query();
            $mahasiswa_lulus->whereIn('tahun_masuk', [$periode, $periode - 1, $periode - 2, $periode - 3]);
            if ($fakultas != 0) {
                $kd_prodi = $fak[0]->prodi->pluck('kode')->toarray();
                $mahasiswa_lulus->whereIn('kode_prodi', $kd_prodi);
            }
            $mahasiswa_lulus->where('status_keluar', 'lulus');
            $mahasiswa_lulus->whereNotNull('tanggal_yudisium');
            $mahasiswa_lulus = $mahasiswa_lulus->get();

            // FIlter mahasiswa lulus sesuai periode yang di tentukan
            $mahasiswa_lulus_periode = $mahasiswa_lulus->filter(function ($i) use ($periode) {

                $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                $tanggalMulaiAjaran = Carbon::create($periode, 9, 1);
                $tanggalAkhirAjaran = Carbon::create($periode + 1, 8, 31);

                return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
            });

            // FIlter mahasiswa lulus tepat waktu sesuai periode yang di tentukan
            $mahasiswa_lulus_periode_tepat_waktu = $mahasiswa_lulus_periode->filter(function ($i) use ($periode) {
                $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                $tanggalMulaiAjaran = Carbon::create($periode - 4, 9, 1);
                $tanggalAkhirAjaran = Carbon::create($periode + 1, 8, 31);
                return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
            });

            $malutewa = $mahasiswa_lulus_periode_tepat_waktu;

            //Data Utama
            $utama_label = collect();
            $utama_value = collect();
            if ($fakultas != 0) {
                foreach ($fak[0]->prodi as $pd) {
                    $va = $malutewa->where('kode_prodi', $pd->kode)->count();
                    $utama_label->push($pd->nama ." ". $pd->jenjang);
                    $utama_value->push($va);
                }
            }else{
                foreach ($fak as $fk) {
                    $pp = collect();
                    foreach ($fk->prodi as $pdi) {
                        $pp->push($pdi->kode);
                    }
                    $va = $malutewa->whereIn('kode_prodi', $pp)->count();
                    $lb = $fk->name;
    
                    $utama_label->push($lb);
                    $utama_value->push($va);
                }
            }
            

            // Data By Tahun Masuk
            $tahun_masuk_label = collect();
            $tahun_masuk_value = collect();
            $tahun_masuk_table = collect();

            for ($i = 0; $i < 4; $i++) {
                $tahun_masuk_label->push($periode - $i);
                $pria = $malutewa->where('tahun_masuk', $periode - $i)->where('kelamin', 0)->count();
                $wanita = $malutewa->where('tahun_masuk', $periode - $i)->where('kelamin', 1)->count();
                $tahun_masuk_value->push($pria + $wanita);
                $tahun_masuk_table->push([
                    "tahun" => $periode - $i,
                    "pria" => $pria,
                    "wanita" => $wanita,
                    "total" => $pria + $wanita,
                ]);
            }

            // Data By Jalur Masuk
            $jalur = collect(['snmptn', 'sbmptn', 'smmptn', 'lainnya']);
            $jalur_masuk_label = collect();
            $jalur_masuk_value = collect();
            $jalur_masuk_table = collect();

            foreach ($jalur as $j) {
                $jalur_masuk_label->push(strtoupper($j));
                $pria = $malutewa->where('jalur_masuk', $j)->where('kelamin', 0)->count();
                $wanita = $malutewa->where('jalur_masuk', $j)->where('kelamin', 1)->count();
                $jalur_masuk_value->push($pria + $wanita);
                $jalur_masuk_table->push([
                    "jalur" => "$j",
                    "pria" => $pria,
                    "wanita" => $wanita,
                    "total" => $pria + $wanita,
                ]);
            }

            // Data By Jenis Kelamin
            $jenis_kelamin_value = collect();
            $jenis_kelamin_table = collect();
            $jk_pria = $malutewa->where('kelamin', 0)->count();
            $jk_wanita = $malutewa->where('kelamin', 1)->count();
            $jenis_kelamin_value->push($jk_pria);
            $jenis_kelamin_value->push($jk_wanita);
            $jenis_kelamin_table->push([
                "pria" => $jk_pria,
                "wanita" => $jk_wanita,
                "total" => $jk_pria + $jk_wanita,
            ]);

            // Data By IPK
            $ipk_label = collect([[0.00, 2.00], [2.01, 2.50], [2.51, 3.00], [3.01, 3.50], [3.51, 4.00]]);
            $ipk_value = collect();
            $ipk_table = collect();

            foreach ($ipk_label as $ib) {
                $jm = $malutewa->filter(function ($i) use ($ib) {
                    return $i->ipk >= $ib[0] && $i->ipk < $ib[1];
                })->count();
                $ipk_value->push($jm);
                $ipk_table->push($jm);
            }

            return response()->json([
                "chart" => [
                    "total" => $malutewa->count(),
                    "label" => $utama_label,
                    "value" => $utama_value,
                ],
                "data" => [
                    "tahun_masuk" => [
                        "chart" => [
                            "label" => $tahun_masuk_label,
                            "value" => $tahun_masuk_value,
                        ],
                        "tabel" => $tahun_masuk_table,
                    ],
                    "jalur_masuk" => [
                        "chart" => [
                            "label" => $jalur_masuk_label,
                            "value" => $jalur_masuk_value,
                        ],
                        "tabel" => $jalur_masuk_table,
                    ],
                    "jenis_kelamin" => [
                        "chart" => [
                            "label" => ['Laki-Laki', 'Perempuan'],
                            "value" => $jenis_kelamin_value,
                        ],
                        "tabel" => $jenis_kelamin_table,
                    ],
                    "ipk" => [
                        "chart" => [
                            "label" => ['0.00 - 2.00', '2.01 - 2.50', '2.51 - 3.00', '3.01 - 3.50', '3.51 - 4.00'],
                            "value" => $ipk_value,
                        ],
                        "tabel" => $ipk_table
                    ]
                ]
            ], 200);
        }
    }
}
