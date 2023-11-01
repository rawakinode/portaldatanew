<?php

namespace App\Traits;

use App\Models\IsianEvaluasiTambahan;
use App\Models\IsianPengaturan;
use App\Models\Pengaturan;
use App\Models\Subpengaturan;
use Illuminate\Http\Request;
use App\Traits\StatusPeriodeTrait;
use Illuminate\Support\Facades\Storage;

trait PengaturanTrait {

    use StatusPeriodeTrait;

    /**
     * @param Request $request
     * @return $this|false|string
     */

    protected function cekJikaNamaPengaturanAda($nama, $periode) {

        $status = Pengaturan::whereNama($nama)->whereTahun($periode)->first();
        return $status ? true : false;
    }

    protected function cekJikaSubPengaturanAda($id) {

        $status = Subpengaturan::whereId($id)->first();
        return $status ? true : false;  
    }

    protected function cekPengaturanSamaSubPengaturan($slug,$id) {

        $periode = $this->cekperiode();
        if ($periode != false) {
            $cek = Subpengaturan::whereId($id)->with('pengaturan')->first();
            if ($cek) {
                if ($cek->pengaturan['tahun'] == $periode && $cek->pengaturan['nama'] == $slug) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function cekIsianExist($id, $periode, $kodeprodi)
    {
        $data = IsianPengaturan::where('subpengaturan_id', $id)->whereTahun($periode)->where('kode_prodi', $kodeprodi)->first();
        return $data ? $data : false;
    }

    protected function cariEvaluasiTambahan($id, $periode, $kodeprodi)
    {
        $data = IsianEvaluasiTambahan::where('subpengaturan_id', $id)->whereTahun($periode)->where('kode_prodi', $kodeprodi)->orderBy('id', 'ASC')->get();
        return $data ? $data : false;
    }

    protected function rulesValidasiDokumen($rules)
    {
        $rules['dokumen1'] = 'required|max:10000|mimes:pdf';
        $rules['dokumen2'] = 'max:10000|mimes:pdf';
        $rules['dokumen3'] = 'max:10000|mimes:pdf';
        $rules['dokumen4'] = 'max:10000|mimes:pdf';

        return $rules;
    }

    protected function setKodeProdiTahunValidasi($validasi, $kodeprodi, $periode)
    {
        $validasi['verifikasi'] = 0;
        $validasi['kode_prodi'] = $kodeprodi;
        $validasi['tahun'] = $periode;

        return $validasi;
    }

    protected function uploadDokumenPengaturan($request, $validasi)
    {
        if ($request->dokumen1) {
            $path = Storage::putFile('public', $request->file('dokumen1'));
            $validasi['dokumen1'] = $path;
        }

        if ($request->dokumen2) {
            $path = Storage::putFile('public', $request->file('dokumen2'));
            $validasi['dokumen2'] = $path;
        }
        if ($request->dokumen3) {
            $path = Storage::putFile('public', $request->file('dokumen3'));
            $validasi['dokumen3'] = $path;
        }

        if ($request->dokumen4) {
            $path = Storage::putFile('public', $request->file('dokumen4'));
            $validasi['dokumen4'] = $path;
        }

        return $validasi;
    }

    protected function hapusDokumenPengaturan($data, $validasi)
    {
        if ($data->dokumen1) {
            Storage::delete($data->dokumen1);
            $validasi['dokumen1'] = NULL;
        }

        if ($data->dokumen2) {
            Storage::delete($data->dokumen2);
            $validasi['dokumen2'] = NULL;
        }

        if ($data->dokumen3) {
            Storage::delete($data->dokumen3);
            $validasi['dokumen3'] = NULL;
        }

        if ($data->dokumen4) {
            Storage::delete($data->dokumen4);
            $validasi['dokumen4'] = NULL;
        }

        return $validasi;
    }


}