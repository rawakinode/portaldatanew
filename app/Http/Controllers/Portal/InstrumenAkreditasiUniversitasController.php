<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\AkreditasiRekapUniversitas;


class InstrumenAkreditasiUniversitasController extends Controller
{
    public function index()
    {

        $data = collect();
        $check_data = AkreditasiRekapUniversitas::first();
        if ($check_data) {
            if (json_decode($check_data->instrumen_akreditasi_universitas, true)) {
                $json_data = json_decode($check_data->instrumen_akreditasi_universitas, true);
                $data = collect($json_data);
                $update = $check_data->updated_at;
            }else{
                return 404;
            }
            
        }else{
            return 404;
        }
        
        //Ke halaman tujuan
        return view('portaldata.instrumen_universitas.index', compact('data', 'update'));
    }
}
