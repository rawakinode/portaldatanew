<?php

namespace App\Http\Controllers;

use App\Models\Activation;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodeController extends Controller
{
    //MENAMPILKAN HALAMAN PERIODE
    public function index()
    {
        $this->authorize('view kelola periode');

        $periode = Periode::orderBy('tahun', 'DESC')->get();
        $aktivasi = Activation::first();

        return view('admin.administrator.periode.periode', ['periode' => $periode, 'aktivasi' => $aktivasi]);
    }

    //MENAMBAHKAN TAHUN PERIODE
    public function store(Request $request)
    {
        $this->authorize('tambah periode');

        $data = $request->validate(['tahun' => 'required|unique:periodes,tahun|integer|digits:4']);
        $data['status'] = 0;

        DB::transaction(function () use ($data){ Periode::create($data); });

        return redirect()->back()->with('success', 'Berhasil menambahkan tahun periode.'); 
    }

    //MENGHAPUS TAHUN PERIODE
    public function destroy(Request $request)
    {
        $this->authorize('tambah periode');

        $periode = Periode::find($request->id);
        if (!$periode) { return redirect()->back()->withErrors('Periode salah.');}

        DB::transaction(function () use ($periode) { $periode->delete(); });

        return redirect()->back()->with('success', 'Berhasil menghapus tahun periode.');
    }

    //MEMILIH PERIODE YANG AKAN DI AKTIFKAN
    public function selectPeriode(Request $request)
    {
        $this->authorize('ubah periode aktif');

        $periode = Periode::find($request->id);
        if (!$periode) { return redirect()->back()->withErrors('Periode salah.');}

        DB::transaction(function () use ($periode) {
            $all = Periode::all();
            foreach ($all as $p) {
                $p->update(['status'=> 0]);
            }
            $periode->update(['status' => 1]);
        });

        return redirect()->back()->with('success', 'Berhasil mengganti tahun periode.');
    }

}
