<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class PublikasiController extends Controller
{
    public function index()
    {
        return view('portaldata.publikasi');
    }

    public function get_data(Request $request)
    {
        $fakultas = $request->fakultas;

        $data = [];
        $all_data = collect();

        // Query data dengan filter fakultas, jenjang, dan status sesuai parameter
        $query = Faculty::query();
        if ($fakultas != 0) {
            $query->where('code', $fakultas);
        }
        $query->with(['prodi' => function ($query) {
            $query->with('publikasi');
        }]);
        $data = $query->get();

        //Membuat variabel di collection $data
        $all_data['total_publikasi'] = 0;

        $tahun = ['2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015', '2014', '2013', '2012', '2011', '2010'];
        $all_data['tahun'] = collect();
        foreach ($tahun as $p) {
            $all_data['tahun'][$p] = 0;
        }

        $all_data['kategori'] = collect([
            'a' => collect([
                'nama' => 'Jurnal',
                'jumlah' => 0
            ]),
            'b' => collect([
                'nama' => 'Seminar',
                'jumlah' => 0
            ]),
            'c' => collect([
                'nama' => 'Media Massa',
                'jumlah' => 0
            ]),
        ]);

        $all_data['jenis'] = collect([
            'a' => collect([
                'nama' => 'Jurnal Nasional Terakreditasi',
                'jumlah' => 0
            ]),
            'b' => collect([
                'nama' => 'Jurnal Nasional Tidak Terakreditasi',
                'jumlah' => 0
            ]),
            'c' => collect([
                'nama' => 'Jurnal Internasional',
                'jumlah' => 0
            ]),
            'd' => collect([
                'nama' => 'Jurnal Bereputasi',
                'jumlah' => 0
            ]),
            'e' => collect([
                'nama' => 'Seminar Lokal',
                'jumlah' => 0
            ]),
            'f' => collect([
                'nama' => 'Seminar Nasional',
                'jumlah' => 0
            ]),
            'g' => collect([
                'nama' => 'Seminar Internasional',
                'jumlah' => 0
            ]),
            'h' => collect([
                'nama' => 'Media Massa Lokal',
                'jumlah' => 0
            ]),
            'i' => collect([
                'nama' => 'Media Massa Nasional',
                'jumlah' => 0
            ]),
            'j' => collect([
                'nama' => 'Media Massa Internasional',
                'jumlah' => 0
            ]),
        ]);


        //Perulangan Fakultas
        foreach ($data as $d) {

            //Membuat variabel di collection $data
            $d['total_publikasi'] = 0;

            $d['tahun'] = collect();
            foreach ($tahun as $p) {
                $d['tahun'][$p] = 0;
            }

            $d['kategori'] = collect([
                'a' => collect([
                    'nama' => 'Jurnal',
                    'jumlah' => 0
                ]),
                'b' => collect([
                    'nama' => 'Seminar',
                    'jumlah' => 0
                ]),
                'c' => collect([
                    'nama' => 'Media Massa',
                    'jumlah' => 0
                ]),
            ]);

            $d['jenis'] = collect([
                'a' => collect([
                    'nama' => 'Jurnal Nasional Terakreditasi',
                    'jumlah' => 0
                ]),
                'b' => collect([
                    'nama' => 'Jurnal Nasional Tidak Terakreditasi',
                    'jumlah' => 0
                ]),
                'c' => collect([
                    'nama' => 'Jurnal Internasional',
                    'jumlah' => 0
                ]),
                'd' => collect([
                    'nama' => 'Jurnal Bereputasi',
                    'jumlah' => 0
                ]),
                'e' => collect([
                    'nama' => 'Seminar Lokal',
                    'jumlah' => 0
                ]),
                'f' => collect([
                    'nama' => 'Seminar Nasional',
                    'jumlah' => 0
                ]),
                'g' => collect([
                    'nama' => 'Seminar Internasional',
                    'jumlah' => 0
                ]),
                'h' => collect([
                    'nama' => 'Media Massa Lokal',
                    'jumlah' => 0
                ]),
                'i' => collect([
                    'nama' => 'Media Massa Nasional',
                    'jumlah' => 0
                ]),
                'j' => collect([
                    'nama' => 'Media Massa Internasional',
                    'jumlah' => 0
                ]),
            ]);

            foreach ($d['prodi'] as $p) {

                //Membuat variabel di collection $data
            $p['total_publikasi'] = 0;

            $p['tahun'] = collect();
            foreach ($tahun as $px) {
                $p['tahun'][$px] = 0;
            }

            $p['kategori'] = collect([
                'a' => collect([
                    'nama' => 'Jurnal',
                    'jumlah' => 0
                ]),
                'b' => collect([
                    'nama' => 'Seminar',
                    'jumlah' => 0
                ]),
                'c' => collect([
                    'nama' => 'Media Massa',
                    'jumlah' => 0
                ]),
            ]);

            $p['jenis'] = collect([
                'a' => collect([
                    'nama' => 'Jurnal Nasional Terakreditasi',
                    'jumlah' => 0
                ]),
                'b' => collect([
                    'nama' => 'Jurnal Nasional Tidak Terakreditasi',
                    'jumlah' => 0
                ]),
                'c' => collect([
                    'nama' => 'Jurnal Internasional',
                    'jumlah' => 0
                ]),
                'd' => collect([
                    'nama' => 'Jurnal Internasional Bereputasi',
                    'jumlah' => 0
                ]),
                'e' => collect([
                    'nama' => 'Seminar Lokal',
                    'jumlah' => 0
                ]),
                'f' => collect([
                    'nama' => 'Seminar Nasional',
                    'jumlah' => 0
                ]),
                'g' => collect([
                    'nama' => 'Seminar Internasional',
                    'jumlah' => 0
                ]),
                'h' => collect([
                    'nama' => 'Media Massa Lokal',
                    'jumlah' => 0
                ]),
                'i' => collect([
                    'nama' => 'Media Massa Nasional',
                    'jumlah' => 0
                ]),
                'j' => collect([
                    'nama' => 'Media Massa Internasional',
                    'jumlah' => 0
                ]),
            ]);

                //Mengolah data $data
                foreach ($p['publikasi'] as $m) {

                    $all_data['total_publikasi'] += 1;
                    $d['total_publikasi'] += 1;
                    $p['total_publikasi'] += 1;

                    //Mengolah data berdasarkan Tahun Terbit
                    $thns = $m['tahun'];
                    if (isset($p['tahun'][$thns])) {
                        $p['tahun'][$thns] += 1;
                        $d['tahun'][$thns] += 1;
                        $all_data['tahun'][$thns] += 1;
                    }

                    //Mengolah data berdasarkan kategori
                    $kat = '';
                    if ($m['jenis'] == 'jurnal') {
                        $kat = 'a';
                    }elseif ($m['jenis'] == 'seminar') {
                        $kat = 'b';
                    }elseif ($m['jenis'] == 'media massa') {
                        $kat = 'c';
                    }
                    if ($kat != '') {
                        $all_data['kategori'][$kat]['jumlah'] += 1;
                        $d['kategori'][$kat]['jumlah'] += 1;
                        $p['kategori'][$kat]['jumlah'] += 1;
                    }

                    //Mengolah data berdasarkan Jenis
                    $jen = '';
                    if ($m['jenis'] == 'jurnal') {
                        if ($m['sub_jenis'] == 'nasional terakreditasi') {
                            $jen = 'a';
                        }elseif ($m['sub_jenis'] == 'nasional tidak terakreditasi') {
                            $jen = 'b';
                        }elseif ($m['sub_jenis'] == 'internasional') {
                            $jen = 'c';
                        }elseif ($m['sub_jenis'] == 'internasional bereputasi') {
                            $jen = 'd';
                        }
                    }elseif ($m['jenis'] == 'seminar') {
                        if ($m['sub_jenis'] == 'wilayah / lokal / PT') {
                            $jen = 'e';
                        }elseif ($m['sub_jenis'] == 'nasional') {
                            $jen = 'f';
                        }elseif ($m['sub_jenis'] == 'internasional') {
                            $jen = 'g';
                        }
                    }elseif ($m['jenis'] == 'media massa') {
                        if ($m['sub_jenis'] == 'wilayah / lokal / PT') {
                            $jen = 'h';
                        }elseif ($m['sub_jenis'] == 'nasional') {
                            $jen = 'i';
                        }elseif ($m['sub_jenis'] == 'internasional') {
                            $jen = 'j';
                        }
                    }
                    if ($jen != '') {
                        $all_data['jenis'][$jen]['jumlah'] += 1;
                        $d['jenis'][$jen]['jumlah'] += 1;
                        $p['jenis'][$jen]['jumlah'] += 1;
                    }

                }
            }
        }

        return response()->json(['data' => $data->all(), 'status' => $all_data->all()], 200);
    }
}
