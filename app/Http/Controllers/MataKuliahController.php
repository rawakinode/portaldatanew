<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MataKuliahController extends Controller
{
    public function index()
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $matakuliah = MataKuliah::whereKodeProdi($kodeprodi)->orderBy('semester', 'ASC')->get();

        return view('admin.pangkalan.kurikulum.index', compact('matakuliah'));
    }

    public function create()
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');
        return view('admin.pangkalan.kurikulum.create');
    }

    public function store(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = [
            'kode' => 'required|string|max:25',
            'nama' => 'required|string|max:255',
            'status' => 'required|boolean',
            'jenis' => 'required|string|max:50',
            'sks' => 'required|integer|max:10',
            'sks_praktikum' => 'required|integer|max:10',
            'semester' => 'required|integer|max:20',
            'sks_seminar' => 'required|integer|max:10',
            'capaian_sikap' => 'nullable|boolean',
            'capaian_pengetahuan' => 'nullable|boolean',
            'capaian_keterampilan_umum' => 'nullable|boolean',
            'capaian_keterampilan_khusus' => 'nullable|boolean',
            'jenis_dokumen' => 'nullable|string|max:50',
            'unit_penyelenggara' => 'nullable|string|max:50',
            'konversi' => 'nullable|numeric|max:50',
        ];
        $validasi = $request->validate($rules);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        $cek_kode = MataKuliah::whereKodeProdi($kodeprodi)->whereKode($request->kode)->get();
        if ($cek_kode->count()) { return redirect()->back()->withErrors(['kode' => 'Mata kuliah sudah ada.'])->withInput(); }
        
        $nama = Str::lower($request->nama);
        $validasi['nama'] = ucwords($nama);

        $validasi['kode_prodi'] = $kodeprodi;

        DB::transaction(function () use ($validasi) {
            MataKuliah::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan mata kuliah.');
    }

    public function edit($id)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $matakuliah = MataKuliah::findOrFail($id);

        return view('admin.pangkalan.kurikulum.edit', compact('matakuliah'));
    }

    public function update(Request $request, $id)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = [
            'kode' => 'required|string|max:25',
            'nama' => 'required|string|max:255',
            'status' => 'required|boolean',
            'jenis' => 'required|string|max:50',
            'sks' => 'required|integer|max:10',
            'sks_praktikum' => 'required|integer|max:10',
            'semester' => 'required|integer|max:20',
            'sks_seminar' => 'required|integer|max:10',
            'capaian_sikap' => 'nullable|boolean',
            'capaian_pengetahuan' => 'nullable|boolean',
            'capaian_keterampilan_umum' => 'nullable|boolean',
            'capaian_keterampilan_khusus' => 'nullable|boolean',
            'jenis_dokumen' => 'nullable|string|max:50',
            'unit_penyelenggara' => 'nullable|string|max:50',
            'konversi' => 'nullable|numeric|max:50',
        ];
        
        $validasi = $request->validate($rules);
        $nama = Str::lower($request->nama);
        $validasi['nama'] = ucwords($nama);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        $data = MataKuliah::findOrFail($id);

        if ($data['kode_prodi'] != $kodeprodi) { abort(404); }

        if ($data->kode != $request->kode) {
            $cek_kode = MataKuliah::whereKodeProdi($kodeprodi)->whereKode($request->kode)->get();
            if ($cek_kode->count()) {
                return redirect()->back()->withErrors(['kode' => 'Mata kuliah sudah ada.'])->withInput();
            }
        }

        DB::transaction(function () use ($validasi, $data) {
            $data->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui mata kuliah.');
    }

    public function destroy(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = ['id' => 'required|integer'];
        $request->validate($rules);

        //Cek Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        //Menghapus data
        $data = MataKuliah::whereId($request->id)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return redirect()->back()->with('success', 'Berhasil menghapus mata kuliah.');
    }
}
