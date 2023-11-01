<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KepuasanMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KepuasanMahasiswaController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $kepuasan_mahasiswa = KepuasanMahasiswa::whereKodeProdi($kodeprodi)->with(['mahasiswa' => function ($query) use ($kodeprodi) {
            return $query->where('kode_prodi', $kodeprodi);
        }])->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.kepuasan_mahasiswa.index', compact('kepuasan_mahasiswa'));
    }

    public function create()
    {
        return view('admin.pangkalan.kepuasan_mahasiswa.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nim' => 'required|string|max:15',
            'tahun' => 'required|integer|digits:4',
            'tindak_lanjut' => 'required|string|max:250',
            'keandalan' => 'required|in:sangat baik,baik,cukup,kurang',
            'daya_tanggap' => 'required|in:sangat baik,baik,cukup,kurang',
            'kepastian' => 'required|in:sangat baik,baik,cukup,kurang',
            'empati' => 'required|in:sangat baik,baik,cukup,kurang',
            'nyata' => 'required|in:sangat baik,baik,cukup,kurang',
        ];

        $validasi = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];

        $check_mahasiswa = Mahasiswa::where('nim', $request->nim)->where('kode_prodi', $kodeprodi)->first();

        if (!$check_mahasiswa) {
            return redirect()->back()->withErrors('NIM Mahasiswa tidak terdaftar, harap tambahkan mahasiswa terlebih dahulu.')->withInput(['nim']);
        }

        $check_mahasiswa_exist = KepuasanMahasiswa::where('nim', $request->nim)->where('tahun', $request->tahun)->first();
        if ($check_mahasiswa_exist) {
            return redirect()->back()->withErrors('kepuasan mahasiswa untuk mahasiswa ini sudah ada di tahun ini');
        }

        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            KepuasanMahasiswa::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan kepuasan mahasiswa mahasiswa.');
    }
    
    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $kepuasan_mahasiswa = KepuasanMahasiswa::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$kepuasan_mahasiswa) { abort(404); }

        return view('admin.pangkalan.kepuasan_mahasiswa.edit', compact('kepuasan_mahasiswa'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'nim' => 'required|string|max:15',
            'tahun' => 'required|integer|digits:4',
            'tindak_lanjut' => 'required|string|max:250',
            'keandalan' => 'required|in:sangat baik,baik,cukup,kurang',
            'daya_tanggap' => 'required|in:sangat baik,baik,cukup,kurang',
            'kepastian' => 'required|in:sangat baik,baik,cukup,kurang',
            'empati' => 'required|in:sangat baik,baik,cukup,kurang',
            'nyata' => 'required|in:sangat baik,baik,cukup,kurang',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi = $request->validate($rules);

        $check_mahasiswa = Mahasiswa::where('nim', $request->nim)->first();
        if (!$check_mahasiswa) {
            return redirect()->back()->withErrors('NIM Mahasiswa tidak terdaftar, harap tambahkan mahasiswa terlebih dahulu.')->withInput(['nim']);
        }

        $kepuasan_mahasiswa = KepuasanMahasiswa::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$kepuasan_mahasiswa) { abort(404); }

        DB::transaction(function () use ($validasi, $kepuasan_mahasiswa) {
            $kepuasan_mahasiswa->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui kepuasan mahasiswa.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = KepuasanMahasiswa::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus kepuasan mahasiswa.');
    }
}
