<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kerjasama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KerjasamaController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $kerjasama = Kerjasama::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.kerjasama.index', compact('kerjasama'));
    }

    public function create()
    {
        return view('admin.pangkalan.kerjasama.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:100',
            'judul' => 'required|string|max:100',
            'output' => 'required|string|max:100',
            'tahun' => 'required|integer|digits:4',
            'durasi' => 'required|string|max:100',
            'bidang' => 'required|in:pendidikan,penelitian,pengabdian kepada masyarakat,pengembangan kelembagaan',
            'tingkat' => 'required|in:internasional,nasional,lokal',
        ];

        $validasi = $request->validate($rules);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;
        $validasi['nama'] = strtolower($request->nama);

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi){
            Kerjasama::create($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil menambahkan kerjasama.');

    }

    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $kerjasama = Kerjasama::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$kerjasama) { abort(404); }

        return view('admin.pangkalan.kerjasama.edit', compact('kerjasama'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'nama' => 'required|string|max:100',
            'judul' => 'required|string|max:100',
            'output' => 'required|string|max:100',
            'tahun' => 'required|integer|digits:4',
            'durasi' => 'required|string|max:100',
            'bidang' => 'required|in:pendidikan,penelitian,pengabdian kepada masyarakat,pengembangan kelembagaan',
            'tingkat' => 'required|in:internasional,nasional,lokal',
        ];

        $validasi = $request->validate($rules);

        $validasi['nama'] = strtolower($request->nama);

        $kodeprodi = auth()->user()->prodi['kode'];
        $kerjasama = Kerjasama::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$kerjasama) { abort(404); }

        DB::transaction(function () use ($validasi, $kerjasama){
            $kerjasama->update($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil memperbarui kerjasama.');

    }

    public function destroy(Request $request)
    {

        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Kerjasama::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus kerjasama.');

    }
}
