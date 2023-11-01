<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Periode;
use App\Traits\ImportSpmiTrait;
use App\Traits\StatusPeriodeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SPMIController extends Controller
{

    use StatusPeriodeTrait;
    use ImportSpmiTrait;

    public function index()
    {
        $this->authorize('view kelola spmi');

        $periode = $this->cekperiode();
        if ($periode == false) {abort(403, "Periode Tidak Ditemukan");}

        $pengaturan = Pengaturan::whereTahun($periode)->with(['subpengaturan' => function ($query) {
            $query->where('role', 5)->get();
        }])->get();

        return view('admin.administrator.spmi.spmi', compact('pengaturan'));
    }

    public function import()
    {
        $this->authorize('view kelola spmi');

        $periode = $this->cekperiode();
        if ($periode == false) {abort(403, "Periode Tidak Ditemukan");}

        $pengaturan = Pengaturan::whereTahun($periode)->get();

        DB::transaction(function () use ($pengaturan, $periode) {
            $this->hapusPengaturanSubPengaturan($pengaturan);
            $this->buatPengaturanSubPengaturan($periode); 
        });
        
        return redirect()->back()->with('success', 'Berhasil meng-import Pengaturan SPMI.');
    }
}
