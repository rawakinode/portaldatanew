<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PeralatanLaboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PeralatanLaboratoriumController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $peralatan = PeralatanLaboratorium::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.peralatan.index', compact('peralatan'));
    }

    public function create()
    {
        return view('admin.pangkalan.peralatan.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'tahun' => 'required|integer|digits:4',
            'nama' => 'required|string|max:150',
            'fungsi' => 'required|string|max:250',
            'lokasi' => 'required|string|max:150',
        ];

        $validasi = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10) . '-' . Str::random(10) . '-' . Str::random(10) . '-' . Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            PeralatanLaboratorium::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan peralatan laboratorium.');
    }

    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $peralatan = PeralatanLaboratorium::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$peralatan) {
            abort(404);
        }
        return view('admin.pangkalan.peralatan.edit', compact('peralatan'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'tahun' => 'required|integer|digits:4',
            'nama' => 'required|string|max:150',
            'fungsi' => 'required|string|max:250',
            'lokasi' => 'required|string|max:150',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi = $request->validate($rules);

        $peralatan = PeralatanLaboratorium::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$peralatan) {
            abort(404);
        }

        DB::transaction(function () use ($validasi, $peralatan) {
            $peralatan->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui peralatan laboratorium.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = PeralatanLaboratorium::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return redirect()->back()->with('success', 'Berhasil menghapus peralatan laboratorium.');
    }
}
