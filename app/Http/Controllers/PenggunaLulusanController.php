<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\PenggunaLulusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenggunaLulusanController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $pengguna_lulusan = PenggunaLulusan::whereKodeProdi($kodeprodi)->with(['mahasiswa' => function ($query) use ($kodeprodi) {
            return $query->where('kode_prodi', $kodeprodi);
        }])->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.pengguna_lulusan.index', compact('pengguna_lulusan'));
    }

    public function create()
    {
        return view('admin.pangkalan.pengguna_lulusan.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nim' => 'required|string|max:15',
            'tahun' => 'required|integer|digits:4',
            'nama_penilai' => 'required|string|max:50',
            'jabatan_penilai' => 'required|string|max:50',
            'instansi' => 'required|string|max:100',
            'etika' => 'required|in:sangat baik,baik,cukup,kurang',
            'kompetensi_utama' => 'required|in:sangat baik,baik,cukup,kurang',
            'bahasa_asing' => 'required|in:sangat baik,baik,cukup,kurang',
            'teknologi_informasi' => 'required|in:sangat baik,baik,cukup,kurang',
            'komunikasi' => 'required|in:sangat baik,baik,cukup,kurang',
            'kerjasama' => 'required|in:sangat baik,baik,cukup,kurang',
            'pengembangan_diri' => 'required|in:sangat baik,baik,cukup,kurang',
        ];

        $validasi = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];

        $check_mahasiswa = Mahasiswa::where('nim', $request->nim)->where('kode_prodi', $kodeprodi)->first();

        if (!$check_mahasiswa) {
            return redirect()->back()->withErrors('NIM Mahasiswa tidak terdaftar, harap tambahkan mahasiswa terlebih dahulu.')->withInput(['nim']);
        }

        $check_mahasiswa_exist = PenggunaLulusan::where('nim', $request->nim)->where('tahun', $request->tahun)->first();
        if ($check_mahasiswa_exist) {
            return redirect()->back()->withErrors('Tracer study untuk mahasiswa ini sudah ada di tahun ini');
        }

        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            PenggunaLulusan::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan tracer study mahasiswa.');
    }
    
    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $pengguna_lulusan = PenggunaLulusan::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$pengguna_lulusan) { abort(404); }

        return view('admin.pangkalan.pengguna_lulusan.edit', compact('pengguna_lulusan'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'nim' => 'required|string|max:15',
            'tahun' => 'required|integer|digits:4',
            'nama_penilai' => 'required|string|max:50',
            'jabatan_penilai' => 'required|string|max:50',
            'instansi' => 'required|string|max:100',
            'etika' => 'required|in:sangat baik,baik,cukup,kurang',
            'kompetensi_utama' => 'required|in:sangat baik,baik,cukup,kurang',
            'bahasa_asing' => 'required|in:sangat baik,baik,cukup,kurang',
            'teknologi_informasi' => 'required|in:sangat baik,baik,cukup,kurang',
            'komunikasi' => 'required|in:sangat baik,baik,cukup,kurang',
            'kerjasama' => 'required|in:sangat baik,baik,cukup,kurang',
            'pengembangan_diri' => 'required|in:sangat baik,baik,cukup,kurang',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi = $request->validate($rules);

        $check_mahasiswa = Mahasiswa::where('nim', $request->nim)->first();
        if (!$check_mahasiswa) {
            return redirect()->back()->withErrors('NIM Mahasiswa tidak terdaftar, harap tambahkan mahasiswa terlebih dahulu.')->withInput(['nim']);
        }

        $pengguna_lulusan = PenggunaLulusan::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$pengguna_lulusan) { abort(404); }

        DB::transaction(function () use ($validasi, $pengguna_lulusan) {
            $pengguna_lulusan->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui pengguna lulusan.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = PenggunaLulusan::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus pengguna lulusan.');
    }
}
