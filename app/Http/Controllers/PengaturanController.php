<?php

namespace App\Http\Controllers;

use App\Models\IsianEvaluasiTambahan;
use App\Models\IsianPengaturan;
use App\Models\Pengaturan;
use App\Models\Subpengaturan;
use App\Traits\PengaturanTrait;
use App\Traits\StatusPeriodeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    use StatusPeriodeTrait;
    use PengaturanTrait;

    //Menampilkan Halaman Pengaturan SPMI
    public function index($slug)
    {
        //Permission Role Set
        $this->authorize('view spmi');

        //Cek periode
        $kodeprodi = auth()->user()->prodi['kode'];
        $periode = $this->cekperiode();
        if ($periode == false) {abort(403, "Periode Tidak Ditemukan");}

        //Cek Slug Cocok atau tidak
        $check = Pengaturan::whereNama($slug)->whereTahun($periode)->get();
        if (count($check) == 0) {abort(404);}

        //Cek Roles dari User Login
        $role = $this->cekNamaRolesByUserLogin();
        if ($role == false) {abort(403, "Roles Tidak Ditemukan");}

        $pengaturan = Pengaturan::whereNama($slug)->whereTahun($periode)->with('sub_pengaturan')->first();

        if ($slug != 'evaluasi') {
            return view('admin.spmi.pengaturan', ['pengaturan'=>$pengaturan, 'url'=>$slug]);
        }else {

            $query = collect($pengaturan->sub_pengaturan)->where('tipe', '2')->first();
            $id = $query->id;
            $tambahan = $this->cariEvaluasiTambahan($id, $periode, $kodeprodi);

            //return $tambahan;
            return view('admin.spmi.pengaturan', ['pengaturan'=>$pengaturan, 'url'=>$slug, 'tambahan'=>$tambahan]);
        }
        
    }

    //Mengirim data input spmi
    public function store(Request $request, $slug)
    {
        //Permission Role Set
        $this->authorize('input spmi');

        //Cek Aktivasi
        $status = $this->cekstatus();
        if ($status == false) { return redirect()->back()->withErrors('Penginputan Belum Dibuka.');}

        $rules['jawaban'] = 'required|integer';

        if ($request->jawaban == 1) {
            $rules['tanggal'] = 'required|date_format:Y-m-d';
            $rules['subpengaturan_id'] = 'required|integer';
            $rules = $this->rulesValidasiDokumen($rules);
        }else {
            $rules['alasan'] = 'required|string|max:50';
            $rules['subpengaturan_id'] = 'required|integer';
        }

        $validasi = $request->validate($rules);

        //Cek periode & Prodi
        $periode = $this->cekperiode();
        $kodeprodi = auth()->user()->prodi['kode'];

        $cek_nama = $this->cekJikaNamaPengaturanAda($slug, $periode);
        $cek_sub_peng = $this->cekJikaSubPengaturanAda($request->subpengaturan_id);
        $cek_peng_sama_sub = $this->cekPengaturanSamaSubPengaturan($slug, $request->subpengaturan_id);

        $validasi = $this->setKodeProdiTahunValidasi($validasi, $kodeprodi, $periode);

        if ($slug == 'evaluasi') {
            $validasi['jawaban'] = 1;
        }

        if ($cek_nama == false || $cek_sub_peng == false || $cek_peng_sama_sub == false) {abort(403);}
        
        $cek_isian_exist = $this->cekIsianExist($request->subpengaturan_id, $periode, $kodeprodi);

        if ($cek_isian_exist == false) {
            //Input Baru
            DB::transaction(function () use ($validasi, $request)
            {
                $validasi = $this->uploadDokumenPengaturan($request, $validasi);
                IsianPengaturan::create($validasi);

            });
            
        }else{
            //Update Yang ada
            DB::transaction(function () use ($validasi, $request, $periode, $kodeprodi, $cek_isian_exist){

                $validasi = $this->hapusDokumenPengaturan($cek_isian_exist, $validasi);
                $validasi = $this->uploadDokumenPengaturan($request, $validasi);

                IsianPengaturan::where('subpengaturan_id', $request->subpengaturan_id)->whereTahun($periode)->where('kode_prodi', $kodeprodi)->update($validasi);
            });
        }

        return redirect()->back()->with('success', 'Berhasil Menambahkan.');
    }

    public function storeTambahan(Request $request)
    {
        //Permission Role Set
        $this->authorize('input spmi tambahan');

        //Cek Aktivasi
        $status = $this->cekstatus();
        if ($status == false) { return redirect()->back()->withErrors('Penginputan Belum Dibuka.');}

        $rules['judul'] = 'required|string|max:70';
        $rules['tanggal'] = 'required|date_format:Y-m-d';

        $rules = $this->rulesValidasiDokumen($rules);

        $validasi = $request->validate($rules);

        //Cek periode & Prodi
        $periode = $this->cekperiode();
        $kodeprodi = auth()->user()->prodi['kode'];
        
        $pengaturan_id = Pengaturan::whereNama('evaluasi')->whereTahun($periode)->first();
        if (!$pengaturan_id) { abort(403, 'id pengaturan tidak ada');}

        $role = $this->cekNamaRolesByUserLogin();
        if ($role == 'prodi') {$role = 5;} else {$role = 2;}

        $sub_pengaturan_id = Subpengaturan::where('pengaturan_id',$pengaturan_id->id)->whereTipe('2')->whereRole($role)->first();

        if (!$sub_pengaturan_id) { abort(403, 'id sub pengaturan tidak ada');}

        $validasi['subpengaturan_id'] = $sub_pengaturan_id->id;

        $maks = IsianEvaluasiTambahan::where('subpengaturan_id',$sub_pengaturan_id->id)->count();

        if ( $maks > 9) {
            return redirect()->back()->withErrors('Maksimal 10 Evaluasi Tambahan.');
        }

        $validasi = $this->setKodeProdiTahunValidasi($validasi, $kodeprodi, $periode);

        //Begin transactions
        DB::transaction(function () use ($request, $validasi) {
            $validasi = $this->uploadDokumenPengaturan($request, $validasi);
            IsianEvaluasiTambahan::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil Menambahkan.');
    }

    public function deleteTambahan(Request $request)
    {
        //Permission Role Set
        $this->authorize('input spmi tambahan');

        $request->validate(['id' => 'required|integer']);

        //Cek Aktivasi
        $status = $this->cekstatus();
        if ($status == false) { return redirect()->back()->withErrors('Penginputan Belum Dibuka.');}
        
        //Cek periode & Prodi
        $periode = $this->cekperiode();
        $kodeprodi = auth()->user()->prodi['kode'];

        $checking_id = IsianEvaluasiTambahan::where('kode_prodi', $kodeprodi)->whereTahun($periode)->whereId($request->id)->first();

        if (!$checking_id) {abort(403);}
        $data = [];

        //Mulai Transaksi
        DB::transaction(function () use ($checking_id, $data) {
            $this->hapusDokumenPengaturan($checking_id, $data);
            $checking_id->delete();
        });

        return redirect()->back()->with('success', 'Berhasil Menghapus Evaluasi Tambahan.');

    }

}
