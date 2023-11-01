<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SeleksiMahasiswaBaru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeleksiMahasiswaBaruController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $seleksi_mahasiswa_baru = SeleksiMahasiswaBaru::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.seleksi_mahasiswa_baru.index', compact('seleksi_mahasiswa_baru'));
    }

    public function create()
    {
        return view('admin.pangkalan.seleksi_mahasiswa_baru.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'tahun' => 'required|integer|digits:4|unique:seleksi_mahasiswa_barus,tahun',
            'daya_tampung' => 'integer|min:0|max:100000',
            'mahasiswa_mendaftar' => 'integer|min:0|max:100000',
            'mahasiswa_lulus_seleksi' => 'integer|min:0|max:100000',
            'mahasiswa_baru_reguler' => 'integer|min:0|max:100000',
            'mahasiswa_baru_transfer' => 'integer|min:0|max:100000',
            'mahasiswa_aktif_reguler' => 'integer|min:0|max:100000',
            'mahasiswa_aktif_transfer' => 'integer|min:0|max:100000',
            'mahasiswa_aktif_luar_provinsi' => 'integer|min:0|max:100000',
            'mahasiswa_aktif_luar_negeri' => 'integer|min:0|max:100000',
        ];

        $validasi = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            SeleksiMahasiswaBaru::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan data seleksi mahasiswa.');
    }
    
    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $seleksi_mahasiswa_baru = SeleksiMahasiswaBaru::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$seleksi_mahasiswa_baru) { abort(404); }

        return view('admin.pangkalan.seleksi_mahasiswa_baru.edit', compact('seleksi_mahasiswa_baru'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'tahun' => 'required|integer|digits:4',
            'daya_tampung' => 'integer|min:0|max:100000',
            'mahasiswa_mendaftar' => 'integer|min:0|max:100000',
            'mahasiswa_lulus_seleksi' => 'integer|min:0|max:100000',
            'mahasiswa_baru_reguler' => 'integer|min:0|max:100000',
            'mahasiswa_baru_transfer' => 'integer|min:0|max:100000',
            'mahasiswa_aktif_reguler' => 'integer|min:0|max:100000',
            'mahasiswa_aktif_transfer' => 'integer|min:0|max:100000',
            'mahasiswa_aktif_luar_provinsi' => 'integer|min:0|max:100000',
            'mahasiswa_aktif_luar_negeri' => 'integer|min:0|max:100000',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];
        $seleksi_mahasiswa_baru = SeleksiMahasiswaBaru::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$seleksi_mahasiswa_baru) { abort(404); }

        if ($request->tahun != $seleksi_mahasiswa_baru->tahun) {
            $rules['tahun'] = 'required|integer|digits:4|unique:seleksi_mahasiswa_barus,tahun';
        } 

        $validasi = $request->validate($rules);

        DB::transaction(function () use ($validasi, $seleksi_mahasiswa_baru) {
            $seleksi_mahasiswa_baru->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui data seleksi mahasiswa.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = SeleksiMahasiswaBaru::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus data seleksi mahasiswa.');
    }
}
