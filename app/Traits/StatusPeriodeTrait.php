<?php

namespace App\Traits;

use App\Models\Activation;
use App\Models\Periode;
use Illuminate\Http\Request;

trait StatusPeriodeTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    
    protected function cekstatus() {

        $status = Activation::whereActivation(1)->first();
        return $status ? true : false;
    }

    protected function cekperiode()
    {
        $periode = Periode::whereStatus(1)->first();
        return $periode ? $periode->tahun : false;
        
    }

    protected function cekNamaRolesByUserLogin()
    {
        $users = auth()->user()->roles;
        return $users ? $users->first()->name : false;
    }

    protected function cekRolesByCodeDatabase()
    {
        $result = $this->cekNamaRolesByUserLogin();
        return $result == 'prodi' ? 5 : ($result == 'universitas' ? 2 : abort(403, "Hak Akses Tidak Ada."));
    }

}