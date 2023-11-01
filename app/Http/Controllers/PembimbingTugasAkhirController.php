<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\DosenHomebase;
use App\Models\Mahasiswa;
use App\Models\PembimbingTugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PembimbingTugasAkhirController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $pembimbing_tugas_akhir = PembimbingTugasAkhir::whereKodeProdi($kodeprodi)->with(['dosen_homebase'])->orderBy('updated_at', 'DESC')->get();

        return view('admin.pangkalan.pembimbing_tugas_akhir.index', compact('pembimbing_tugas_akhir'));
    }

    public function create()
    {
        return view('admin.pangkalan.pembimbing_tugas_akhir.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nim' => 'required|string|max:15',
            'nama_mahasiswa' => 'required|string|max:50',
            'nidn' => 'required|numeric|digits_between:4,20',
            'tahun' => 'required|integer|digits:4',
            'judul' => 'required|string|max:150',
            'nomor_sk_pembimbing' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:250',
        ];

        $validasi = $request->validate($rules);

        $kodeprodi = auth()->user()->prodi['kode'];

        if ($request->nidn) {
            $check_dosen = DosenHomebase::where('nidn', $request->nidn)->first();
            if (!$check_dosen) {
                return redirect()->back()->withErrors('Dosen dengan NIDN/NIDK tidak terdaftar di homebase, harap hubungi Admin Universitas.')->withInput();
            }
        }

        $validasi['kode_prodi'] = $kodeprodi;

        $random = Str::random(10).'-'.Str::random(10).'-'.Str::random(10).'-'.Str::random(10);
        $validasi['ids'] = strtolower($random);

        DB::transaction(function () use ($validasi) {
            PembimbingTugasAkhir::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan pembimbing tugas akhir.');
    }
    
    public function edit($ids)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $pembimbing_tugas_akhir = PembimbingTugasAkhir::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$pembimbing_tugas_akhir) { abort(404); }

        return view('admin.pangkalan.pembimbing_tugas_akhir.edit', compact('pembimbing_tugas_akhir'));
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'nim' => 'required|string|max:15',
            'nama_mahasiswa' => 'required|string|max:50',
            'nidn' => 'required|numeric|digits_between:4,20',
            'tahun' => 'required|integer|digits:4',
            'judul' => 'required|string|max:150',
            'nomor_sk_pembimbing' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:250',
        ];

        $kodeprodi = auth()->user()->prodi['kode'];

        $validasi = $request->validate($rules);

        if ($request->nidn) {
            $check_dosen = DosenHomebase::where('nidn', $request->nidn)->first();
            if (!$check_dosen) {
                return redirect()->back()->withErrors('Dosen dengan NIDN/NIDK tidak terdaftar di homebase, harap hubungi Admin Universitas.')->withInput();
            }
        }

        $pembimbing_tugas_akhir = PembimbingTugasAkhir::whereIds($ids)->whereKodeProdi($kodeprodi)->first();
        if (!$pembimbing_tugas_akhir) { abort(404); }

        DB::transaction(function () use ($validasi, $pembimbing_tugas_akhir) {
            $pembimbing_tugas_akhir->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui pembimbing tugas akhir.');
    }

    public function destroy(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        $data = PembimbingTugasAkhir::whereIds($request->ids)->whereKodeProdi($kodeprodi)->first();
        DB::transaction(function () use ($data){
            $data->delete();
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus pembimbing tugas akhir.');
    }
}
