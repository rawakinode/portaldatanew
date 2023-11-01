<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use App\Traits\ProfilTrait;
use App\Traits\StatusPeriodeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    use StatusPeriodeTrait;
    use ProfilTrait;

    public function index()
    {
        //Permission Role Set
        $this->authorize('view profil');
        
        $periode = $this->cekperiode();

        if ($periode == false) {abort(403, "Periode Tidak Ditemukan");}

        $profil = auth()->user()->prodi->profil;

        return view('admin.profil.profil', ['profil' => $profil]);
    }

    public function store(Request $request)
    {
        //Permission Role Set
        $this->authorize('input profil');

        $rules = [
            'akreditasi' => 'nullable|integer',
            'nomor_sk' => 'nullable|string|max:50',
            'berlaku_start' => 'nullable|date',
            'berlaku_end' => 'nullable|date',
            'nilai' => 'nullable|integer',
            'sk_akreditasi' => 'nullable|max:10000|mimes:pdf',
            'lembaga' => 'nullable|string|max:50',
            'akreditasi_internasional' => 'nullable|boolean',
            'berlaku_internasional' => 'nullable|date',
            'sk_akreditasi_internasional' => 'nullable|max:10000|mimes:pdf',
            'lembaga_internasional' => 'nullable|string|max:50',
        ];

        $validasi = $request->validate($rules);

        //Cek kode Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        //Cek apakah profil sudah ada
        $profil = Profil::where('kode', $kodeprodi)->first();

        if (!$profil) {
            $validasi['kode'] = $kodeprodi;
            DB::transaction(function () use ($validasi, $request) {
                $validasi = $this->uploadDokumen($validasi, $request);
                Profil::create($validasi);
            });

        }else {
            DB::transaction(function () use ($profil, $validasi, $request) {
                $validasi = $this->hapusUploadProfil($profil, $request, $validasi);
                $validasi = $this->uploadDokumen($validasi, $request);
                $profil->update($validasi); 
            }); 
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbaharui.');
    }
}
