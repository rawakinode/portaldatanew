<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PublikasiController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $publikasi = Publikasi::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.publikasi.index', compact('publikasi'));
    }

    public function create()
    {
        return view('admin.pangkalan.publikasi.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'penulis_nidn' => 'nullable|string|max:20',
            'penulis_dosen' => 'required|string|max:100',
            'jenis' => 'required|in:jurnal,seminar,media massa,pagelaran pameran presentasi',
            'sub_jenis' => 'required|in:nasional tidak terakreditasi,nasional terakreditasi,internasional,internasional bereputasi,wilayah / lokal / PT,nasional',
            'publikasi' => 'required|string|max:200',
            'sitasi' => 'required|integer',
        ];

        if ($request->dosen_lain) {
            $nidn = $request->nidn_lain;
            $dosen = $request->dosen_lain;

            $penulis_all = collect();

            for ($i = 0; $i < count($dosen); $i++) {
                if ($nidn[$i]) {
                    $penulis_all->push(['nidn' => $nidn[$i], 'dosen' => $dosen[$i]]);
                }else{
                    $penulis_all->push(['nidn' => null, 'dosen' => $dosen[$i]]);
                }
            }
        }

        $validasi = $request->validate($rules);

        if ($request->dosen_lain) { $validasi['anggota'] = json_encode($penulis_all); }

        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            Publikasi::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan publikasi.');
    }

    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $publikasi = Publikasi::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$publikasi) { abort(404); }

        return view('admin.pangkalan.publikasi.edit', compact('publikasi'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'judul' => 'required|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'penulis_nidn' => 'nullable|string|max:20',
            'penulis_dosen' => 'required|string|max:100',
            'jenis' => 'required|in:jurnal,seminar,media massa,pagelaran pameran presentasi',
            'sub_jenis' => 'required|in:nasional tidak terakreditasi,nasional terakreditasi,internasional,internasional bereputasi,wilayah / lokal / PT,nasional',
            'publikasi' => 'required|string|max:200',
            'sitasi' => 'required|integer',
        ];

        if ($request->dosen_lain) {
            $nidn = $request->nidn_lain;
            $dosen = $request->dosen_lain;

            $penulis_all = collect();

            for ($i = 0; $i < count($dosen); $i++) {
                if ($nidn[$i]) {
                    $penulis_all->push(['nidn' => $nidn[$i], 'dosen' => $dosen[$i]]);
                }else{
                    $penulis_all->push(['nidn' => null, 'dosen' => $dosen[$i]]);
                }
            }
        }

        $validasi = $request->validate($rules);

        if ($request->dosen_lain) { $validasi['anggota'] = json_encode($penulis_all); }

        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;

        $publikasi = Publikasi::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$publikasi) { abort(404); }

        DB::transaction(function () use ($validasi, $publikasi) {
            $publikasi->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui publikasi.');
    }

    public function destroy(Request $request)
    {

        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Publikasi::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus publikasi.');

    }
}
