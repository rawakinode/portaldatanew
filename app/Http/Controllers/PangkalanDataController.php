<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Traits\PangkalanDataTrait;
use App\Traits\StatusPeriodeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PangkalanDataController extends Controller
{
    use StatusPeriodeTrait;
    use PangkalanDataTrait;

    public function index()
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $periode = $this->cekperiode();

        if ($periode == false) {abort(403, "Periode Tidak Ditemukan");}

        $mahasiswa = Mahasiswa::whereTahun($periode)->whereKodeProdi($kodeprodi)->first();

        $dosen = Dosen::whereTahun($periode)->whereKode($kodeprodi)->get();

        return view('admin.profil.data', ['mahasiswa'=>$mahasiswa, 'dosen'=>$dosen]);
        
    }

    public function store(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');
        
        $rules = [
            'baru' => 'nullable|integer|max:10000',
            'aktif' => 'nullable|integer|max:10000',
            'nonaktif' => 'nullable|integer|max:10000',
            'cuti' => 'nullable|integer|max:10000',
            'lulus' => 'nullable|integer|max:10000',
            'tepat_waktu' => 'nullable|integer|max:10000',
            'bidikmisi' => 'nullable|integer|max:10000',
            'tugas_akhir' => 'nullable|integer|max:10000',
        ];

        $validasi = $request->validate($rules);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $periode = $this->cekperiode();

        $mahasiswa = Mahasiswa::whereTahun($periode)->whereKodeProdi($kodeprodi)->first();

        if (!$mahasiswa) {
            $validasi['tahun'] = $periode;
            $validasi['kode_prodi'] = $kodeprodi;

            DB::transaction(function () use ($validasi,$request,$mahasiswa) {
                $validasi = $this->uploadMahasiswaDokumen($validasi, $request, $mahasiswa);
                Mahasiswa::create($validasi);
            });
        } else {
            DB::transaction(function () use ($validasi,$request,$mahasiswa){
                $validasi = $this->uploadMahasiswaDokumen($validasi, $request, $mahasiswa);
                $mahasiswa->update($validasi);
            }); 
        }
        
        return redirect()->back()->with('success', 'Berhasil menyimpan data.');
    }

}
