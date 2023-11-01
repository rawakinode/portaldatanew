<?php

namespace App\Http\Controllers;

use App\Models\IsianEvaluasiTambahan;
use Illuminate\Http\Request;
use App\Models\IsianPengaturan;
use App\Models\Pengaturan;
use App\Models\Prodi;
use App\Traits\PengaturanTrait;
use App\Traits\SpmiTrait;
use App\Traits\StatusPeriodeTrait;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ValidasiController extends Controller
{
    use SpmiTrait;
    use StatusPeriodeTrait;
    use PengaturanTrait;

    public function index()
    {
        $this->authorize('view rincian validasi');

        $prodi = Prodi::orderBy('fakultas', 'ASC')->with('faculty')->get();
        
        $periode = $this->cekperiode();
        $semuasub = $this->semuaSubPengaturanByTahunByRole($periode, 5);

        foreach ($prodi as $p) {
            $semuaisian = IsianPengaturan::whereTahun($periode)->where('kode_prodi', $p->kode)->get();
            if ($semuasub->count()) {
                $p['jumlah_isian'] = round($semuaisian->count() / $semuasub->count() * 100);
            }else {
                $p['jumlah_isian'] = 0;
            }
        }

        $prodi = $prodi->sortByDesc('jumlah_isian');

        return view('admin.administrator.validasi.index', ['prodi' => $prodi]);
    }

    public function show($id)
    {
        $this->authorize('view rincian validasi');

        $id = Crypt::decryptString($id);

        $periode = $this->cekperiode();
        if ($periode == false) {abort(403, "Periode Tidak Ditemukan");}

        $prodi = Prodi::whereKode($id)->first();
        if (!$prodi) {abort(403, "Prodi Tidak Ditemukan");}

        //Mencari semua pengaturan
        $pengaturan = Pengaturan::whereTahun($periode)->with(['subpengaturan' => function ($query) use ($id) {
            $query->whereRole('5')->orderBy('urutan', 'ASC')->with([
                'isian_by_prodi' => function ($query) use ($id) { $query->where('kode_prodi', $id); }
            ]);
        }])->get();

        if (!$pengaturan->count()) {
            abort(403, 'Pengaturan Tidak Ada');
        }
        //Mencari Evaluasi Tambahan
        $evaluasi = $pengaturan->where('nama','evaluasi')->first();
        $evaluasi = $evaluasi->subpengaturan->where('tipe', '2')->first();
        $tambahan = $this->cariEvaluasiTambahan($evaluasi->id, $periode, $id);

        return view('admin.administrator.validasi.validasi', [
            'pengaturan' => $pengaturan,
            'prodi' => $prodi,
            'tambahan' => $tambahan
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('konfirmasi validasi');

        $request->validate([
            'id' => 'required|integer',
            'verifikasi' => 'required|integer|min:0|max:2',
            'komentar' => 'nullable|string|max:100',
            'tambahan' => 'required|boolean'
        ]);

        if ($request->tambahan == 0) {
            $isian = IsianPengaturan::find($request->id);
        } else {
            $isian = IsianEvaluasiTambahan::find($request->id);
        }
        
        DB::transaction(function () use ($isian, $request){
           $isian->update([
                'verifikasi' => $request->verifikasi,
                'komentar' => $request->komentar,
           ]);  
        });
        
        return redirect()->back()->with('success', 'Berhasil menverifikasi.');
    }

    
}
