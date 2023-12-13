<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Dosen;
use App\Models\DosenHomebase;
use App\Models\DosenTetapProdi;
use App\Models\DosenTidakTetap;
use App\Models\Hki;
use App\Models\InstrumenAkreditasi;
use App\Models\KepuasanMahasiswa;
use App\Models\Kerjasama;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\PenggunaLulusan;
use App\Models\PeralatanLaboratorium;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Prodi;
use App\Models\Produk;
use App\Models\Publikasi;
use App\Models\Rekognisi;
use App\Models\SeleksiMahasiswaBaru;
use App\Models\StatusMahasiswa;
use App\Models\TSProdi;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class InstrumenAkreditasiProdiController extends Controller
{

    public function list()
    {
        $prodi = Prodi::orderBy('fakultas', 'ASC')->orderBy('jenjang', 'DESC')->with('faculty')->with(['tabel_instrumen' => function ($query) {
            return $query->whereStatus('1');
        }])->get();

        return view('portaldata.instrumen', compact('prodi'));
    }

    public function index($id)
    {
        //Set variabel
        $data = [];
        $kodeprodi = $id;

        if (!Prodi::where('kode', $kodeprodi)->first()) {
            abort('404');
        }

        //Atur periode dan ts
        $periode = TSProdi::where('kode_prodi', $kodeprodi)->first();
        if (!$periode) {
            return "Error! Periode TS belum diatur.";
        }
        
        $ts = $periode['tahun'];

        //Mendapatkan daftar tabel instrumen yang di centang oleh prodi
        $get_instrumen = InstrumenAkreditasi::with(['instrumen_terpilih' => function ($query) use ($kodeprodi) {
            return $query->where('status', '1')->where('kode_prodi', $kodeprodi);
        }])->get();

        $new_instrumen = collect();

        foreach ($get_instrumen as $ops) {
            if (isset($ops['instrumen_terpilih']['status']) && $ops['instrumen_terpilih']['status'] == 1) {
                $new_instrumen->push($ops);
            }
        }

        foreach ($new_instrumen as $item) {

            //TABEL KERJASAMA
            if ($item['slug'] == 'kerjasama') {
                $search = Kerjasama::where('kode_prodi', $kodeprodi)->get();
                $data['kerjasama'] = $search;
            }

            //TABEL SELEKSI MAHASISWA BARU
            if ($item['slug'] == 'seleksi') {
                $tahun_ts = [0, 1, 2, 3, 4];
                $tabel = [];

                $seleksi_mahasiswa = SeleksiMahasiswaBaru::where('kode_prodi', $kodeprodi)->orderBy('tahun', 'DESC')->get();

                foreach ($tahun_ts as $i => $value) {

                    $ts_fix = $ts + $i - 4;

                    $seleksi = $seleksi_mahasiswa->where('tahun', $ts_fix)->first();
                    if ($seleksi) {
                        $tabel[] = [
                            'daya_tampung' => $seleksi['daya_tampung'],
                            'pendaftar' => $seleksi['mahasiswa_mendaftar'],
                            'lulus_seleksi' => $seleksi['mahasiswa_lulus_seleksi'],
                            'baru_reguler' => $seleksi['mahasiswa_baru_reguler'],
                            'baru_transfer' => $seleksi['mahasiswa_baru_transfer'],
                            'reguler' => $seleksi['mahasiswa_aktif_reguler'],
                            'transfer' => $seleksi['mahasiswa_aktif_transfer'],
                        ];
                    }else{
                        $tabel[] = [
                            'daya_tampung' => 0,
                            'pendaftar' => 0,
                            'lulus_seleksi' => 0,
                            'baru_reguler' => 0,
                            'baru_transfer' => 0,
                            'reguler' => 0,
                            'transfer' => 0,
                        ];
                    }

                }

                $data['seleksi_mahasiswa_baru'] = $tabel;
            }

            //TABEL MAHASISWA ASING
            if ($item['slug'] == 'asing') {
                $tahun_ts = ['ts2', 'ts1', 'ts'];
                $tabel = [];

                $mahasiswa = Mahasiswa::where('daftar_ulang', 1)->where('kode_prodi', $kodeprodi)->where('asing', 1)->whereBetween('tahun_masuk', [$ts - 2, $ts])->get();

                //dd($mahasiswa->where('tahun_masuk', $ts + 0 - 2)->where('asing_part_time', 0)->count());

                foreach ($tahun_ts as $key => $i) {

                    $tabel[] = [
                        'mahasiswa_asing_fulltime' => $mahasiswa->where('tahun_masuk', $ts + $key - 2)->where('asing_part_time', 0)->count(),
                        'mahasiswa_asing_parttime' => $mahasiswa->where('tahun_masuk', $ts + $key - 2)->where('asing_part_time', 1)->count(),
                    ];
                }

                $data['mahasiswa_asing'] = $tabel;
            }

            //TABEL DOSEN TETAP
            if ($item['slug'] == 'dtpt') {
                $dosen = DosenTetapProdi::where('kode', $kodeprodi)->get();
                $data['dosen_tetap'] = $dosen;
            }

            //DOSEN PEMBIMBING UTAMA
            if ($item['slug'] == 'dosen_pembimbing_utama') {
                $dosen = DosenTetapProdi::where('kode', $kodeprodi)->with(['pembimbing' => function ($query) use ($ts) {
                    return $query->whereBetween('tahun', [$ts - 2, $ts]);
                }])->get();

                $dosen = $dosen->map(function ($item) use ($ts) {
                    $item['ts2'] = $item['pembimbing']->where('tahun', $ts - 2)->count();
                    $item['ts1'] = $item['pembimbing']->where('tahun', $ts - 1)->count();
                    $item['ts'] = $item['pembimbing']->where('tahun', $ts)->count();
                    $item['rata'] = ($item['ts2'] + $item['ts1'] + $item['ts']) / 3;
                    return $item;
                });

                $data['dosen_pembimbing_utama'] = $dosen;
            }

            //EKUIVALENSI
            // if ($item['slug'] == 'ewmp') {

            // }

            //DOSEN TIDAK TETAP
            if ($item['slug'] == 'dosen_tt') {
                $dosen = DosenTidakTetap::where('kode', $kodeprodi)->get();
                $data['dosen_tidak_tetap'] = $dosen;
            }

            //DOSEN INDUSTRI / PRAKTISI
            if ($item['slug'] == 'dosen_industri') {
                $dosen = DosenTidakTetap::where('kode', $kodeprodi)->whereNotNull('industri_praktisi')->get();
                $data['dosen_industri'] = $dosen;
            }

            //REKOGNISI PENGAKUAN DOSEN TETAP
            if ($item['slug'] == 'rekognisi_dtps') {
                $rekognisi = Rekognisi::where('kode_prodi', $kodeprodi)->with(['dosens' => function ($query) use ($kodeprodi) {
                    return $query->where('kode', $kodeprodi);
                }])->get();
                $data['rekognisi_dosen'] = $rekognisi;
            }

            //PENELITIAN DOSEN
            if ($item['slug'] == 'penelitian_dtps') {
                $sumber = ['Perguruan Tinggi / Mandiri', 'Lembaga Dalam Negeri (diluar PT)', 'Lembaga Luar Negeri', 'TOTAL'];
                $tabel = [];
                foreach ($sumber as $k) {
                    $tabel[] = [
                        'nama' => $k,
                        'ts2' => 0,
                        'ts1' => 0,
                        'ts' => 0,
                        'jumlah' => 0,
                    ];
                }

                $penelitian = Penelitian::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->get();

                foreach ($penelitian as $p) {

                    $select_tahun = null;
                    if ($p['tahun'] == $ts - 2) {
                        $select_tahun = 'ts2';
                    } else if ($p['tahun'] == $ts - 1) {
                        $select_tahun = 'ts1';
                    } else if ($p['tahun'] == $ts) {
                        $select_tahun = 'ts';
                    }

                    $select_sumber = -1;
                    if ($p['sumber_dana'] == 'mandiri' || $p['sumber_dana'] == 'perguruan tinggi') {
                        $select_sumber = 0;
                    } else if ($p['sumber_dana'] == 'nasional') {
                        $select_sumber = 1;
                    } else if ($p['sumber_dana'] == 'internasional') {
                        $select_sumber = 2;
                    }

                    if ($select_sumber != -1 && $select_tahun != null) {
                        $tabel[$select_sumber][$select_tahun] += 1;

                        $tabel[count($sumber) - 1][$select_tahun] += 1;
                        $tabel[$select_sumber]['jumlah'] += 1;
                        $tabel[count($sumber) - 1]['jumlah'] += 1;
                    }
                }

                $data['penelitian'] = $tabel;
            }

            //PENGABDIAN DOSEN
            if ($item['slug'] == 'pengabdian_dtps') {
                $sumber = ['Perguruan Tinggi / Mandiri', 'Lembaga Dalam Negeri (diluar PT)', 'Lembaga Luar Negeri', 'TOTAL'];
                $tabel = [];
                foreach ($sumber as $k) {
                    $tabel[] = [
                        'nama' => $k,
                        'ts2' => 0,
                        'ts1' => 0,
                        'ts' => 0,
                        'jumlah' => 0,
                    ];
                }

                $pengabdian = Pengabdian::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->get();

                foreach ($pengabdian as $p) {

                    $select_tahun = null;
                    if ($p['tahun'] == $ts - 2) {
                        $select_tahun = 'ts2';
                    } else if ($p['tahun'] == $ts - 1) {
                        $select_tahun = 'ts1';
                    } else if ($p['tahun'] == $ts) {
                        $select_tahun = 'ts';
                    }

                    $select_sumber = -1;
                    if ($p['sumber_dana'] == 'mandiri' || $p['sumber_dana'] == 'perguruan tinggi') {
                        $select_sumber = 0;
                    } else if ($p['sumber_dana'] == 'nasional') {
                        $select_sumber = 1;
                    } else if ($p['sumber_dana'] == 'internasional') {
                        $select_sumber = 2;
                    }

                    if ($select_sumber != -1 && $select_tahun != null) {
                        $tabel[$select_sumber][$select_tahun] += 1;

                        $tabel[count($sumber) - 1][$select_tahun] += 1;
                        $tabel[$select_sumber]['jumlah'] += 1;
                        $tabel[count($sumber) - 1]['jumlah'] += 1;
                    }
                }

                $data['pengabdian'] = $tabel;
            }

            //PUBLIKASI DOSEN
            if ($item['slug'] == 'publikasi_dtps') {
                $jenis = [
                    'Jurnal Penelitian Tidak Terakreditasi',
                    'Jurnal Penelitian Nasional Terakreditasi',
                    'Jurnal Penelitian Internasional',
                    'Jurnal Penelitian Internasional Bereputasi',
                    'Seminar Wilayah / Lokal / Perguruan Tinggi',
                    'Seminar Nasional',
                    'Seminar Internasional',
                    'Tulisan di Media Massa Nasional',
                    'Tulisan di Media Massa Internasional',
                    'TOTAL',
                ];

                $tabel = [];

                foreach ($jenis as $s) {
                    $tabel[] = [
                        'jenis' => strtoupper($s),
                        'ts2' => 0,
                        'ts1' => 0,
                        'ts' => 0,
                        'total' => 0,
                    ];
                }

                $tabel_publikasi = Publikasi::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->with(['dosen' => function ($query) use ($kodeprodi) {
                    return $query->where('kode', $kodeprodi);
                }])->get();

                $publikasi = [];

                foreach ($tabel_publikasi as $p) {
                    if (isset($p['dosen']['nama'])) {
                        $publikasi[] = $p;
                    }
                }

                for ($i = 0; $i < count($publikasi); $i++) {

                    $get_jenis = -1;

                    if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional tidak terakreditasi') {
                        $get_jenis = 0;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional terakreditasi') {
                        $get_jenis = 1;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 2;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional bereputasi') {
                        $get_jenis = 3;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'wilayah / lokal / PT') {
                        $get_jenis = 4;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                        $get_jenis = 5;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 6;
                    } else if ($publikasi[$i]['jenis'] == 'media massa' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                        $get_jenis = 7;
                    } else if ($publikasi[$i]['jenis'] == 'media massa' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 8;
                    }

                    $tahun = null;

                    if ($publikasi[$i]['tahun'] == $ts) {
                        $tahun = 'ts';
                    } else if ($publikasi[$i]['tahun'] == $ts - 1) {
                        $tahun = 'ts1';
                    } else if ($publikasi[$i]['tahun'] == $ts - 2) {
                        $tahun = 'ts2';
                    }

                    if ($get_jenis != -1 && $tahun != null) {
                        $tabel[$get_jenis][$tahun] += 1;
                        $tabel[$get_jenis]['total'] += 1;
                        $tabel[count($jenis) - 1][$tahun] += 1;
                        $tabel[count($jenis) - 1]['total'] += 1;
                    }
                }

                $data['publikasi_ilmiah'] = $tabel;
            }


            if ($item['slug'] == 'pagelaran_pameran_dtps') {
                $jenis = [
                    'Jurnal Penelitian Tidak Terakreditasi',
                    'Jurnal Penelitian Nasional Terakreditasi',
                    'Jurnal Penelitian Internasional',
                    'Jurnal Penelitian Internasional Bereputasi',
                    'Seminar Wilayah / Lokal / Perguruan Tinggi',
                    'Seminar Nasional',
                    'Seminar Internasional',
                    'Pagelaran/pameran/presentasi dalam forum di tingkat wilayah',
                    'Pagelaran/pameran/presentasi dalam forum di tingkat nasional',
                    'Pagelaran/pameran/presentasi dalam forum di tingkat internasional',
                    'TOTAL',
                ];

                $tabel = [];

                foreach ($jenis as $s) {
                    $tabel[] = [
                        'jenis' => strtoupper($s),
                        'ts2' => 0,
                        'ts1' => 0,
                        'ts' => 0,
                        'total' => 0,
                    ];
                }

                $tabel_publikasi = Publikasi::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->with(['dosen' => function ($query) use ($kodeprodi) {
                    return $query->where('kode', $kodeprodi);
                }])->get();

                $publikasi = [];

                foreach ($tabel_publikasi as $p) {
                    if (isset($p['dosen']['nama'])) {
                        $publikasi[] = $p;
                    }
                }

                for ($i = 0; $i < count($publikasi); $i++) {

                    $get_jenis = -1;

                    if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional tidak terakreditasi') {
                        $get_jenis = 0;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional terakreditasi') {
                        $get_jenis = 1;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 2;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional bereputasi') {
                        $get_jenis = 3;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'wilayah / lokal / PT') {
                        $get_jenis = 4;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                        $get_jenis = 5;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 6;
                    } else if ($publikasi[$i]['jenis'] == 'pagelaran pameran presentasi' && $publikasi[$i]['sub_jenis'] == 'wilayah / lokal / PT') {
                        $get_jenis = 7;
                    } else if ($publikasi[$i]['jenis'] == 'pagelaran pameran presentasi' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                        $get_jenis = 8;
                    } else if ($publikasi[$i]['jenis'] == 'pagelaran pameran presentasi' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 9;
                    }

                    $tahun = null;

                    if ($publikasi[$i]['tahun'] == $ts) {
                        $tahun = 'ts';
                    } else if ($publikasi[$i]['tahun'] == $ts - 1) {
                        $tahun = 'ts1';
                    } else if ($publikasi[$i]['tahun'] == $ts - 2) {
                        $tahun = 'ts2';
                    }

                    if ($get_jenis != -1 && $tahun != null) {
                        $tabel[$get_jenis][$tahun] += 1;
                        $tabel[$get_jenis]['total'] += 1;
                        $tabel[count($jenis) - 1][$tahun] += 1;
                        $tabel[count($jenis) - 1]['total'] += 1;
                    }
                }

                $data['pagelaran_pameran'] = $tabel;
            }

            if ($item['slug'] == 'karya_ilmiah_dtps_sitasi') {
                $hasil = Publikasi::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->where('sitasi', '>', 0)->with(['dosen' => function ($query) use ($kodeprodi) {
                    return $query->where('kode', $kodeprodi);
                }])->get();
                $publikasi = [];
                foreach ($hasil as $p) {
                    if (isset($p['dosen']['nama'])) {
                        $publikasi[] = $p;
                    }
                }
                $data['sitasi_dosen'] = $publikasi;
            }

            if ($item['slug'] == 'produk_jasa_dtps') {
                $produk = Produk::where('kode_prodi', $kodeprodi)->whereNotNull('nidn')->whereBetween('tahun', [$ts - 2, $ts])->with(['dosen' => function ($query) use ($kodeprodi) {
                    return $query->where('kode', $kodeprodi);
                }])->get();

                $tabel = [];
                foreach ($produk as $m) {
                    if (isset($m['dosen']['nama'])) {
                        $tabel[] = $m;
                    }
                }
                $data['produk_jasa_dosen'] = $tabel;
            }

            if ($item['slug'] == 'hki_paten_dtps') {
                $hasil = Hki::where('kode_prodi', $kodeprodi)->whereNotNull('nidn')->whereIn('jenis', ['paten', 'paten sederhana'])->with(['dosen' => function ($query) use ($kodeprodi) {
                    return $query->where('kode', $kodeprodi);
                }])->get();

                $tabel = collect();
                foreach ($hasil as $s) {
                    if (isset($s['dosen']['nama'])) {
                        $tabel->push($s);
                    }
                }
                $data['luaran_hki_paten_dosen'] = $tabel;

            }

            if ($item['slug'] == 'hki_hak_cipta_dtps') {
                $hasil = Hki::where('kode_prodi', $kodeprodi)->whereNotNull('nidn')->whereIn('jenis', ['hak cipta', 'desain industri', 'perlindungan varietas tanaman', 'desain tata letak sirkuit terpadu', 'indikasi geografis'])->with(['dosen' => function ($query) use ($kodeprodi) {
                    return $query->where('kode', $kodeprodi);
                }])->get();

                $tabel = collect();
                foreach ($hasil as $s) {
                    if (isset($s['dosen']['nama'])) {
                        $tabel->push($s);
                    }
                }
                $data['luaran_hki_hak_cipta_dosen'] = $tabel;
            }

            if ($item['slug'] == 'teknologi_tepat_guna_dtps') {
                $hasil = Hki::where('kode_prodi', $kodeprodi)->whereNotNull('nidn')->whereIn('jenis', ['teknologi tepat guna', 'produk', 'karya seni', 'rekayasa sosial'])->with(['dosen' => function ($query) use ($kodeprodi) {
                    return $query->where('kode', $kodeprodi);
                }])->get();

                $tabel = collect();
                foreach ($hasil as $s) {
                    if (isset($s['dosen']['nama'])) {
                        $tabel->push($s);
                    }
                }
                $data['luaran_teknologi_dosen'] = $tabel;
            }

            if ($item['slug'] == 'buku_dtps') {
                $hasil = Buku::where('kode_prodi', $kodeprodi)->whereNotNull('isbn')->whereNotNull('nidn')->orderBy('tahun', 'DESC')->with(['dosen' => function ($query) use ($kodeprodi) {
                    return $query->where('kode', $kodeprodi);
                }])->get();

                $tabel = collect();
                foreach ($hasil as $s) {
                    if (isset($s['dosen']['nama'])) {
                        $tabel->push($s);
                    }
                }
                $data['buku_dosen'] = $tabel;
            }

            if ($item['slug'] == 'penggunaan_dana') {
            }

            if ($item['slug'] == 'kurikulum_capaian') {
                $hasil = MataKuliah::where('kode_prodi', $kodeprodi)->orderBy('semester', 'ASC')->get();
                $data['kurikulum_capaian'] = $hasil;
            }

            if ($item['slug'] == 'integrasi_penelitian_pkm_pembelajaran') {
                $penelitian = Penelitian::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->get();
                $pengabdian = Pengabdian::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->get();

                $tabel = [];
                foreach ($penelitian as $h) {
                    if ($h['integrasi_pembelajaran'] != null) {
                        $tabel[] = [
                            'jenis' => 'penelitian',
                            'judul' => $h['judul'],
                            'dosen' => $h['dosen'],
                            'integrasi' => $h['integrasi_pembelajaran'],
                            'tahun' => $h['tahun'],
                        ];
                    }
                }
                foreach ($pengabdian as $h) {
                    if ($h['integrasi_pembelajaran'] != null) {
                        $tabel[] = [
                            'jenis' => 'pengabdian',
                            'judul' => $h['judul'],
                            'dosen' => $h['dosen'],
                            'integrasi' => $h['integrasi_pembelajaran'],
                            'tahun' => $h['tahun'],
                        ];
                    }
                }
                $data['integrasi'] = $tabel;
            }

            if ($item['slug'] == 'kepuasan_mahasiswa') {
                $faktor = [
                    [
                        "faktor" => "Keandalan (Reliability)",
                        "penjelasan" => "Kemampuan dosen, tenaga kependidikan, dan pengelola dalam memberikan pelayanan secara konsisten dan dapat diandalkan."
                    ],
                    [
                        "faktor" => "Daya tanggap (Responsiveness)",
                        "penjelasan" => "Kemauan dari dosen, tenaga kependidikan, dan pengelola untuk membantu mahasiswa dan memberikan jasa dengan cepat."
                    ],
                    [
                        "faktor" => "Kepastian (Assurance)",
                        "penjelasan" => "Kemampuan dosen, tenaga kependidikan, dan pengelola untuk memberi keyakinan kepada mahasiswa bahwa pelayanan yang diberikan telah sesuai dengan ketentuan."
                    ],
                    [
                        "faktor" => "Empati (Empathy)",
                        "penjelasan" => "Kesediaan dan kepedulian dosen, tenaga kependidikan, dan pengelola untuk memberikan perhatian kepada mahasiswa."
                    ],
                    [
                        "faktor" => "Tangible",
                        "penjelasan" => "Penilaian mahasiswa terhadap kecukupan, aksesibilitas, dan kualitas sarana dan prasarana yang disediakan."
                    ]
                ];

                $tabel = [];


                for ($i = 0; $i < count($faktor); $i++) {
                    $faktor[$i]['sangat_baik'] = 0;
                    $faktor[$i]["baik"] = 0;
                    $faktor[$i]["cukup"] = 0;
                    $faktor[$i]["kurang"] = 0;
                    $faktor[$i]["jumlah"] = 0;
                }

                $hasil = KepuasanMahasiswa::where('kode_prodi', $kodeprodi)->where('tahun', [$ts])->get();

                foreach ($hasil as $m) {

                    if ($m['keandalan'] == 'sangat baik') {
                        $faktor[0]['sangat_baik'] += 1;
                    } else if ($m['keandalan'] == 'baik') {
                        $faktor[0]['baik'] += 1;
                    } else if ($m['keandalan'] == 'cukup') {
                        $faktor[0]['cukup'] += 1;
                    } else if ($m['keandalan'] == 'kurang') {
                        $faktor[0]['kurang'] += 1;
                    }

                    if ($m['daya_tanggap'] == 'sangat baik') {
                        $faktor[1]['sangat_baik'] += 1;
                    } else if ($m['daya_tanggap'] == 'baik') {
                        $faktor[1]['baik'] += 1;
                    } else if ($m['daya_tanggap'] == 'cukup') {
                        $faktor[1]['cukup'] += 1;
                    } else if ($m['daya_tanggap'] == 'kurang') {
                        $faktor[1]['kurang'] += 1;
                    }

                    if ($m['kepastian'] == 'sangat baik') {
                        $faktor[2]['sangat_baik'] += 1;
                    } else if ($m['kepastian'] == 'baik') {
                        $faktor[2]['baik'] += 1;
                    } else if ($m['kepastian'] == 'cukup') {
                        $faktor[2]['cukup'] += 1;
                    } else if ($m['kepastian'] == 'kurang') {
                        $faktor[2]['kurang'] += 1;
                    }

                    if ($m['empati'] == 'sangat baik') {
                        $faktor[3]['sangat_baik'] += 1;
                    } else if ($m['empati'] == 'baik') {
                        $faktor[3]['baik'] += 1;
                    } else if ($m['empati'] == 'cukup') {
                        $faktor[3]['cukup'] += 1;
                    } else if ($m['empati'] == 'kurang') {
                        $faktor[3]['kurang'] += 1;
                    }

                    if ($m['nyata'] == 'sangat baik') {
                        $faktor[4]['sangat_baik'] += 1;
                    } else if ($m['nyata'] == 'baik') {
                        $faktor[4]['baik'] += 1;
                    } else if ($m['nyata'] == 'cukup') {
                        $faktor[4]['cukup'] += 1;
                    } else if ($m['nyata'] == 'kurang') {
                        $faktor[4]['kurang'] += 1;
                    }

                    $faktor[0]['jumlah'] += 1;
                    $faktor[1]['jumlah'] += 1;
                    $faktor[2]['jumlah'] += 1;
                    $faktor[3]['jumlah'] += 1;
                }
                $data['kepuasan_mahasiswa'] = [ $item['instrumen_terpilih']['url'], $faktor];
            }

            if ($item['slug'] == 'penelitian_dtps_mahasiswa') {
                $penelitian = Penelitian::where('kode_prodi', $kodeprodi)->whereNotNull('dosen')->whereNotNull('mahasiswa')->whereBetween('tahun', [$ts - 2, $ts])->get();

                $data['penelitian_dosen_mahasiswa'] = $penelitian;
            }

            if ($item['slug'] == 'penelitian_dtps_rujukan_tema') {
                $penelitian = Penelitian::where('kode_prodi', $kodeprodi)->whereNotNull(['dosen', 'mahasiswa', 'rujukan_tema'])->whereBetween('tahun', [$ts - 2, $ts])->get();

                $data['penelitian_dosen_dirujuk'] = $penelitian;
            }

            if ($item['slug'] == 'pengabdian_dtps_mahasiswa') {
                $pengabdian = Pengabdian::where('kode_prodi', $kodeprodi)->whereNotNull('dosen')->whereNotNull('mahasiswa')->whereBetween('tahun', [$ts - 2, $ts])->get();

                $data['pengabdian_dosen_mahasiswa'] = $pengabdian;
            }

            if ($item['slug'] == 'ipk_lulusan') {

                $lulusan = Mahasiswa::where('kode_prodi', $kodeprodi)->where('status_keluar', 'lulus')->get();

                $lulusan = $lulusan->filter(function ($i) {
                    return $i->tanggal_yudisium != null && $i->tanggal_yudisium != 0;
                });

                $tsname = ['ts2', 'ts1', 'ts'];
                $tabel = [];

                for ($u = 0; $u < count($tsname); $u++) {
                    $tabel[] = [
                        'nama' => $tsname[$u],
                        'jumlah' => $lulusan->filter(function ($i) use ($u, $ts) {
                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $a = Carbon::create($ts - 2 + $u, 9, 1);
                            $z = Carbon::create($ts - 2 + 1 + $u, 8, 31);
                            return $tanggalLulus->gte($a) && $tanggalLulus->lte($z);
                        })->count(),
                        'min' => $lulusan->filter(function ($i) use ($u, $ts) {
                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $a = Carbon::create($ts - 2 + $u, 9, 1);
                            $z = Carbon::create($ts - 2 + 1 + $u, 8, 31);
                            return $tanggalLulus->gte($a) && $tanggalLulus->lte($z);
                        })->min('ipk'),
                        'rata' => $lulusan->filter(function ($i) use ($u, $ts) {
                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $a = Carbon::create($ts - 2 + $u, 9, 1);
                            $z = Carbon::create($ts - 2 + 1 + $u, 8, 31);
                            return $tanggalLulus->gte($a) && $tanggalLulus->lte($z);
                        })->average('ipk'),
                        'max' => $lulusan->filter(function ($i) use ($u, $ts) {
                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $a = Carbon::create($ts - 2 + $u, 9, 1);
                            $z = Carbon::create($ts - 2 + 1 + $u, 8, 31);
                            return $tanggalLulus->gte($a) && $tanggalLulus->lte($z);
                        })->max('ipk')
                    ];
                }

                $data['ipk_lulusan'] = $tabel;
            }

            if ($item['slug'] == 'prestasi_akademik_mahasiswa') {
                $prestasi = Prestasi::where('kode_prodi', $kodeprodi)->where('bidang', 'akademik')->whereBetween('tahun', [$ts - 2, $ts])->get();
                $data['prestasi_akademik'] = $prestasi;
            }

            if ($item['slug'] == 'prestasi_non_akademik_mahasiswa') {
                $prestasi = Prestasi::where('kode_prodi', $kodeprodi)->where('bidang', 'non-akademik')->whereBetween('tahun', [$ts - 2, $ts])->get();
                $data['prestasi_non_akademik'] = $prestasi;
            }

            if ($item['slug'] == 'masa_studi_lulusan') {

                $prodi = Prodi::where('kode', $kodeprodi)->first();
                $jumlah_ts = [$ts - 6, $ts - 5, $ts - 4, $ts - 3, $ts - 2, $ts - 1, $ts - 0];

                $mahasiswa = Mahasiswa::where('daftar_ulang', 1)
                ->where('status_keluar', 'lulus')
                ->where('kode_prodi', $kodeprodi)->get();

                $mahasiswa = $mahasiswa->filter(function ($i) {
                    if ($i['tanggal_yudisium'] === null || $i['tanggal_yudisium'] === 0) {
                        return false; // Skip this entry
                    } else {
                        return true;
                    }
                });

                $tabel = [];

                for ($m = 0; $m < count($jumlah_ts); $m++) {
                    $rata_masa_studi = 0;
                    $total_days = 0;
                    $mhs_masa_studi = $mahasiswa->filter(function ($item) {
                        return !is_null($item['tanggal_yudisium']) && Carbon::parse($item['tanggal_yudisium'])->year > 2000;
                    });

                    if (count($mhs_masa_studi) > 0) {
                        foreach ($mhs_masa_studi as $ms) {

                            $tgl_msk = Carbon::createFromDate($jumlah_ts[$m], 9, 1);
                            $tgl_klr = Carbon::parse($ms['tanggal_yudisium']);

                            $total_days += $tgl_msk->diffInDays($tgl_klr);
                        }

                        $rata_masa_studi = $total_days / count($mhs_masa_studi);
                        $rata_masa_studi = floor($rata_masa_studi) / 365;
                        $rata_masa_studi = number_format($rata_masa_studi, 2, '.', '');
                    }


                    $tabel[] = [
                        'masuk' => $m - 6,
                        'jumlah_ts6' => $mahasiswa->where('tahun_masuk', $jumlah_ts[$m])->filter(function ($i) use ($ts) {

                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $tanggalMulaiAjaran = Carbon::create($ts - 6, 9, 1);
                            $tanggalAkhirAjaran = Carbon::create($ts - 6 + 1, 8, 31);

                            return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                        })->count(),
                        'jumlah_ts5' => $mahasiswa->where('tahun_masuk', $jumlah_ts[$m])->filter(function ($i) use ($ts) {

                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $tanggalMulaiAjaran = Carbon::create($ts - 5, 9, 1);
                            $tanggalAkhirAjaran = Carbon::create($ts - 5 + 1, 8, 31);

                            return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                        })->count(),
                        'jumlah_ts4' => $mahasiswa->where('tahun_masuk', $jumlah_ts[$m])->filter(function ($i) use ($ts) {

                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $tanggalMulaiAjaran = Carbon::create($ts - 4, 9, 1);
                            $tanggalAkhirAjaran = Carbon::create($ts - 4 + 1, 8, 31);

                            return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                        })->count(),
                        'jumlah_ts3' => $mahasiswa->where('tahun_masuk', $jumlah_ts[$m])->filter(function ($i) use ($ts) {

                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $tanggalMulaiAjaran = Carbon::create($ts - 3, 9, 1);
                            $tanggalAkhirAjaran = Carbon::create($ts - 3 + 1, 8, 31);

                            return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                        })->count(),
                        'jumlah_ts2' => $mahasiswa->where('tahun_masuk', $jumlah_ts[$m])->filter(function ($i) use ($ts) {

                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $tanggalMulaiAjaran = Carbon::create($ts - 2, 9, 1);
                            $tanggalAkhirAjaran = Carbon::create($ts - 2 + 1, 8, 31);

                            return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                        })->count(),
                        'jumlah_ts1' => $mahasiswa->where('tahun_masuk', $jumlah_ts[$m])->filter(function ($i) use ($ts) {

                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $tanggalMulaiAjaran = Carbon::create($ts - 1, 9, 1);
                            $tanggalAkhirAjaran = Carbon::create($ts - 1 + 1, 8, 31);

                            return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                        })->count(),
                        'jumlah_ts' => $mahasiswa->where('tahun_masuk', $jumlah_ts[$m])->filter(function ($i) use ($ts) {

                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $tanggalMulaiAjaran = Carbon::create($ts, 9, 1);
                            $tanggalAkhirAjaran = Carbon::create($ts + 1, 8, 31);

                            return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                        })->count(),

                        'jumlah_semua_ts' => $mahasiswa->where('tahun_masuk', $jumlah_ts[$m])->filter(function ($i) use ($ts) {

                            $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                            $tanggalMulaiAjaran = Carbon::create($ts - 6, 9, 1);
                            $tanggalAkhirAjaran = Carbon::create($ts + 1, 8, 31);

                            return $tanggalLulus->gte($tanggalMulaiAjaran) && $tanggalLulus->lte($tanggalAkhirAjaran);
                        })->count(),

                        'jumlah_mahasiswa_diterima' => SeleksiMahasiswaBaru::where('kode_prodi', $kodeprodi)->where('tahun', $jumlah_ts[$m])->first()->mahasiswa_baru_reguler ?? 0,

                        'rata_masa_studi' => $rata_masa_studi,
                    ];
                }

                $data['masa_studi_lulusan'] = $tabel;
            }

            if ($item['slug'] == 'waktu_tunggu_lulusan') {

                $jenjang = Prodi::where('kode', $kodeprodi)->first()->jenjang;

                $lulusan = Mahasiswa::where('kode_prodi', $kodeprodi)->where('status_keluar', 'lulus')->with(['tracer' => function ($query) {
                    return $query->orderBy('created_at', 'desc');
                }])->get();

                $lulusan = $lulusan->filter(function ($i) {
                    return $i->tanggal_yudisium != null && $i->tanggal_yudisium != 0;
                });

                $tsname = ['ts-4', 'ts-3', 'ts-2'];
                $tabel = [];

                $a = 0;
                $b = 0;
                if ($jenjang == 'D3' || $jenjang == 'PROF') {
                    $a = 3;
                    $b = 6;
                } else if ($jenjang == 'S1') {
                    $a = 6;
                    $b = 18;
                }

                for ($u = 0; $u < count($tsname); $u++) {

                    $jumlah_lulusan = $lulusan->filter(function ($i) use ($u, $ts) {
                        $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                        $a = Carbon::create($ts - 4 + $u, 9, 1);
                        $z = Carbon::create($ts - 4 + 1 + $u, 8, 31);
                        return $tanggalLulus->gte($a) && $tanggalLulus->lte($z);
                    });

                    $terlacak = $jumlah_lulusan->filter(function ($i) {
                        return count($i['tracer']) != 0;
                    });

                    $tabel[] = [
                        'nama' => $tsname[$u],
                        'jumlah' => $jumlah_lulusan->count(),
                        'terlacak' => $terlacak->count(),
                        'waktu_tunggu_3' => $terlacak->filter(function ($i) use ($a) {
                            return $i['tracer'][0]['waktu_tunggu_kerja'] != 0 && $i['tracer'][0]['waktu_tunggu_kerja'] <= $a;
                        })->count(),
                        'waktu_tunggu_3_6' => $terlacak->filter(function ($i) use ($a, $b) {
                            return $i['tracer'][0]['waktu_tunggu_kerja'] != 0 && $i['tracer'][0]['waktu_tunggu_kerja'] > $a && $i['tracer'][0]['waktu_tunggu_kerja'] < $b;
                        })->count(),
                        'waktu_tunggu_6' => $terlacak->filter(function ($i) use ($b) {
                            return $i['tracer'][0]['waktu_tunggu_kerja'] != 0 && $i['tracer'][0]['waktu_tunggu_kerja'] >= $b;
                        })->count(),
                    ];
                }

                $tabel[] = [
                    'nama' => 'Total',
                    'jumlah' => collect($tabel)->sum('jumlah'),
                    'terlacak' => collect($tabel)->sum('terlacak'),
                    'waktu_tunggu_3' => collect($tabel)->sum('waktu_tunggu_3'),
                    'waktu_tunggu_3_6' => collect($tabel)->sum('waktu_tunggu_3_6'),
                    'waktu_tunggu_6' => collect($tabel)->sum('waktu_tunggu_6'),
                ];

                $data['waktu_tunggu_lulusan'] = [$tabel, $a, $b];
            }

            if ($item['slug'] == 'kesesuaian_bidang') {

                $lulusan = Mahasiswa::where('kode_prodi', $kodeprodi)->where('status_keluar', 'lulus')->with(['tracer' => function ($query) {
                    return $query->orderBy('created_at', 'desc');
                }])->get();

                $lulusan = $lulusan->filter(function ($i) {
                    return $i->tanggal_yudisium != null && $i->tanggal_yudisium != 0;
                });

                $tsname = ['ts-4', 'ts-3', 'ts-2'];
                $tabel = [];

                for ($u = 0; $u < count($tsname); $u++) {

                    $jumlah_lulusan = $lulusan->filter(function ($i) use ($u, $ts) {
                        $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                        $a = Carbon::create($ts - 4 + $u, 9, 1);
                        $z = Carbon::create($ts - 4 + 1 + $u, 8, 31);
                        return $tanggalLulus->gte($a) && $tanggalLulus->lte($z);
                    });

                    $terlacak = $jumlah_lulusan->filter(function ($i) {
                        return count($i['tracer']) != 0;
                    });

                    $tabel[] = [
                        'nama' => $tsname[$u],
                        'jumlah' => $jumlah_lulusan->count(),
                        'terlacak' => $terlacak->count(),
                        'rendah' => $terlacak->filter(function ($i) {
                            return $i['tracer'][0]['kesesuaian_bidang_ilmu'] == 'tidak sesuai';
                        })->count(),
                        'sedang' => $terlacak->filter(function ($i) {
                            return $i['tracer'][0]['kesesuaian_bidang_ilmu'] == 'kurang sesuai';
                        })->count(),
                        'tinggi' => $terlacak->filter(function ($i) {
                            return $i['tracer'][0]['kesesuaian_bidang_ilmu'] == 'sesuai';
                        })->count(),
                    ];
                }

                $tabel[] = [
                    'nama' => 'Total',
                    'jumlah' => collect($tabel)->sum('jumlah'),
                    'terlacak' => collect($tabel)->sum('terlacak'),
                    'rendah' => collect($tabel)->sum('rendah'),
                    'sedang' => collect($tabel)->sum('sedang'),
                    'tinggi' => collect($tabel)->sum('tinggi'),
                ];

                $data['kesesuaian_bidang'] = $tabel;
            }

            if ($item['slug'] == 'tempat_kerja') {

                $lulusan = Mahasiswa::where('kode_prodi', $kodeprodi)->where('status_keluar', 'lulus')->with(['tracer' => function ($query) {
                    return $query->orderBy('created_at', 'desc');
                }])->get();

                $lulusan = $lulusan->filter(function ($i) {
                    return $i->tanggal_yudisium != null && $i->tanggal_yudisium != 0;
                });

                $tsname = ['ts-4', 'ts-3', 'ts-2'];
                $tabel = [];

                for ($u = 0; $u < count($tsname); $u++) {

                    $jumlah_lulusan = $lulusan->filter(function ($i) use ($u, $ts) {
                        $tanggalLulus = Carbon::parse($i['tanggal_yudisium']);
                        $a = Carbon::create($ts - 4 + $u, 9, 1);
                        $z = Carbon::create($ts - 4 + 1 + $u, 8, 31);
                        return $tanggalLulus->gte($a) && $tanggalLulus->lte($z);
                    });

                    $terlacak = $jumlah_lulusan->filter(function ($i) {
                        return count($i['tracer']) != 0;
                    });

                    $tabel[] = [
                        'nama' => $tsname[$u],
                        'jumlah' => $jumlah_lulusan->count(),
                        'terlacak' => $terlacak->count(),
                        'lokal' => $terlacak->filter(function ($i) {
                            return $i['tracer'][0]['tingkat'] == 'lokal / wilayah / berwirausaha tidak berbadan hukum';
                        })->count(),
                        'nasional' => $terlacak->filter(function ($i) {
                            return $i['tracer'][0]['tingkat'] == 'nasional / berwirausaha berbadan hukum';
                        })->count(),
                        'internasional' => $terlacak->filter(function ($i) {
                            return $i['tracer'][0]['tingkat'] == 'multinasional / internasional';
                        })->count(),
                        'lanjut_studi' => $terlacak->filter(function ($i) {
                            return $i['tracer'][0]['tingkat'] == 'melanjutkan studi';
                        })->count(),
                    ];
                }

                $tabel[] = [
                    'nama' => 'Total',
                    'jumlah' => collect($tabel)->sum('jumlah'),
                    'terlacak' => collect($tabel)->sum('terlacak'),
                    'lokal' => collect($tabel)->sum('lokal'),
                    'nasional' => collect($tabel)->sum('nasional'),
                    'internasional' => collect($tabel)->sum('internasional'),
                    'lanjut_studi' => collect($tabel)->sum('melanjutkan studi'),
                ];

                $data['tempat_kerja'] = $tabel;
            }

            if ($item['slug'] == 'kepuasan_pengguna') {
                $kepuasan = PenggunaLulusan::where('kode_prodi', $kodeprodi)->get();
            }

            if ($item['slug'] == 'publikasi_mahasiswa') {
                $jenis = [
                    'Jurnal Penelitian Tidak Terakreditasi',
                    'Jurnal Penelitian Nasional Terakreditasi',
                    'Jurnal Penelitian Internasional',
                    'Jurnal Penelitian Internasional Bereputasi',
                    'Seminar Wilayah / Lokal / Perguruan Tinggi',
                    'Seminar Nasional',
                    'Seminar Internasional',
                    'Tulisan di Media Massa Nasional',
                    'Tulisan di Media Massa Internasional',
                    'TOTAL',
                ];

                $tabel = [];

                foreach ($jenis as $s) {
                    $tabel[] = [
                        'jenis' => strtoupper($s),
                        'ts2' => 0,
                        'ts1' => 0,
                        'ts' => 0,
                        'total' => 0,
                    ];
                }

                $tabel_publikasi = Publikasi::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->with(['mahasiswa' => function ($query) use ($kodeprodi) {
                    return $query->where('kode_prodi', $kodeprodi);
                }])->get();

                $publikasi = [];

                foreach ($tabel_publikasi as $p) {
                    if (isset($p['mahasiswa']['nama'])) {
                        $publikasi[] = $p;
                    }
                }

                for ($i = 0; $i < count($publikasi); $i++) {

                    $get_jenis = -1;

                    if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional tidak terakreditasi') {
                        $get_jenis = 0;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional terakreditasi') {
                        $get_jenis = 1;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 2;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional bereputasi') {
                        $get_jenis = 3;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'wilayah / lokal / PT') {
                        $get_jenis = 4;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                        $get_jenis = 5;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 6;
                    } else if ($publikasi[$i]['jenis'] == 'media massa' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                        $get_jenis = 7;
                    } else if ($publikasi[$i]['jenis'] == 'media massa' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 8;
                    }

                    $tahun = null;

                    if ($publikasi[$i]['tahun'] == $ts) {
                        $tahun = 'ts';
                    } else if ($publikasi[$i]['tahun'] == $ts - 1) {
                        $tahun = 'ts1';
                    } else if ($publikasi[$i]['tahun'] == $ts - 2) {
                        $tahun = 'ts2';
                    }

                    if ($get_jenis != -1 && $tahun != null) {
                        $tabel[$get_jenis][$tahun] += 1;
                        $tabel[$get_jenis]['total'] += 1;
                        $tabel[count($jenis) - 1][$tahun] += 1;
                        $tabel[count($jenis) - 1]['total'] += 1;
                    }
                }

                $data['publikasi_ilmiah_mahasiswa'] = $tabel;
            }


            if ($item['slug'] == 'pagelaran_pameran_mahasiswa') {
                $jenis = [
                    'Jurnal Penelitian Tidak Terakreditasi',
                    'Jurnal Penelitian Nasional Terakreditasi',
                    'Jurnal Penelitian Internasional',
                    'Jurnal Penelitian Internasional Bereputasi',
                    'Seminar Wilayah / Lokal / Perguruan Tinggi',
                    'Seminar Nasional',
                    'Seminar Internasional',
                    'Pagelaran/pameran/presentasi dalam forum di tingkat wilayah',
                    'Pagelaran/pameran/presentasi dalam forum di tingkat nasional',
                    'Pagelaran/pameran/presentasi dalam forum di tingkat internasional',
                    'TOTAL',
                ];

                $tabel = [];

                foreach ($jenis as $s) {
                    $tabel[] = [
                        'jenis' => strtoupper($s),
                        'ts2' => 0,
                        'ts1' => 0,
                        'ts' => 0,
                        'total' => 0,
                    ];
                }

                $tabel_publikasi = Publikasi::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->with(['mahasiswa' => function ($query) use ($kodeprodi) {
                    return $query->where('kode_prodi', $kodeprodi);
                }])->get();

                $publikasi = [];

                foreach ($tabel_publikasi as $p) {
                    if (isset($p['mahasiswa']['nama'])) {
                        $publikasi[] = $p;
                    }
                }

                for ($i = 0; $i < count($publikasi); $i++) {

                    $get_jenis = -1;

                    if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional tidak terakreditasi') {
                        $get_jenis = 0;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'nasional terakreditasi') {
                        $get_jenis = 1;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 2;
                    } else if ($publikasi[$i]['jenis'] == 'jurnal' && $publikasi[$i]['sub_jenis'] == 'internasional bereputasi') {
                        $get_jenis = 3;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'wilayah / lokal / PT') {
                        $get_jenis = 4;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                        $get_jenis = 5;
                    } else if ($publikasi[$i]['jenis'] == 'seminar' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 6;
                    } else if ($publikasi[$i]['jenis'] == 'pagelaran pameran presentasi' && $publikasi[$i]['sub_jenis'] == 'wilayah / lokal / PT') {
                        $get_jenis = 7;
                    } else if ($publikasi[$i]['jenis'] == 'pagelaran pameran presentasi' && $publikasi[$i]['sub_jenis'] == 'nasional') {
                        $get_jenis = 8;
                    } else if ($publikasi[$i]['jenis'] == 'pagelaran pameran presentasi' && $publikasi[$i]['sub_jenis'] == 'internasional') {
                        $get_jenis = 9;
                    }

                    $tahun = null;

                    if ($publikasi[$i]['tahun'] == $ts) {
                        $tahun = 'ts';
                    } else if ($publikasi[$i]['tahun'] == $ts - 1) {
                        $tahun = 'ts1';
                    } else if ($publikasi[$i]['tahun'] == $ts - 2) {
                        $tahun = 'ts2';
                    }

                    if ($get_jenis != -1 && $tahun != null) {
                        $tabel[$get_jenis][$tahun] += 1;
                        $tabel[$get_jenis]['total'] += 1;
                        $tabel[count($jenis) - 1][$tahun] += 1;
                        $tabel[count($jenis) - 1]['total'] += 1;
                    }
                }

                $data['pagelaran_pameran_mahasiswa'] = $tabel;
            }

            if ($item['slug'] == 'karya_mahasiswa_sitasi') {
                $hasil = Publikasi::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 2, $ts])->where('sitasi', '>', 0)->with(['mahasiswa' => function ($query) use ($kodeprodi) {
                    return $query->where('kode_prodi', $kodeprodi);
                }])->get();

                $publikasi = [];

                foreach ($hasil as $p) {
                    if (isset($p['mahasiswa']['nama'])) {
                        $publikasi[] = $p;
                    }
                }
                $data['sitasi_mahasiswa'] = $publikasi;
            }

            if ($item['slug'] == 'produk_jasa_mahasiswa') {
                $produk = Produk::where('kode_prodi', $kodeprodi)->whereNotNull('nim')->whereBetween('tahun', [$ts - 2, $ts])->with(['mahasiswa' => function ($query) use ($kodeprodi) {
                    return $query->where('kode_prodi', $kodeprodi);
                }])->get();

                $tabel = [];
                foreach ($produk as $m) {
                    if (isset($m['mahasiswa']['nama'])) {
                        $tabel[] = $m;
                    }
                }
                $data['produk_jasa_mahasiswa'] = $tabel;
            }

            if ($item['slug'] == 'hki_paten_mahasiswa') {
                $hasil = Hki::where('kode_prodi', $kodeprodi)->whereNotNull('nim')->whereIn('jenis', ['paten', 'paten sederhana'])->with(['mahasiswa' => function ($query) use ($kodeprodi) {
                    return $query->where('kode_prodi', $kodeprodi);
                }])->get();

                $tabel = collect();
                foreach ($hasil as $s) {
                    if (isset($s['mahasiswa']['nama'])) {
                        $tabel->push($s);
                    }
                }
                $data['luaran_hki_paten_mahasiswa'] = $tabel;
            }

            if ($item['slug'] == 'hki_hak_cipta_mahasiswa') {
                $hasil = Hki::where('kode_prodi', $kodeprodi)->whereNotNull('nim')->whereIn('jenis', ['hak cipta', 'desain industri', 'perlindungan varietas tanaman', 'desain tata letak sirkuit terpadu', 'indikasi geografis'])->with(['mahasiswa' => function ($query) use ($kodeprodi) {
                    return $query->where('kode_prodi', $kodeprodi);
                }])->get();

                $tabel = collect();
                foreach ($hasil as $s) {
                    if (isset($s['mahasiswa']['nama'])) {
                        $tabel->push($s);
                    }
                }
                $data['luaran_hki_hak_cipta_mahasiswa'] = $tabel;
            }

            if ($item['slug'] == 'teknologi_produk_mahasiswa') {
                $hasil = Hki::where('kode_prodi', $kodeprodi)->whereNotNull('nim')->whereIn('jenis', ['teknologi tepat guna', 'produk', 'karya seni', 'rekayasa sosial'])->with(['mahasiswa' => function ($query) use ($kodeprodi) {
                    return $query->where('kode_prodi', $kodeprodi);
                }])->get();

                $tabel = collect();
                foreach ($hasil as $s) {
                    if (isset($s['mahasiswa']['nama'])) {
                        $tabel->push($s);
                    }
                }
                $data['luaran_teknologi_mahasiswa'] = $tabel;
            }

            if ($item['slug'] == 'buku_mahasiswa') {
                $hasil = Buku::where('kode_prodi', $kodeprodi)->whereNotNull('isbn')->whereNotNull('nim')->orderBy('tahun', 'DESC')->with(['mahasiswa' => function ($query) use ($kodeprodi) {
                    return $query->where('kode_prodi', $kodeprodi);
                }])->get();

                $tabel = collect();
                foreach ($hasil as $s) {
                    if (isset($s['mahasiswa']['nama'])) {
                        $tabel->push($s);
                    }
                }
                $data['buku_mahasiswa'] = $tabel;
            }

            if ($item['slug'] == 'peralatan_laboratorium') {
                $peralatan = PeralatanLaboratorium::where('kode_prodi', $kodeprodi)->whereBetween('tahun', [$ts - 4, $ts])->get();
                $data['peralatan_laboratorium'] = $peralatan;
            }
        }


        $prodi = Prodi::whereKode($kodeprodi)->first();

        //return response()->json($instrumen, 200, [], JSON_PRETTY_PRINT);

        return view('portaldata.instrumen_prodi.index', compact('data', 'prodi'));
    }
}
