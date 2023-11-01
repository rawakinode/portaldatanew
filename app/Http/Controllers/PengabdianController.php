<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengabdianController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $pengabdian = Pengabdian::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.pengabdian.index', compact('pengabdian'));
    }

    public function create()
    {
        return view('admin.pangkalan.pengabdian.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'tema' => 'required|string|max:200',
            'integrasi_pembelajaran' => 'nullable|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'sumber_dana' => 'required|in:mandiri,perguruan tinggi,nasional,internasional',
            'jumlah_dana' => 'required|integer',
        ];

        if ($request->nidn) {
            $nidn = $request->nidn;
            $dosen = $request->dosen;
            $dosen_all = collect();

            for ($i = 0; $i < count($nidn); $i++) {
                if ($dosen[$i]) {
                    $dosen_all->push(['nidn' => $nidn[$i], 'dosen' => $dosen[$i]]);
                }
            }
        }

        if ($request->nim) {
            $nim = $request->nim;
            $mahasiswa = $request->mahasiswa;

            $mahasiswa_all = collect();

            for ($i = 0; $i < count($nim); $i++) {
                if ($mahasiswa[$i]) {
                    $mahasiswa_all->push(['nim' => $nim[$i], 'mahasiswa' => $mahasiswa[$i]]);
                }
            }
        }

        $validasi = $request->validate($rules);

        if ($request->nidn) { $validasi['dosen'] = json_encode($dosen_all); } else {
            return redirect()->back()->withErrors('Wajib menambahkan dosen pengabdi');}
        if ($request->nim) { $validasi['mahasiswa'] = json_encode($mahasiswa_all); }

        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            Pengabdian::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan pengabdian.');
    }

    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $pengabdian = Pengabdian::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$pengabdian) { abort(404); }

        return view('admin.pangkalan.pengabdian.edit', compact('pengabdian'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'tema' => 'required|string|max:200',
            'integrasi_pembelajaran' => 'nullable|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'sumber_dana' => 'required|in:mandiri,perguruan tinggi,nasional,internasional',
            'jumlah_dana' => 'required|integer',
        ];

        if ($request->nidn) {
            $nidn = $request->nidn;
            $dosen = $request->dosen;
            $dosen_all = collect();

            for ($i = 0; $i < count($nidn); $i++) {
                if ($dosen[$i]) {
                    $dosen_all->push(['nidn' => $nidn[$i], 'dosen' => $dosen[$i]]);
                }
            }
        }

        if ($request->nim) {
            $nim = $request->nim;
            $mahasiswa = $request->mahasiswa;

            $mahasiswa_all = collect();

            for ($i = 0; $i < count($nim); $i++) {
                if ($mahasiswa[$i]) {
                    $mahasiswa_all->push(['nim' => $nim[$i], 'mahasiswa' => $mahasiswa[$i]]);
                }
            }
        }

        $validasi = $request->validate($rules);

        if ($request->nidn) { $validasi['dosen'] = json_encode($dosen_all); } else {
            return redirect()->back()->withErrors('Wajib menambahkan dosen pengabdi');}
        if ($request->nim) { $validasi['mahasiswa'] = json_encode($mahasiswa_all); } else {
            $validasi['mahasiswa'] = null;
        }

        $kodeprodi = auth()->user()->prodi['kode'];

        $pengabdian = Pengabdian::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$pengabdian) { abort(404); }

        DB::transaction(function () use ($validasi, $pengabdian) {
            $pengabdian->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui pengabdian.');
    }

    public function destroy(Request $request)
    {

        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Pengabdian::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus pengabdian.');

    }
}
