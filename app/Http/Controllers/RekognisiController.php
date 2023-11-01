<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\DosenHomebase;
use App\Models\Rekognisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RekognisiController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $rekognisi = Rekognisi::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->with(['dosen_homebase'])->get();

        return view('admin.pangkalan.rekognisi.index', compact('rekognisi'));
    }

    public function create()
    {
        return view('admin.pangkalan.rekognisi.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'rekognisi' => 'required|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'bidang' => 'required|string|max:50',
            'dosen' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'bukti' => 'nullable|string',
        ];

        $validasi = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];

        $check_dosen = DosenHomebase::where('nidn', $request->dosen)->first();

        if (!$check_dosen) {
            return redirect()->back()->withErrors('Dosen tidak ditemukan, harap hubungi Admin Universitas.');
        }

        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            Rekognisi::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan rekognisi.');
    }

    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $rekognisi = Rekognisi::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$rekognisi) { abort(404); }

        return view('admin.pangkalan.rekognisi.edit', compact('rekognisi'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'rekognisi' => 'required|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'bidang' => 'required|string|max:50',
            'dosen' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'bukti' => 'nullable|string',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];

        $check_dosen = Dosen::where('nidn', $request->dosen)->first();

        if (!$check_dosen) {
            return redirect()->back()->withErrors('Dosen tidak ditemukan, harap hubungi Admin Universitas.');
        }

        $validasi = $request->validate($rules);

        $rekognisi = Rekognisi::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$rekognisi) { abort(404); }

        DB::transaction(function () use ($validasi, $rekognisi) {
            $rekognisi->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui rekognisi.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Rekognisi::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus rekognisi.');
    }
}
