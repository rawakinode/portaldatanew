<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PerolehanDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PerolehanDanaController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $perolehan_dana = PerolehanDana::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.perolehan_dana.index', compact('perolehan_dana'));
    }

    public function create()
    {
        return view('admin.pangkalan.perolehan_dana.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'sumber' => 'required|in:mahasiswa,kementerian & yayasan,perguruan tinggi,sumber lain',
            'jenis' => 'required|in:spp,sumbangan lain,anggaran rutin,anggaran pembangunan,hibah penelitian,hibah pkm,jasa layanan profesi dan keahlian,produk institusi,kerjasama kelembagaan,hibah,dana lestari dan filantropis,lain-lain',
            'jumlah' => 'nullable|numeric|min:1000',
            'keterangan' => 'nullable|string|max:200',
            'bukti' => 'nullable|string|max:100',
        ];

        $validasi = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            PerolehanDana::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan perolehan dana.');
    }

    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $perolehan_dana = PerolehanDana::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$perolehan_dana) { abort(404); }

        return view('admin.pangkalan.perolehan_dana.edit', compact('perolehan_dana'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'sumber' => 'required|in:mahasiswa,kementerian & yayasan,perguruan tinggi,sumber lain',
            'jenis' => 'required|in:spp,sumbangan lain,anggaran rutin,anggaran pembangunan,hibah penelitian,hibah pkm,jasa layanan profesi dan keahlian,produk institusi,kerjasama kelembagaan,hibah,dana lestari dan filantropis,lain-lain',
            'jumlah' => 'nullable|numeric|min:1000',
            'keterangan' => 'nullable|string|max:200',
            'bukti' => 'nullable|string|max:100',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi = $request->validate($rules);

        $perolehan_dana = PerolehanDana::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$perolehan_dana) { abort(404); }

        DB::transaction(function () use ($validasi, $perolehan_dana) {
            $perolehan_dana->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui perolehan dana.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = PerolehanDana::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus perolehan dana.');
    }
}
