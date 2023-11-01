<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DosenHomebase;
use App\Traits\PangkalanDataTrait;
use App\Traits\StatusPeriodeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DosenHomebaseController extends Controller
{

    use StatusPeriodeTrait;
    use PangkalanDataTrait;

    public function index() {

        $this->authorize('kelola dosen');

        $dosen = DosenHomebase::with('prodi_homebase')->get();

        return view('admin.administrator.dosen.index', compact('dosen'));
    }

    public function create()
    {
        
        $this->authorize('kelola dosen');

        return view('admin.administrator.dosen.create');
    }

    public function edit($id)
    {
        //Permission Role Set
        $this->authorize('kelola dosen');

        $dosen = DosenHomebase::findOrFail($id);

        return view('admin.administrator.dosen.edit', compact('dosen'));
    }

    public function store(Request $request)
    {
        //Permission Role Set
        $this->authorize('kelola dosen');

        $rules = [
            'nidn' => 'required|numeric|digits_between:4,20|unique:dosen_homebases,nidn',
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|boolean',
            'pendidikan' => 'required|integer',
            'golongan' => 'nullable|string|max:5',
            'fungsional' => 'nullable|integer|max:10',
            'upload' => 'nullable|max:10000|mimes:pdf',
            'homebase' => 'required|integer',
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

        DB::transaction(function () use ($validasi, $request){
            if ($request->upload) {
                $validasi = $this->uploadSkDosen($validasi, $request);
            }
            //$validasi = $this->uploadSkDosen($validasi, $request);
            DosenHomebase::create($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil menambahkan dosen homebase.');

    }

    public function update(Request $request, $id)
    {
        //Permission Role Set
        $this->authorize('kelola dosen');

        $dosen = DosenHomebase::findOrFail($id);

        $rules = [
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|boolean',
            'pendidikan' => 'required|integer',
            'golongan' => 'nullable|string|max:5',
            'fungsional' => 'nullable|integer|max:10',
            'upload' => 'nullable|max:10000|mimes:pdf',
            'homebase' => 'required|integer',
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
            $rules['nidn'] = 'required|numeric|digits_between:4,20|unique:dosen_homebases,nidn';
        }

        $validasi = $request->validate($rules);

        DB::transaction(function () use ($validasi, $request, $dosen){
            if ($request->upload) {
                $validasi = $this->updateUploadSkDosen($validasi, $request, $dosen);
            }
            $dosen->update($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil memperbarui data dosen homebase.');

    }

    public function destroy(Request $request)
    {
        //Permission Role Set
        $this->authorize('kelola dosen');

        $rules = ['id' => 'required|integer'];
        $validasi = $request->validate($rules);

        $data = DosenHomebase::whereId($request->id)->first();

        DB::transaction(function () use ($data){
            if ($data->upload ?? null) { Storage::delete($data->upload); }
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus dosen homebase.');

    }
}
