<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SertifikasiAkreditasiExternal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SertifikasiAkreditasiExternalController extends Controller
{
    public function index()
    {

        $akreditasi = SertifikasiAkreditasiExternal::all();

        return view('admin.administrator.akreditasi.index', compact('akreditasi'));
    }

    public function create()
    {
        return view('admin.administrator.akreditasi.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'lembaga' => 'required|string|max:200',
            'keterangan' => 'nullable|string|max:200',
            'tahun_berakhir' => 'required|integer|digits:4',
            'jenis' => 'required|in:akreditasi,sertifikasi',
            'lingkup' => 'required|in:perguruan tinggi,fakultas,prodi',
            'tingkat' => 'required|in:nasional,internasional',
        ];

        $validasi = $request->validate($rules);

        DB::transaction(function () use ($validasi) {
            SertifikasiAkreditasiExternal::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan data.');
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'lembaga' => 'required|string|max:200',
            'keterangan' => 'nullable|string|max:200',
            'tahun_berakhir' => 'required|integer|digits:4',
            'jenis' => 'required|in:akreditasi,sertifikasi',
            'lingkup' => 'required|in:perguruan tinggi,fakultas,prodi',
            'tingkat' => 'required|in:nasional,internasional',
        ];

        $validasi = $request->validate($rules);

        $data = SertifikasiAkreditasiExternal::findOrFail($ids);

        DB::transaction(function () use ($validasi, $data) {
            $data->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui data.');
    }

    public function edit($ids)
    {
        $akreditasi = SertifikasiAkreditasiExternal::findOrFail($ids);
        
        return view('admin.administrator.akreditasi.edit', compact('akreditasi'));
    }

    public function destroy(Request $request)
    {
        $data = SertifikasiAkreditasiExternal::findOrFail($request->id);
        
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus data.');
    }
}
