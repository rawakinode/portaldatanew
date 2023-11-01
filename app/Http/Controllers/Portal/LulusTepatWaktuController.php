<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Faculty;
use App\Models\Mahasiswa;
use App\Models\Periode;
use Carbon\Carbon;

class LulusTepatWaktuController extends Controller
{
    public function index()
    {
        return view('portaldata.lulus_tepat_waktu');
    }

    public function get_data(Request $request)
    {

        $fakultas = $request->fakultas;
        $jenjang = $request->jenjang;

        $data = [];

        //Atur periode dan ts
        $per = Periode::where('status', 1)->first();
        $periode = $per['tahun'];

        // Query data dengan filter fakultas dan jenjang sesuai parameter
        $query = Faculty::query();
        if ($fakultas != 0) {
            $query->where('code', $fakultas);
        }
        $query->with('prodi');
        $data = $query->get();

        $mahasiswa = Mahasiswa::where('status_keluar', 'lulus')->with('prodi')->get();

        $mahasiswa = $mahasiswa->filter(function ($i) {

            if ($i['tanggal_yudisium'] == null || $i['tanggal_yudisium'] == 0) {
                return false;
            }
            $tahun_masuk = $i['tahun_masuk'];
            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
            $tanggalBatas = Carbon::create($tahun_masuk + 4, 8, 31);
        
            return $tanggalLulus->lte($tanggalBatas);

        })->values();


        $data_status = $this->hitung_data('universitas', $mahasiswa, $periode, $data);
        $total_lulus = $mahasiswa->count();

        foreach ($data as $d) {
            $d['status'] = $this->hitung_data('fakultas', $mahasiswa, $periode, $d);
            $d['total_lulus_mahasiswa'] = $mahasiswa->filter(function ($i) use ($d) {
                return $i->prodi->fakultas == $d->code;
            })->count();
            $prodi = $d['prodi'];
            
            foreach ($prodi as $p) {
                $p['nama'] = Str::upper($p['nama']);
                $p['status'] = $this->hitung_data('prodi', $mahasiswa, $periode, $p);
                $p['total_lulus_mahasiswa'] = $mahasiswa->filter(function ($i) use ($p) {
                    return $i->prodi->kode == $p->kode;
                })->count();
            }
        }

        //Kemabalikan dalam bentuk JSON
        return response()->json(['data' => $data->all(), 'status' => $data_status, 'total_lulus_mahasiswa' => $total_lulus], 200);
    }

    //Internal fungsi untuk menghitung
    private function hitung_data($tipe, $mahasiswa, $periode, $data)
    {
        $a = $mahasiswa;
        if ($tipe == 'fakultas') {
            $a = $mahasiswa->filter(function ($i) use ($data) {
                return $i->prodi->fakultas == $data->code;
            });
        } else if ($tipe == 'prodi') {
            $a = $mahasiswa->filter(function ($i) use ($data) {
                return $i->prodi->kode == $data->kode;
            });
        }

        //Tahun Angkatan
        $tahun_angkatan = collect([$periode - 6, $periode - 5, $periode - 4, $periode - 3, $periode - 2, $periode - 1, $periode - 0]);
        $angkatan = collect();

        foreach ($tahun_angkatan as $t) {
            $angkatan->push([
                'tahun' => $t,
                'pria' => $a->filter(function ($i) use ($t) {
                    return $i->tahun_masuk == $t && $i->kelamin == 1;
                })->count(),
                'wanita' => $a->filter(function ($i) use ($t) {
                    return $i->tahun_masuk == $t && $i->kelamin == 0;
                })->count(),
                'total' => $a->filter(function ($i) use ($t) {
                    return $i->tahun_masuk == $t;
                })->count(),
            ]);
        }

        //Jalur Masuk
        $jalur = [];
        $j = collect(['snmptn', 'sbmptn', 'smmptn', 'lainnya']);
        foreach ($j as $item) {
            $jalur[$item] = [
                'jalur' => $item,
                'cowo' => $a->filter(function ($i) use ($item) {
                    return $i->jalur_masuk == $item && $i->kelamin == 1;
                })->count(),
                'cewe' => $a->filter(function ($i) use ($item) {
                    return $i->jalur_masuk == $item && $i->kelamin == 0;
                })->count(),
                'total' => $a->filter(function ($i) use ($item) {
                    return $i->jalur_masuk == $item;
                })->count(),
            ];
        }

        //Jenis Kelamin
        $kelamin = collect(
            [
                'pria' => $a->filter(function ($i) use ($item) {
                    return $i->kelamin == 1;
                })->count(),
                'wanita' => $a->filter(function ($i) use ($item) {
                    return $i->kelamin == 0;
                })->count(),
                'total' => $a->count(),
            ]
        );

        //IPK
        $ipk = collect(
            [
                'a' => $a->filter(function ($i) {
                    return $i->ipk <= 2;
                })->count(),
                'b' => $a->filter(function ($i) {
                    return $i->ipk > 2 && $i->ipk <= 2.5;
                })->count(),
                'c' => $a->filter(function ($i) {
                    return $i->ipk > 2.5 && $i->ipk <= 3;
                })->count(),
                'd' => $a->filter(function ($i) {
                    return $i->ipk > 3 && $i->ipk <= 3.5;
                })->count(),
                'e' => $a->filter(function ($i) {
                    return $i->ipk > 3.5 && $i->ipk <= 4;
                })->count(),
            ]
        );

        $m = collect([
            'angkatan' => $angkatan,
            'jalurmasuk' => $jalur,
            'jeniskelamin' => $kelamin,
            'ipk' => $ipk,
        ]);

        return $m;
    }
}
