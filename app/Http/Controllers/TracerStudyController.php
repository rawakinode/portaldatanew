<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\TracerStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TracerStudyController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $tracer_study = TracerStudy::whereKodeProdi($kodeprodi)->with('mahasiswa')->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.tracer_study.index', compact('tracer_study'));
    }

    public function create()
    {
        return view('admin.pangkalan.tracer_study.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nim' => 'required|string|max:15',
            'tahun' => 'required|integer|digits:4',
            'masa_studi' => 'required|integer|min:1',
            'waktu_tunggu_kerja' => 'required|integer|min:1',
            'kesesuaian_bidang_ilmu' => 'required|in:sesuai,kurang sesuai,tidak sesuai',
            'tingkat' => 'required|in:lokal / wilayah / berwirausaha tidak berbadan hukum,nasional / berwirausaha berbadan hukum,multinasional / internasional,melanjutkan studi',
            'penghasilan' => 'required|numeric|min:1000',
            'umr' => 'required|in:1,0',
        ];

        $validasi = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];

        $check_mahasiswa = Mahasiswa::where('nim', $request->nim)->where('kode_prodi', $kodeprodi)->first();

        if (!$check_mahasiswa) {
            return redirect()->back()->withErrors('NIM Mahasiswa tidak terdaftar, harap tambahkan mahasiswa terlebih dahulu.')->withInput(['nim']);
        }

        $check_mahasiswa_exist = TracerStudy::where('nim', $request->nim)->where('tahun', $request->tahun)->first();
        if ($check_mahasiswa_exist) {
            return redirect()->back()->withErrors('Tracer study untuk mahasiswa ini sudah ada di tahun ini');
        }

        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            TracerStudy::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan tracer study mahasiswa.');
    }
    
    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $tracer_study = TracerStudy::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$tracer_study) { abort(404); }

        return view('admin.pangkalan.tracer_study.edit', compact('tracer_study'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'nim' => 'required|string|max:15',
            'tahun' => 'required|integer|digits:4',
            'masa_studi' => 'required|integer|min:1',
            'waktu_tunggu_kerja' => 'required|integer|min:1',
            'kesesuaian_bidang_ilmu' => 'required|in:sesuai,kurang sesuai,tidak sesuai',
            'tingkat' => 'required|in:lokal / wilayah / berwirausaha tidak berbadan hukum,nasional / berwirausaha berbadan hukum,multinasional / internasional,melanjutkan studi',
            'penghasilan' => 'required|numeric|min:1000',
            'umr' => 'required|in:1,0',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi = $request->validate($rules);

        $check_mahasiswa = Mahasiswa::where('nim', $request->nim)->first();
        if (!$check_mahasiswa) {
            return redirect()->back()->withErrors('NIM Mahasiswa tidak terdaftar, harap tambahkan mahasiswa terlebih dahulu.')->withInput(['nim']);
        }

        $tracer_study = TracerStudy::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$tracer_study) { abort(404); }

        DB::transaction(function () use ($validasi, $tracer_study) {
            $tracer_study->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui tracer study.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = TracerStudy::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus tracer study.');
    }
}
