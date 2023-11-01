<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Traits\PangkalanDataTrait;
use App\Traits\StatusPeriodeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    use StatusPeriodeTrait;
    use PangkalanDataTrait;

    public function index()
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $dosen = Dosen::whereKode($kodeprodi)->get();

        return view('admin.pangkalan.dosen.index', compact('dosen'));
        
    }

    public function create()
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');
        return view('admin.pangkalan.dosen.create');
    }

    public function show($id)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $dosen = Dosen::findOrFail($id);

        return view('admin.pangkalan.dosen.show', compact('dosen'));
    }

    public function edit($id)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $dosen = Dosen::findOrFail($id);

        return view('admin.pangkalan.dosen.edit', compact('dosen'));
    }

    public function store(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = [
            'nidn' => 'required|numeric|digits_between:4,20|unique:dosens,nidn',
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|boolean',
            'pendidikan' => 'required|integer',
            'golongan' => 'nullable|string|max:5',
            'fungsional' => 'nullable|integer|max:10',
            'upload' => 'nullable|max:10000|mimes:pdf',
            'statusdosen' => 'required|in:tetap,tidak tetap,industri praktisi',
            'perusahaan_industri' => 'nullable|string|max:100',
            'bidang_keahlian' => 'required|string|max:50',
            'kesesuaian_kompetensi' => 'required|boolean',
            'pendidikan_magister' => 'nullable|string|max:50',
            'pendidikan_doctoral' => 'nullable|string|max:50',
            'nomor_sertifikasi' => 'nullable|string|max:20',
            'nomor_sertifikasi_profesi_industri' => 'nullable|string|max:20',
            'matakuliah_prodi' => 'nullable|string',
            'kesesuaian_matakuliah' => 'required|boolean',
            'matakuliah_prodi_lain' => 'nullable|string',
        ];

        $validasi = $request->validate($rules);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode'] = $kodeprodi;

        DB::transaction(function () use ($validasi, $request){
            if ($request->upload) {
                $validasi = $this->uploadSkDosen($validasi, $request);
            }
            //$validasi = $this->uploadSkDosen($validasi, $request);
            Dosen::create($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil menambahkan dosen.');

    }

    public function update(Request $request, $id)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $dosen = Dosen::findOrFail($id);

        $rules = [
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|boolean',
            'pendidikan' => 'required|integer',
            'golongan' => 'nullable|string|max:5',
            'fungsional' => 'nullable|integer|max:10',
            'upload' => 'nullable|max:10000|mimes:pdf',
            'statusdosen' => 'required|in:tetap,tidak tetap,industri praktisi',
            'perusahaan_industri' => 'nullable|string|max:100',
            'bidang_keahlian' => 'required|string|max:50',
            'kesesuaian_kompetensi' => 'required|boolean',
            'pendidikan_magister' => 'nullable|string|max:50',
            'pendidikan_doctoral' => 'nullable|string|max:50',
            'nomor_sertifikasi' => 'nullable|string|max:20',
            'nomor_sertifikasi_profesi_industri' => 'nullable|string|max:20',
            'matakuliah_prodi' => 'nullable|string',
            'kesesuaian_matakuliah' => 'required|boolean',
            'matakuliah_prodi_lain' => 'nullable|string',
        ];

        if ($request->nidn != $dosen->nidn) {
            $rules['nidn'] = 'required|numeric|digits_between:4,20|unique:dosens,nidn';
        }

        $validasi = $request->validate($rules);

        //CekProdi
        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode'] = $kodeprodi;

        if ($dosen['kode'] != $kodeprodi) { abort(404); }

        DB::transaction(function () use ($validasi, $request, $dosen){
            if ($request->upload) {
                $validasi = $this->updateUploadSkDosen($validasi, $request, $dosen);
            }
            //$validasi = $this->uploadSkDosen($validasi, $request);
            $dosen->update($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil memperbarui data dosen.');

    }

    public function destroy(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = ['id' => 'required|integer'];
        $validasi = $request->validate($rules);

        //Cek Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Dosen::whereId($request->id)->whereKode($kodeprodi)->first();
        DB::transaction(function () use ($data){
            if ($data->upload ?? null) { Storage::delete($data->upload); }
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus dosen.');

    }
}
