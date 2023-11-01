<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InstrumenAkreditasi;
use App\Models\InstrumenAkreditasiSelected;
use Illuminate\Http\Request;

class InstrumenAkreditasiController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $instrumen = InstrumenAkreditasi::with(['instrumen_terpilih' => function ($query) use ($kodeprodi){
            return $query->whereKodeProdi($kodeprodi);
        }])->get();

        return view('admin.pangkalan.instrumen.index', compact('instrumen'));
    }

    public function update(Request $request)
    {
        $kodeprodi = auth()->user()->prodi['kode'];

        $instrumen = InstrumenAkreditasi::all();

        $selectedInstrumen = $request->input('instrumen', []);

        foreach ($instrumen as $key) {

            $checks = InstrumenAkreditasiSelected::whereSlug($key->slug)->whereKodeProdi($kodeprodi)->first();
            if (!$checks) {
                $checks = InstrumenAkreditasiSelected::create([
                    'kode_prodi' => $kodeprodi,
                    'slug' => $key->slug,
                    'status' => false,
                ]);
            }
            
        	$newStatus = in_array($key->slug, $selectedInstrumen);

        	$checks->status = $newStatus;
        	$checks->save();
        }

        return redirect()->back();
    }
}
