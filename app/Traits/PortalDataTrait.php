<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait PortalDataTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    
    protected function saringDataDosenBerdasarkanNilai($p, $sort, $by, $name)
    {
        $temporary = collect([]);
        foreach ($sort as $pp) {
            //Melakukan Push data ke $temporay
            $temporary->push($p->dosen->where($by, $pp)->count());
        }
        //Melakukan kombinasi data
        $p[$name] = $sort->combine($temporary);
    }

    protected function getSaringData($p)
    {
        //Mendapatkan jumlah dosen berdasarkan Key
        $sort_by = collect([1,2,3,4]);
        $this->saringDataDosenBerdasarkanNilai($p, $sort_by, 'pendidikan', 'dosen_pendidikan');
        $sort_by = collect([0,1]);
        $this->saringDataDosenBerdasarkanNilai($p, $sort_by, 'kelamin', 'dosen_kelamin');
        $sort_by = collect([1,2,3,4]);
        $this->saringDataDosenBerdasarkanNilai($p, $sort_by, 'fungsional', 'dosen_fungsional');
        $sort_by = collect(['III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e']);
        $this->saringDataDosenBerdasarkanNilai($p, $sort_by, 'golongan', 'dosen_golongan');
    }
}