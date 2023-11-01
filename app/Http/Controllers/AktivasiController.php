<?php

namespace App\Http\Controllers;

use App\Models\Activation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AktivasiController extends Controller
{
    //MENGUBAH AKTIVASI
    public function update(Request $request)
    {
        $this->authorize('ubah aktivasi');

        $aktivasi = Activation::first();

        DB::transaction(function () use ($aktivasi){
            if ($aktivasi->activation == 1) {
                $aktivasi->update([ 'activation' => 0 ]);
            }else{
                $aktivasi->update([ 'activation' => 1 ]);
            }
        }); 

        return redirect()->back()->with('success', 'Berhasil menyimpan perubahan.');
    }
}
