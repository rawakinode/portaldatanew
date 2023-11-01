<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Periode;
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
        $query->with('prodi');
        $data = $query->get();

        $aktivitas = StatusMahasiswa::where('status', $status)->where('tahun', $periode)->where('semester', $semester)->with(['mahasiswa' => function ($query) {
            return $query->with('prodi');
        }])->get();

        if ($jenjang != null) {
            $aktivitas = $aktivitas->filter(function ($item) use ($jenjang) {
                return $item->mahasiswa->prodi->jenjang == $jenjang;
            });
        }

        $aktivitas = $aktivitas->filter(function($i){
            return isset($i->mahasiswa->prodi->jenjang);
        });

        //Filter mahasiswa lulus pada semeseter dan periode khusus mahasiswa aktif
        if ($status == 'aktif') {

            $aktivitas = $aktivitas->filter(function($i) use ($periode, $semester){

                if ($i->mahasiswa['tanggal_yudisium'] == null || $i->mahasiswa['tanggal_yudisium'] == 0) {
                    return $i;
                }

                $tanggalLulus = Carbon::parse($i->mahasiswa['tanggal_yudisium']);
                $tanggalMulaiAjaran = Carbon::create($periode, 9, 1);
                $tanggalAkhirAjaran = Carbon::create($periode + 1, 1, 31);

                if ($semester == 2) {
                    $tanggalMulaiAjaran = Carbon::create($periode + 1, 2, 1);
                    $tanggalAkhirAjaran = Carbon::create($periode + 1, 8, 31);
                }

                if ($tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran)) {
                    return false;
                }

                return $i;

            });
        }

        $data_status = $this->hitung_data('universitas', $aktivitas, $periode, $data);
        $total_status = $aktivitas->count();

        foreach ($data as $d) {
            $d['status'] = $this->hitung_data('fakultas', $aktivitas, $periode, $d);
            $d['total_status_mahasiswa'] = $aktivitas->filter(function ($i) use ($d) {
                return $i->mahasiswa->prodi->fakultas == $d->code;
            })->count();
            $prodi = $d['prodi'];
            foreach ($prodi as $p) {
                $p['nama'] = Str::upper($p['nama']);
                $p['status'] = $this->hitung_data('prodi', $aktivitas, $periode, $p);
                $p['total_status_mahasiswa'] = $aktivitas->filter(function ($i) use ($p) {
                    return $i->mahasiswa->prodi->kode == $p->kode;
                })->count();
            }
        }

        //Kemabalikan dalam bentuk JSON
        return response()->json(['data' => $data->all(), 'status' => $data_status, 'total_status_mahasiswa' => $total_status], 200);
    }

        //Internal fungsi untuk menghitung
        private function hitung_data($tipe, $aktivitas, $periode, $data)
        {
            $a = $aktivitas;
            if ($tipe == 'fakultas') {
                $a = $aktivitas->filter(function ($i) use ($data) {
                    return $i->mahasiswa->prodi->fakultas == $data->code;
                });
            } else if ($tipe == 'prodi') {
                $a = $aktivitas->filter(function ($i) use ($data) {
                    return $i->mahasiswa->prodi->kode == $data->kode;
                });
            }
    
            //Tahun Angkatan
            $tahun_angkatan = collect([$periode - 6, $periode - 5, $periode - 4, $periode - 3, $periode - 2, $periode - 1, $periode - 0]);
            $angkatan = collect();
    
            foreach ($tahun_angkatan as $t) {
                $angkatan->push([
                    'tahun' => $t,
                    'pria' => $a->filter(function ($i) use ($t) {
                        return $i->mahasiswa->tahun_masuk == $t && $i->mahasiswa->kelamin == 1;
                    })->count(),
                    'wanita' => $a->filter(function ($i) use ($t) {
                        return $i->mahasiswa->tahun_masuk == $t && $i->mahasiswa->kelamin == 0;
                    })->count(),
                    'total' => $a->filter(function ($i) use ($t) {
                        return $i->mahasiswa->tahun_masuk == $t;
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
                        return $i->mahasiswa->jalur_masuk == $item && $i->mahasiswa->kelamin == 1;
                    })->count(),
                    'cewe' => $a->filter(function ($i) use ($item) {
                        return $i->mahasiswa->jalur_masuk == $item && $i->mahasiswa->kelamin == 0;
                    })->count(),
                    'total' => $a->filter(function ($i) use ($item) {
                        return $i->mahasiswa->jalur_masuk == $item;
                    })->count(),
                ];
            }
    
            //Jenis Kelamin
            $kelamin = collect(
                [
                    'pria' => $a->filter(function ($i) use ($item) {
                        return $i->mahasiswa->kelamin == 1;
                    })->count(),
                    'wanita' => $a->filter(function ($i) use ($item) {
                        return $i->mahasiswa->kelamin == 0;
                    })->count(),
                    'total' => $a->count(),
                ]
            );
    
            //IPK
            $ipk = collect(
                [
                    'a' => $a->filter(function($i){
                        return $i->ipk <= 2;
                    })->count(), 
                    'b' => $a->filter(function($i){
                        return $i->ipk > 2 && $i->ipk <= 2.5;
                    })->count(), 
                    'c' => $a->filter(function($i){
                        return $i->ipk > 2.5 && $i->ipk <= 3;
                    })->count(), 
                    'd' => $a->filter(function($i){
                        return $i->ipk > 3 && $i->ipk <= 3.5;
                    })->count(), 
                    'e' => $a->filter(function($i){
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
