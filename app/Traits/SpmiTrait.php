<?php

namespace App\Traits;

use App\Models\Pengaturan;
use App\Models\Subpengaturan;
use Illuminate\Http\Request;

trait SpmiTrait {

    use StatusPeriodeTrait;

    /**
     * @param Request $request
     * @return $this|false|string
     */
    
    protected function semuaPengaturanByTahun($periode) {
        return Pengaturan::whereTahun($periode)->get();
    }

    protected function semuaSubPengaturanByTahun($periode) {
        $pengaturan = $this->semuaPengaturanByTahun($periode);
        $pengaturan = $pengaturan->pluck('id');
        return Subpengaturan::whereIn('pengaturan_id', $pengaturan->all())->get();
    }

    protected function semuaSubPengaturanByTahunByRole($periode, $role){
        //Role sebagai '5' atau '2'
        $sub = $this->semuaSubPengaturanByTahun($periode);
        return $sub->where('role', $role);
    }

}