<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Periode;
use App\Models\Prodi;
use App\Traits\PortalDataTrait;
use App\Traits\SpmiTrait;
use Illuminate\Http\Request;

class PortalDataController extends Controller
{
    use PortalDataTrait;
    use SpmiTrait;

    public function index_mahasiswa($url)
    {

        $periode = Periode::orderBy('tahun', 'DESC')->get();

        if ($url === 'aktif') {
            $judul = 'Data mahasiswa aktif';
            $subjudul = 'Mahasiswa aktif adalah mahasiswa yang telah membayar UKT dan mengisi KRS.';
        } else if($url === 'nonaktif'){
            $judul = 'Data mahasiswa non-aktif';
            $subjudul = 'Mahasiswa non-aktif adalah mahasiswa yang tidak membayar UKT, tidak mengisi KRS, dan tidak melapor.';
        } else if($url === 'cuti'){
            $judul = 'Data mahasiswa cuti';
            $subjudul = 'Mahasiswa aktif adalah mahasiswa yang berhasil mengajukan cuti akademik.';
        } else if($url === 'baru'){
            $judul = 'Data mahasiswa baru';
            $subjudul = 'Mahasiswa aktif adalah mahasiswa yang telah membayar UKT dan mengisi KRS.';
        } else if($url === 'lulus'){
            $judul = 'Data mahasiswa lulus';
            $subjudul = 'Mahasiswa aktif adalah mahasiswa yang telah membayar UKT dan mengisi KRS.';
        } else if($url === 'tepat_waktu'){
            $judul = 'Data mahasiswa lulus tepat waktu';
            $subjudul = 'Mahasiswa aktif adalah mahasiswa yang telah membayar UKT dan mengisi KRS.';
        } else if($url === 'bidikmisi'){
            $judul = 'Data mahasiswa bidikmisi';
            $subjudul = 'Mahasiswa aktif adalah mahasiswa yang telah membayar UKT dan mengisi KRS.';
        } else if($url === 'tugas_akhir'){
            $judul = 'Data mahasiswa tugas akhir';
            $subjudul = 'Mahasiswa aktif adalah mahasiswa yang telah membayar UKT dan mengisi KRS.';
        } else{
            abort(404);
        }

        return view('portaldata.mahasiswa', [
            'url' => $url,
            'judul' => $judul,
            'subjudul' => $subjudul,
            'periode' => $periode
        ]);

    }

    public function index_dosen()
    {
        $periode = Periode::orderBy('tahun', 'DESC')->get();
        return view('portaldata.dosen', ['periode' => $periode]);
    }

    public function get_dosen(Request $request)
    {
        $periode = $request->tahun;

        //Tampilkan Fakultas dan prodi dan Dosen Berdasarkan tahun
        $dosen = Faculty::with(['prodi' => function ($query) use ($periode){
            $query->with(['dosen' => function ($query) use ($periode) {
                $query->where('tahun', $periode);
            }]);
        }])->get();
        
        foreach ($dosen as $d) {
            $d['dosen'] = collect([]);
            foreach ($d->prodi as $p) {
                $this->getSaringData($p);
                foreach ($p->dosen as $ds) { $d['dosen']->push($ds); }         
            }
            $this->getSaringData($d);
        }

        return $dosen;
    }

    public function get_prodi(Request $request)
    {
        if ($request->fakultas !== 0) {
            return Prodi::where('fakultas', $request->fakultas)->get();
        }else { return abort(403); }
    }

