<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\StatusMahasiswa;
use Illuminate\Http\Request;

class StatusMahasiswaController extends Controller
{
    public function index()
    {
        //Sementara
        $tahun = request('tahun');
        $semester = request('semester');
        $angkatan = request('angkatan');

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        //Get data mahasiswa dengan relasi ke tabel status mahasiswa
        if (request('tahun') && request('semester')) {

            if (strlen($tahun) === 4 && ctype_digit($tahun)) {
                if (request('angkatan')) {
                    $mahasiswa = Mahasiswa::whereKodeProdi($kodeprodi)->whereDaftarUlang(1)->whereNotNull('nim')->where('status_keluar', '=', NULL)->where('tahun_masuk', $angkatan)->orderBy('nim', 'ASC')->with(['status_mahasiswa' => function ($query) use ($tahun, $semester){
                        $query->whereTahun($tahun)->whereSemester($semester);
                    }])->get();

                }else{
                    $mahasiswa = Mahasiswa::whereKodeProdi($kodeprodi)->whereDaftarUlang(1)->whereNotNull('nim')->where('status_keluar', '=', null)->where('tahun_masuk', '<=', $tahun)->orderBy('nim', 'ASC')->with(['status_mahasiswa' => function ($query) use ($tahun, $semester){
                        $query->whereTahun($tahun)->whereSemester($semester);
                    }])->get();
                }
            } else{
                $mahasiswa = collect();
            }

            
            
        }else{
            $mahasiswa = collect();
        }


        return view('admin.pangkalan.status_mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('admin.pangkalan.status_mahasiswa.create');
    }

    public function store(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];

        $rules = [
            'id.*' => 'required|integer',
            'tahun.*' => 'required|integer|digits:4',
            'semester.*' => 'required|in:1,2,3',
            'status.*' => 'nullable|in:aktif,nonaktif,cuti',
            'ipk.*' => 'nullable|numeric|max:4',
            'sks.*' => 'nullable|integer',
        ];

        $request->validate($rules);

        for ($i=0; $i < count($request->id); $i++) { 
            $finds = StatusMahasiswa::whereMahasiswaId($request->id[$i])->whereKodeProdi($kodeprodi)->whereTahun($request->thn)->whereSemester($request->sms)->first();

            if ($finds) {

                if ($request->status[$i] == null) {
                    $finds->delete();
                }else{
                    $finds->update([
                        'ipk' => $request->ipk[$i],
                        'sks' => $request->sks[$i],
                        'status' => $request->status[$i],
                    ]);
                }
                
            }else{
                if ($request->status[$i] != null) {
                    StatusMahasiswa::create([
                        'kode_prodi' => $kodeprodi,
                        'mahasiswa_id' => $request->id[$i],
                        'tahun' => $request->thn,
                        'semester' => $request->sms,
                        'ipk' => $request->ipk[$i] ?? NULL,
                        'sks' => $request->sks[$i] ?? NULL,
                        'status' => $request->status[$i] ?? NULL,
                    ]);
                }
                
            }  
        }

        return redirect()->back()->with('success', 'Berhasil menyimpan status perkuliahan mahasiswa..');
    }
}
