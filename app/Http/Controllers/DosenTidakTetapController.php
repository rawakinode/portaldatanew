<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DosenTidakTetap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenTidakTetapController extends Controller
{
    public function index()
    {
        $this->authorize('view pangkalan data');
        return view('admin.pangkalan.dosen_tt.index');
    }

    public function table()
    {
        $this->authorize('view pangkalan data');

        $kodeprodi = auth()->user()->prodi['kode'];
        $dosen = DosenTidakTetap::where('kode', $kodeprodi)->get();
        
        return response()->json($dosen, 200);
    }

    public function store(Request $request)
    {
        $this->authorize('view pangkalan data');

        $rules = [
            'nidn' => 'required|numeric|digits_between:4,20',
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|boolean',
            'pendidikan' => 'required|integer',
            'pascasarjana' => 'nullable|string|max:100',
            'golongan' => 'nullable|string|max:5',
            'fungsional' => 'nullable|integer|max:10',
            'bidang_keahlian' => 'nullable|string|max:50',
            'kesesuaian_kompetensi' => 'required|boolean',
            'nomor_sertifikasi' => 'nullable|string|max:20',
            'nomor_sertifikasi_profesi_industri' => 'nullable|string|max:20',
            'matakuliah_prodi' => 'nullable|string',
            'matakuliah_prodi_lain' => 'nullable|string',
            'industri_praktisi' => 'nullable|in:industri,praktisi',
        ];

        $validate = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];
        $validate['kode'] = $kodeprodi;

        $search = DosenTidakTetap::where('kode', $kodeprodi)->where('nidn', $request->nidn)->first();

        if ($search) {
            return response()->json([
                'message' => 'Dosen sudah ada !'
            ], 402);
        }

        $query = DosenTidakTetap::create($validate);

        if ($query) {
            return response()->json([
                'message' => 'Dosen berhasil di tambahkan !'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Gagal mengirim data !'
            ], 400);
        }
    }

    public function edit(Request $request) {

        $this->authorize('view pangkalan data');

        $id = $request->id;

        $kodeprodi = auth()->user()->prodi['kode'];
        $check = DosenTidakTetap::where('kode', $kodeprodi)->where('id', $id)->first();

        if (!$check) {
            return response()->json(['message' => 'Dosen tidak ditemukan !'], 404);
        }
        return response()->json($check, 200);
    }

    public function update(Request $request) {

        $this->authorize('view pangkalan data');

        $rules = [
            'nidn' => 'required|numeric|digits_between:4,20',
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|boolean',
            'pendidikan' => 'required|integer',
            'pascasarjana' => 'nullable|string|max:100',
            'golongan' => 'nullable|string|max:5',
            'fungsional' => 'nullable|integer|max:10',
            'bidang_keahlian' => 'nullable|string|max:50',
            'kesesuaian_kompetensi' => 'required|boolean',
            'nomor_sertifikasi' => 'nullable|string|max:20',
            'nomor_sertifikasi_profesi_industri' => 'nullable|string|max:20',
            'matakuliah_prodi' => 'nullable|string',
            'matakuliah_prodi_lain' => 'nullable|string',
            'industri_praktisi' => 'nullable|in:industri,praktisi',
        ];

        $validate = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];
        $validate['kode'] = $kodeprodi;

        $search = DosenTidakTetap::where('kode', $kodeprodi)->where('id', $request->id)->first();

        if (!$search) {
            return response()->json([
                'message' => 'Dosen tidak ada !'
            ], 404);
        }

        $query = $search->update($validate);

        if ($query) {
            return response()->json([
                'message' => 'Dosen berhasil di perbarui !'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Gagal mengirim data !'
            ], 500);
        }

    }

    public function destroy(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = ['id' => 'required|integer'];
        $validasi = $request->validate($rules);

        //Cek Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        $data = DosenTidakTetap::whereId($request->id)->whereKode($kodeprodi)->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return response()->json(['message' => 'Data berhasil dihapus']);

    }
}