    public function mahasiswa_get(Request $request)
    {
        $fakultas = $request->fakultas; //opsional
        $periode = $request->tahun; //wajib ada
        $jenjang = $request->jenjang; //opsional
        $tambahans = 'jumlah_mahasiswa';
        $url = $request->url;

        $data = [];

        //Query Permintaan data Semua Fakultas dan Semua Jenjang
        if ($fakultas == 0 && $jenjang == null) {

            $data = Faculty::with(['prodi' => function ($query) use ($periode){
                $query->with(['mahasiswa' => function ($query) use ($periode) {
                    $query->where('tahun', $periode);
                }]);
            }])->get();
        }

        //Jika Jenjang bukan Semua
        if ($fakultas == 0 && $jenjang != null) {

            $data = Faculty::with(['prodi' => function ($query) use ($jenjang, $periode){
                $query->where('jenjang', $jenjang)->with(['mahasiswa' => function ($query) use ($periode) {
                    $query->where('tahun', $periode);
                }]);
            }])->get();
        }

        //Jika Fakultas bukan Semua
        if ($fakultas != 0 && $jenjang == null) {

            $data = Faculty::where('code', $fakultas)->with(['prodi' => function ($query) use ($periode){
                $query->with(['mahasiswa' => function ($query) use ($periode) {
                    $query->where('tahun', $periode);
                }]);
            }])->get();
        }

        //Jika Fakultas dan Jenjang dipilih
        if ($fakultas != 0 && $jenjang != null) {

            $data = Faculty::where('code', $fakultas)->with(['prodi' => function ($query) use ($jenjang, $periode){
                $query->where('jenjang', $jenjang)->with(['mahasiswa' => function ($query) use ($periode) {
                    $query->where('tahun', $periode);
                }]);
            }])->get();
        }

        foreach ($data as $p ) {
            $p[$tambahans] = 0;
            foreach ($p->prodi as $m) {
                $tmp = $m->mahasiswa->first();
                $m[$tambahans] = $tmp[$url] ?? 0;
                $p[$tambahans] += $m[$tambahans];
            }
        }

        return $data->all();
    }

    public function index_spmi()
    {
        $periode = Periode::orderBy('tahun', 'DESC')->get();
        return view('portaldata.spmi', ['periode' => $periode]);
    }

    public function get_spmi(Request $request)
    {
        $periode = $request->tahun;
        $semuasub = $this->semuaSubPengaturanByTahunByRole($periode, 5);
        $total_sub = $semuasub->count();

        $data = Faculty::with(['prodi' => function ($query) use ($periode) {
            $query->with(['isian' => function ($query) use ($periode) {
                $query->where('tahun', $periode);
            }]);
        }])->get();

        foreach ($data as $fk) {
            $fk['isian_jumlah'] = 0;
            $fk['isian_jawaban_ada'] = 0;
            $fk['isian_jawaban_tidak_ada'] = 0;
            $fk['isian_jawaban_verifikasi_belum'] = 0;
            $fk['isian_jawaban_verifikasi_diterima'] = 0;
            $fk['isian_jawaban_verifikasi_ditolak'] = 0;
            $fk['jumlah_prodi'] = $fk->prodi->count();

            foreach ($fk->prodi as $pr) {
                $pr['isian_jumlah'] = $pr['isian']->count();
                $pr['isian_jawaban_ada'] = $pr['isian']->where('jawaban', 1)->count();
                $pr['isian_jawaban_tidak_ada'] = $pr['isian']->where('jawaban', 0)->count();
                $pr['isian_jawaban_verifikasi_belum'] = $pr['isian']->where('verifikasi', 0)->count();
                $pr['isian_jawaban_verifikasi_diterima'] = $pr['isian']->where('verifikasi', 1)->count();
                $pr['isian_jawaban_verifikasi_ditolak'] = $pr['isian']->where('verifikasi', 2)->count();
                $fk['isian_jumlah'] += $pr['isian']->count();
                $fk['isian_jawaban_ada'] += $pr['isian']->where('jawaban', 1)->count();
                $fk['isian_jawaban_tidak_ada'] += $pr['isian']->where('jawaban', 0)->count();
                $fk['isian_jawaban_verifikasi_belum'] += $pr['isian']->where('verifikasi', 0)->count();
                $fk['isian_jawaban_verifikasi_diterima'] += $pr['isian']->where('verifikasi', 1)->count();
                $fk['isian_jawaban_verifikasi_ditolak'] += $pr['isian']->where('verifikasi', 2)->count() ;
            }
        }

        return response()->json([
            'total_subs' => $total_sub,
            'data' => $data,
        ]);
    }

}
