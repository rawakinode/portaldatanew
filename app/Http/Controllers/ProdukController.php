<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DosenHomebase;
use App\Models\Mahasiswa;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $produk = Produk::whereKodeProdi($kodeprodi)->with(['mahasiswa' => function ($query) use ($kodeprodi) {
            return $query->where('kode_prodi', $kodeprodi);
        }, 'dosen_homebase'])->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.produk.index', compact('produk'));
    }

    public function create()
    {
        return view('admin.pangkalan.produk.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nim' => 'nullable|string|max:15',
            'nidn' => 'nullable|numeric|digits_between:4,20',
            'tahun' => 'required|integer|digits:4',
            'produk' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:250',
            'bukti' => 'nullable|string|max:150',
            'keterangan' => 'nullable|string|max:250',
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

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            Produk::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan produk / jasa.');
    }
    
    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $produk = Produk::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$produk) { abort(404); }

        return view('admin.pangkalan.produk.edit', compact('produk'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'nim' => 'nullable|string|max:15',
            'nidn' => 'nullable|numeric|digits_between:4,20',
            'tahun' => 'required|integer|digits:4',
            'produk' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:250',
            'bukti' => 'nullable|string|max:150',
            'keterangan' => 'nullable|string|max:250',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi = $request->validate($rules);

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

        $produk = Produk::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$produk) { abort(404); }

        DB::transaction(function () use ($validasi, $produk) {
            $produk->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui produk / jasa.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Produk::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus produk / jasa.');
    }
}
