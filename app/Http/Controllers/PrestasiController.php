<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrestasiController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $prestasi = Prestasi::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        return view('admin.pangkalan.prestasi.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:150',
            'prestasi' => 'required|string|max:150',
            'nim' => 'required|string|max:12',
            'nama_mahasiswa' => 'required|string|max:150',
            'tahun' => 'required|integer|digits:4',
            'bidang' => 'required|in:akademik,non-akademik',
            'tingkat' => 'required|in:internasional,nasional,lokal',
        ];

        $validasi = $request->validate($rules);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;
        $validasi['nama'] = strtolower($request->nama);
        $validasi['nim'] = strtoupper($request->nim);
        $validasi['nama_mahasiswa'] = strtolower($request->nama_mahasiswa);

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi){
            Prestasi::create($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil menambahkan prestasi.');

    }

    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $prestasi = Prestasi::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$prestasi) { abort(404); }

        return view('admin.pangkalan.prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'nama' => 'required|string|max:150',
            'prestasi' => 'required|string|max:150',
            'nim' => 'required|string|max:12',
            'nama_mahasiswa' => 'required|string|max:150',
            'tahun' => 'required|integer|digits:4',
            'bidang' => 'required|in:akademik,non-akademik',
            'tingkat' => 'required|in:internasional,nasional,lokal',
        ];

        $validasi = $request->validate($rules);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;
        $validasi['nama'] = strtolower($request->nama);
        $validasi['nim'] = strtoupper($request->nim);
        $validasi['nama_mahasiswa'] = strtolower($request->nama_mahasiswa);

        $prestasi = Prestasi::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$prestasi) { abort(404); }

        DB::transaction(function () use ($validasi, $prestasi){
            $prestasi->update($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil memperbarui prestasi mahasiswa.');

    }

    public function destroy(Request $request)
    {

        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Prestasi::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus prestasi mahasiswa.');

    }
}
