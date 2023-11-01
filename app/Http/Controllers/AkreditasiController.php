<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Traits\StatusPeriodeTrait;

class AkreditasiController extends Controller
{
    use StatusPeriodeTrait;
    
    public function index()
    {
        //Permission Role Set
        $this->authorize('akreditasi');

        //Roles Checker
        $roles = $this->cekNamaRolesByUserLogin();
        if($roles == false){abort(403,"Role tidak ditemukan.");};

        $prodi = Prodi::orderBy('fakultas', 'ASC')->with('profil','faculty')->get();

        if ($roles == 'dekan') {

            $user_faculty = auth()->user()->faculty['code'];
            if (!$user_faculty) {abort(403, 'User tidak memiliki fakultas');}

            $prodi = $prodi->where('fakultas', $user_faculty);

        }

        $prodi = collect($prodi);

        return view('admin.universitas.akreditasi', ['akreditasi' => $prodi]);
        
        return $prodi;

        
    }
}
