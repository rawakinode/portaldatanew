<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        //Cek jika ada request
        if (request('tahun_masuk')) {
            $mahasiswa = Mahasiswa::whereKodeProdi($kodeprodi)->whereTahunMasuk(request('tahun_masuk'))->whereDaftarUlang(request('daftar_ulang'))->orderBy('updated_at', 'DESC')->get();
        }else{
            $mahasiswa = Mahasiswa::whereKodeProdi($kodeprodi)->orderBy('updated_at', 'DESC')->get();
        }

        return view('admin.pangkalan.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('admin.pangkalan.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:100',
            'nim' => 'nullable|string|max:10',
            'kelamin' => 'required|integer|max:3',
            'bidikmisi' => 'required|boolean',
            'daftar_ulang' => 'required|integer|max:3',
            'jalur_masuk' => 'required|in:snmptn,sbmptn,smmptn,lainnya',
            'tahun_masuk' => 'required|integer',
            'tahun_keluar' => 'nullable|integer|digits:4',
            'status_keluar' => 'nullable|string|max:15',
            'asing' => 'required|boolean',
            'asing_part_time' => 'nullable|boolean',
            'ipk' => 'nullable|numeric|between:0.00,4.00',
            'masastudi' => 'nullable|integer|min:1',
            'tanggal_yudisium' => 'nullable|date',
        ];

        $validasi = $request->validate($rules);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;
        $validasi['nama'] = strtoupper($request->nama);

        DB::transaction(function () use ($validasi){
            Mahasiswa::create($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil menambahkan mahasiswa.');

    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.pangkalan.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama' => 'required|string|max:100',
            'nim' => 'nullable|string|max:10',
            'kelamin' => 'required|integer|max:3',
            'bidikmisi' => 'required|boolean',
            'daftar_ulang' => 'required|integer|max:3',
            'jalur_masuk' => 'required|in:snmptn,sbmptn,smmptn,lainnya',
            'tahun_masuk' => 'required|integer',
            'tahun_keluar' => 'nullable|integer',
            'status_keluar' => 'nullable|string|max:15',
            'asing' => 'required|boolean',
            'asing_part_time' => 'nullable|boolean',
            'ipk' => 'nullable|numeric|between:0.00,4.00',
            'masastudi' => 'nullable|integer|min:1',
            'tanggal_yudisium' => 'nullable|date',
        ];

        $validasi = $request->validate($rules);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['nama'] = strtoupper($request->nama);

        $data = Mahasiswa::findOrFail($id);

        if ($data['kode_prodi'] != $kodeprodi) { abort(404); }

        DB::transaction(function () use ($validasi, $data){
            $data->update($validasi);
        });
        
        return redirect()->back()->with('success', 'Berhasil memperbarui mahasiswa.');

    }

    public function destroy(Request $request)
    {

        $rules = ['id' => 'required|integer'];
        $request->validate($rules);

        //Cek Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = Mahasiswa::whereId($request->id)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus mahasiswa.');

    }
}
