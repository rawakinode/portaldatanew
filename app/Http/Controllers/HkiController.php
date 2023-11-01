<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DosenHomebase;
use App\Models\Hki;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HkiController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $hki = Hki::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->with(['mahasiswa' => function ($query) use ($kodeprodi) {
            return $query->where('kode_prodi', $kodeprodi);
        }, 'dosen_homebase'])->get();

        return view('admin.pangkalan.hki.index', compact('hki'));
    }

    public function create()
    {
        return view('admin.pangkalan.hki.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'keterangan' => 'nullable|string|max:200',
            'bukti' => 'nullable|string|max:100',
            'tahun' => 'required|integer|digits:4',
            'jenis' => 'required|in:merek,paten,desain industri,hak cipta,indikasi geografis,paten sederhana,perlindungan varietas tanaman,desain tata letak sirkuit terpadu,teknologi tepat guna,produk,karya seni,rekayasa sosial',
            'nim' => 'nullable|string|max:15',
            'nidn' => 'nullable|numeric|digits_between:4,20',
            'nomor' => 'required|string|max:50',
        ];

        $validasi = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];

        if ($request->nim) {
            $check_mahasiswa = Mahasiswa::where('nim', $request->nim)->where('kode_prodi', $kodeprodi)->first();
            if (!$check_mahasiswa) {
                return redirect()->back()->withErrors('NIM Mahasiswa tidak terdaftar, harap tambahkan mahasiswa terlebih dahulu.')->withInput();
            }
        }

        if ($request->nidn) {
            $check_dosen = DosenHomebase::where('nidn', $request->nidn)->first();
            if (!$check_dosen) {
                return redirect()->back()->withErrors('Dosen dengan NIDN/NIDK tidak terdaftar, harap hubungi Admin Universitas.')->withInput();
            }
        }

        if (!$request->nim && !$request->nidn) {
            return redirect()->back()->withErrors('Harus memilih dosen atau mahasiswa.');
        }

        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10) . '-' . Str::random(10) . '-' . Str::random(10) . '-' . Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            Hki::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan hki.');
    }

    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $hki = Hki::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$hki) {
            abort(404);
        }

        return view('admin.pangkalan.hki.edit', compact('hki'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'keterangan' => 'nullable|string|max:200',
            'bukti' => 'nullable|string|max:100',
            'tahun' => 'required|integer|digits:4',
            'jenis' => 'required|in:merek,paten,desain industri,hak cipta,indikasi geografis,paten sederhana,perlindungan varietas tanaman,desain tata letak sirkuit terpadu,teknologi tepat guna,produk,karya seni,rekayasa sosial',
            'nim' => 'nullable|string|max:15',
            'nidn' => 'nullable|numeric|digits_between:4,20',
            'nomor' => 'required|string|max:50',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];

        if ($request->nim) {
            $check_mahasiswa = Mahasiswa::where('nim', $request->nim)->where('kode_prodi', $kodeprodi)->first();
            if (!$check_mahasiswa) {
                return redirect()->back()->withErrors('NIM Mahasiswa tidak terdaftar, harap tambahkan mahasiswa terlebih dahulu.')->withInput();
            }
        }

        if ($request->nidn) {
            $check_dosen = DosenHomebase::where('nidn', $request->nidn)->first();
            if (!$check_dosen) {
                return redirect()->back()->withErrors('Dosen dengan NIDN/NIDK tidak terdaftar, harap hubungi Admin Universitas.')->withInput();
            }
        }

        if (!$request->nim && !$request->nidn) {
            return redirect()->back()->withErrors('Harus memilih dosen atau mahasiswa.');
        }

        $validasi = $request->validate($rules);

        $hki = Hki::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$hki) {
            abort(404);
        }

        DB::transaction(function () use ($validasi, $hki) {
            $hki->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui hki.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Hki::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return redirect()->back()->with('success', 'Berhasil menghapus hki.');
    }
}
