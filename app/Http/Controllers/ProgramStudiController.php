<?php

namespace App\Http\Controllers;

use App\Models\IsianPengaturan;
use App\Models\Prodi;
use App\Traits\SpmiTrait;
use App\Traits\StatusPeriodeTrait;

class ProgramStudiController extends Controller
{
    use StatusPeriodeTrait;
    use SpmiTrait;

    public function index()
    {
        //Permission Role Set
        $this->authorize('view program studi');

        //Roles Checker
        $roles = $this->cekNamaRolesByUserLogin();
        if($roles == false){abort(403,"Role tidak ditemukan.");};

        $prodi = Prodi::orderBy('fakultas', 'ASC')->with('faculty')->get();
        
        if ($roles == 'dekan') {

            $user_faculty = auth()->user()->faculty['code'];
            if (!$user_faculty) {abort(403, 'User tidak memiliki fakultas');}

            $prodi = $prodi->where('fakultas', $user_faculty);

        }

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

        return view('admin.universitas.programstudi', ['prodi' => $prodi]);
       
    }
}
