<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaLulusController extends Controller
{
    public function index()
    {
        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        //Cek jika ada request
        if (request('tahun_masuk')) {
            $mahasiswa_lulus = Mahasiswa::whereKodeProdi($kodeprodi)->whereTahunMasuk(request('tahun_masuk'))->whereStatusKeluar('lulus')->orderBy('updated_at', 'DESC')->get();
        }else{
            $mahasiswa_lulus = Mahasiswa::whereKodeProdi($kodeprodi)->whereStatusKeluar('lulus')->orderBy('updated_at', 'DESC')->get();
        }

        return view('admin.pangkalan.mahasiswa_lulus.index', compact('mahasiswa_lulus'));
    }
}
