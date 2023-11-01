<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DosenHomebase;
use App\Models\DosenTetapProdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenTetapProdiController extends Controller
{
    public function index()
    {

        $this->authorize('view pangkalan data');
        return view('admin.pangkalan.dosen.index');
    }

    public function table()
    {

        $this->authorize('view pangkalan data');
        $kodeprodi = auth()->user()->prodi['kode'];
        $dosen = DosenTetapProdi::where('kode', $kodeprodi)->with('dosen_prodi')->get();
        return response()->json($dosen, 200);
    }

    public function store(Request $request)
    {

        $this->authorize('view pangkalan data');

        $rules = [
            'dosen_kode' => 'required|numeric'
        ];
        $validate = $request->validate($rules);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        $cek_dosen_hb = DosenHomebase::where('nidn', $request->dosen_kode)->first();
        if (!$cek_dosen_hb) {
            return response()->json([
                'status' => 500,
                'message' => 'Dosen tidak terdaftar di homebase di Universitas Tadulako !'
            ], 200);
        }

        $search = DosenTetapProdi::where('nidn', $request->dosen_kode)->first();
        if ($search) {
            return response()->json([
                'status' => 500,
                'message' => 'Dosen sudah ada !'
            ], 200);
        }

        $query = DosenTetapProdi::create([
            'kode' => $kodeprodi,
            'nidn' => $request->dosen_kode,
            'kesesuaian_kompetensi' => true,
            'kesesuaian_matakuliah' => true,
        ]);

        if ($query) {
            return response()->json([
                'status' => 200,
                'message' => 'Dosen berhasil di tambahkan !'
            ], 200);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Gagal mengirim data !'
            ], 200);
        }
    }

    public function edit(Request $request) {

        $this->authorize('view pangkalan data');

        $id = $request->id;

        $kodeprodi = auth()->user()->prodi['kode'];
        $check = DosenTetapProdi::where('kode', $kodeprodi)->where('id', $id)->with('dosen_prodi')->first();
        if (!$check) {
            return response()->json(['message' => 'Dosen tidak ditemukan !'], 404);
        }
        return response()->json($check, 200);
    }

    public function update(Request $request) {

        $this->authorize('view pangkalan data');

        $rules = [
            'kes_kom' => 'required|boolean',
            'kes_mat' => 'required|boolean',
            'mk_prodi' => 'nullable|string',
            'mk_prodi_lain' => 'nullable|string',
        ];

        $validasi = $request->validate($rules);
        $kodeprodi = auth()->user()->prodi['kode'];
        $search = DosenTetapProdi::where('kode', $kodeprodi)->where('id', $request->id);

        if (!$search) {
            return response()->json([
                'message' => 'Dosen tidak ditemukan !'
            ], 404);
        }

        $query = $search->update([
            'kesesuaian_kompetensi' => $request->kes_kom,
            'kesesuaian_matakuliah' => $request->kes_mat,
            'matakuliah_prodi' => $request->mk_prodi,
            'matakuliah_prodi_lain' => $request->mk_prodi_lain,
        ]);

        if (!$query) {
            return response()->json([
                'message' => 'Server Error !'
            ], 500);
        }

        return response()->json([
            'message' => 'Dosen berhasil di Perbarui.'
        ], 200);


    }

    public function destroy(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = ['id' => 'required|integer'];
        $validasi = $request->validate($rules);

        //Cek Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        $data = DosenTetapProdi::whereId($request->id)->whereKode($kodeprodi)->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return response()->json(['message' => 'Data berhasil dihapus']);

    }
}
