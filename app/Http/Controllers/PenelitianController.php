<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Penelitian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenelitianController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $penelitian = Penelitian::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.penelitian.index', compact('penelitian'));
    }

    public function create()
    {
        return view('admin.pangkalan.penelitian.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'tema' => 'required|string|max:200',
            'rujukan_tema' => 'nullable|string|max:200',
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
            return redirect()->back()->withErrors('Wajib menambahkan dosen peneliti');}
        if ($request->nim) { $validasi['mahasiswa'] = json_encode($mahasiswa_all); }

        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            Penelitian::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan penelitian.');
    }

    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $penelitian = Penelitian::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$penelitian) { abort(404); }

        return view('admin.pangkalan.penelitian.edit', compact('penelitian'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'tema' => 'required|string|max:200',
            'rujukan_tema' => 'nullable|string|max:200',
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
            return redirect()->back()->withErrors('Wajib menambahkan dosen peneliti');}
        if ($request->nim) { $validasi['mahasiswa'] = json_encode($mahasiswa_all); } else {
            $validasi['mahasiswa'] = null;
        }

        $kodeprodi = auth()->user()->prodi['kode'];

        $penelitian = Penelitian::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$penelitian) { abort(404); }

        DB::transaction(function () use ($validasi, $penelitian) {
            $penelitian->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui penelitian.');
    }

    public function destroy(Request $request)
    {

        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Penelitian::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus penelitian.');

    }
}
