<?php

namespace App\Traits;

use App\Models\Activation;
use App\Models\Pengaturan;
use App\Models\Periode;
use App\Models\Subpengaturan;
use App\Models\User;
use Illuminate\Http\Request;

trait ImportSpmiTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    
     protected function hapusPengaturanSubPengaturan($pengaturan)
     {
        foreach ($pengaturan as $p) {
            $sub = Subpengaturan::where('pengaturan_id', $p->id)->get();
            foreach ($sub as $s) {
                $s->delete();
            }
            $p->delete();
        }
     }

     protected function buatPengaturanSubPengaturan($periode)
     {
        //Menambahkan Pengaturan
        $a = Pengaturan::create(['nama' => 'penetapan', 'urutan' => 1, 'tahun' => $periode]);
        $b = Pengaturan::create(['nama' => 'pelaksanaan', 'urutan' => 2, 'tahun' => $periode]);
        $c = Pengaturan::create(['nama' => 'pengendalian', 'urutan' => 3, 'tahun' => $periode]);
        $d = Pengaturan::create(['nama' => 'peningkatan', 'urutan' => 4, 'tahun' => $periode]);
        $e = Pengaturan::create(['nama' => 'evaluasi', 'urutan' => 5, 'tahun' => $periode]);

        //Menambahkan Sub-Pengaturan
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Pengelolaan SPMI Program Studi', 'berkas' => 'SK Pengelola SPMI' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Organisasi Pengelola SPMI Program Studi', 'berkas' => 'SK Pembentukan UPM s/d GKM' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Kelengkapan Dokumen SPMI Program Studi', 'berkas' => '4 Dokumen : Kebijakan SPMI, Manual SPMI, Standar SPMI, Formular SPMI' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Penetapan Pengelola Gugus Kendali Mutu (GKM) ', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 5, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Penetapan Struktur Pengelola Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 6, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Penetapan Tupoksi GKM Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 7, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Penetapan Daftar SDM yang Mengikuti Sosialisasi SPMI', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 8, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Penetapan Daftar Auditor Internal Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 9, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Penetapan Kebijakan SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 10, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Penetapan Manual SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 11, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Penetapan Standar SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 12, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Penetapan Formulir SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 13, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Penetapan SOP bidang Akademik Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 14, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Penetapan SOP bidang Non Akademik Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 15, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Penetapan Instruksi Kerja Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 16, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 5, 'judul' => 'Pengaturan Penetapan Renstra Mutu/program kerja UPM Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $e->id, 'role' => 5, 'judul' => 'Fungsi pengawasan yang terintegrasi sesuai fungsi organisasi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $e->id, 'role' => 5, 'judul' => 'Wawancara', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $e->id, 'role' => 5, 'judul' => 'Evaluasi diri', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $e->id, 'role' => 5, 'judul' => 'Survey', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 1, 'pengaturan_id' => $e->id, 'role' => 5, 'judul' => 'Praktik Baik atau Mekanisme', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 1, 'pengaturan_id' => $e->id, 'role' => 5, 'judul' => 'Temuan', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 1, 'pengaturan_id' => $e->id, 'role' => 5, 'judul' => 'Rekomendasi peningkatan mutu', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 2, 'pengaturan_id' => $e->id, 'role' => 5, 'judul' => 'evaluasi tambahan', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $b->id, 'role' => 5, 'judul' => 'Pengaturan Pelaksanaan Standar SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $b->id, 'role' => 5, 'judul' => 'Pengaturan Pelaksanaan Kebijakan SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $b->id, 'role' => 5, 'judul' => 'Pengaturan Pelaksanaan Manual SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $b->id, 'role' => 5, 'judul' => 'Pengaturan Pelaksanaan Rekaman Formulir SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 5, 'judul' => 'Pengaturan terkait pengendalian pelaksanaan standar Program Studi', 'berkas' => 'Panduan Pelaksanaan Pengendalian (RTM = Rapat Tinjauan Manajemen)' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 5, 'judul' => 'Permintaan tindakan koreksi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 5, 'judul' => 'Laporan tindak lanjut hasil audit mutu internal', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 5, 'judul' => 'Laporan refleksi hasil audit internal', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 5, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 5, 'judul' => 'Laporan rapat tinjauan manajemen', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $d->id, 'role' => 5, 'judul' => 'Pengaturan terkait peningkatan dokumen standar dalam SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $d->id, 'role' => 5, 'judul' => 'Pengaturan terkait peningkatan dokumen kebijakan dalam SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $d->id, 'role' => 5, 'judul' => 'Pengaturan terkait peningkatan dokumen manual dalam SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $d->id, 'role' => 5, 'judul' => 'Pengaturan terkait peningkatan dokumen formulir dalam SPMI Program Studi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $e->id, 'role' => 2, 'judul' => 'Fungsi pengawasan yang terintegrasi sesuai fungsi organisasi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $e->id, 'role' => 2, 'judul' => 'Wawancara', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $e->id, 'role' => 2, 'judul' => 'Evaluasi diri', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $e->id, 'role' => 2, 'judul' => 'Survey', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 1, 'pengaturan_id' => $e->id, 'role' => 2, 'judul' => 'Praktik Baik atau Mekanisme', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 1, 'pengaturan_id' => $e->id, 'role' => 2, 'judul' => 'Temuan', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 1, 'pengaturan_id' => $e->id, 'role' => 2, 'judul' => 'Rekomendasi peningkatan mutu', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 2, 'pengaturan_id' => $e->id, 'role' => 2, 'judul' => 'evaluasi tambahan', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $d->id, 'role' => 2, 'judul' => 'Pengaturan terkait peningkatan dokumen standar dalam SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $d->id, 'role' => 2, 'judul' => 'Pengaturan terkait peningkatan dokumen kebijakan dalam SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $d->id, 'role' => 2, 'judul' => 'Pengaturan terkait peningkatan dokumen manual dalam SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $d->id, 'role' => 2, 'judul' => 'Pengaturan terkait peningkatan dokumen formulir dalam SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 2, 'judul' => 'Pengaturan terkait pengendalian pelaksanaan standar Universitas', 'berkas' => 'Panduan Pelaksanaan Pengendalian (RTM = Rapat Tinjauan Manajemen)' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 2, 'judul' => 'Permintaan tindakan koreksi', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 2, 'judul' => 'Laporan tindak lanjut hasil audit mutu internal', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 2, 'judul' => 'Laporan refleksi hasil audit internal', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 5, 'tipe' => 0, 'pengaturan_id' => $c->id, 'role' => 2, 'judul' => 'Laporan rapat tinjauan manajemen', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $b->id, 'role' => 2, 'judul' => 'Pengaturan Pelaksanaan Standar SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $b->id, 'role' => 2, 'judul' => 'Pengaturan Pelaksanaan Kebijakan SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $b->id, 'role' => 2, 'judul' => 'Pengaturan Pelaksanaan Manual SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $b->id, 'role' => 2, 'judul' => 'Pengaturan Pelaksanaan Rekaman Formulir SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 1, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Pengelolaan SPMI Universitas', 'berkas' => 'SK Pengelola LPPMP' ]);
        Subpengaturan::create([ 'urutan' => 2, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Organisasi Pengelola SPMI Universitas', 'berkas' => 'SK Pembentukan LPPMP' ]);
        Subpengaturan::create([ 'urutan' => 3, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Kelengkapan Dokumen SPMI Universitas', 'berkas' => '4 Dokumen : Kebijakan SPMI, Manual SPMI, Standar SPMI, Formular SPMI' ]);
        Subpengaturan::create([ 'urutan' => 4, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Penetapan Pengelola LPPMP Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 5, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Penetapan Struktur Pengelola LPPMP Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 6, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Penetapan Tupoksi LPPMP Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 7, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Penetapan Daftar SDM yang Mengikuti Sosialisasi SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 8, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Penetapan Daftar Auditor Internal Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 9, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Penetapan Kebijakan SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 10, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Penetapan Manual SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 11, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Penetapan Standar SPMI Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 12, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Penetapan Formulir Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 13, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Penetapan SOP bidang Akademik Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 14, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Penetapan SOP bidang Non Akademik Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 15, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Penetapan Instruksi Kerja Universitas', 'berkas' => 'PDF' ]);
        Subpengaturan::create([ 'urutan' => 16, 'tipe' => 0, 'pengaturan_id' => $a->id, 'role' => 2, 'judul' => 'Pengaturan Penetapan Renstra Mutu/program kerja UPM Universitas', 'berkas' => 'PDF' ]);
     }

}