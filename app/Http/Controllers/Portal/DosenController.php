<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        return view('portaldata.dosen');
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
            $query->with('dosen_homebase');
        }]);
        $data = $query->get();

        //Membuat variabel di collection $data
        $all_data['total_dosen'] = 0;
        $all_data['jenis_kelamin'] = collect([
            'pria' => 0,
            'wanita' => 0,
            'total' => 0
        ]);

        $pendidikan = ['S1', 'S2', 'S3'];
        $all_data['pendidikan'] = collect();
        foreach ($pendidikan as $p) {
            $all_data['pendidikan'][$p] = collect([
                'pria' => 0,
                'wanita' => 0,
                'total' => 0
            ]);
        }

        $fungsional = [
            'tenaga_pengajar' => 'Tenaga Pengajar',
            'asisten_ahli' => 'Asisten Ahli',
            'lektor' => 'Lektor',
            'lektor_kepala' => 'Lektor Kepala',
            'guru_besar' => 'Guru Besar'
        ]; 
        $all_data['fungsional'] = collect([]);
        foreach ($fungsional as $key => $value) {
            $all_data['fungsional']->put($key, collect([
                'nama' => $value,
                'pria' => 0,
                'wanita' => 0,
                'total' => 0
            ]));
        }

        $golongan = [
            'a' => 'II/A',
            'b' => 'II/B',
            'c' => 'II/C',
            'd' => 'II/D',
            'e' => 'III/A',
            'f' => 'III/B',
            'g' => 'III/C',
            'h' => 'III/D',
            'i' => 'IV/A',
            'j' => 'IV/B',
            'k' => 'IV/C',
            'l' => 'IV/D',
            'm' => 'IV/E',
        ];
        $all_data['golongan'] = collect([]);
        foreach ($golongan as $key => $value) {
            $all_data['golongan']->put($key, collect([
                'nama' => $value,
                'pria' => 0,
                'wanita' => 0,
                'total' => 0
            ]));
        }

        //Perulangan Fakultas
        foreach ($data as $d) {

            //Membuat variabel di collection $data
            $d['total_dosen'] = 0;
            $d['jenis_kelamin'] = collect([
                'pria' => 0,
                'wanita' => 0,
                'total' => 0
            ]);

            $d['pendidikan'] = collect();
            foreach ($pendidikan as $p) {
                $d['pendidikan'][$p] = collect([
                    'pria' => 0,
                    'wanita' => 0,
                    'total' => 0
                ]);
            }

            $d['fungsional'] = collect([]);
            foreach ($fungsional as $key => $value) {
                $d['fungsional']->put($key, collect([
                    'nama' => $value,
                    'pria' => 0,
                    'wanita' => 0,
                    'total' => 0
                ]));
            }

            $d['golongan'] = collect([]);
            foreach ($golongan as $key => $value) {
                $d['golongan']->put($key, collect([
                    'nama' => $value,
                    'pria' => 0,
                    'wanita' => 0,
                    'total' => 0
                ]));
            }

            foreach ($d['prodi'] as $p) {

                //Membuat variabel di collection $data
                $p['total_dosen'] = 0;
                $p['jenis_kelamin'] = collect([
                    'pria' => 0,
                    'wanita' => 0,
                    'total' => 0
                ]);

                $p['pendidikan'] = collect();
                foreach ($pendidikan as $pd) {
                    $p['pendidikan'][$pd] = collect([
                        'pria' => 0,
                        'wanita' => 0,
                        'total' => 0
                    ]);
                }

                $p['fungsional'] = collect([]);
                foreach ($fungsional as $key => $value) {
                    $p['fungsional']->put($key, collect([
                        'nama' => $value,
                        'pria' => 0,
                        'wanita' => 0,
                        'total' => 0
                    ]));
                }

                $p['golongan'] = collect([]);
                foreach ($golongan as $key => $value) {
                    $p['golongan']->put($key, collect([
                        'nama' => $value,
                        'pria' => 0,
                        'wanita' => 0,
                        'total' => 0
                    ]));
                }

                //Mengolah data //loop dosen
                foreach ($p['dosen_homebase'] as $m) {

                    $all_data['total_dosen'] += 1;
                    $d['total_dosen'] += 1;
                    $p['total_dosen'] += 1;

                    //Mengolah data Jenis Kelamin
                    $p['jenis_kelamin']['total'] += 1;
                    $d['jenis_kelamin']['total'] += 1;
                    $all_data['jenis_kelamin']['total'] += 1;

                    if ($m['kelamin'] == 1) {
                        $p['jenis_kelamin']['wanita'] += 1;
                        $d['jenis_kelamin']['wanita'] += 1;
                        $all_data['jenis_kelamin']['wanita'] += 1;
                    } elseif ($m['kelamin'] == 0) {
                        $p['jenis_kelamin']['pria'] += 1;
                        $d['jenis_kelamin']['pria'] += 1;
                        $all_data['jenis_kelamin']['pria'] += 1;
                    }

                    //Mengelola Data Pendidikan
                    $temp_pend = '';
                    if ($m['pendidikan'] == 1) {
                        $temp_pend = 'S1';
                    }elseif ($m['pendidikan'] == 2){
                        $temp_pend = 'S2';
                    }elseif ($m['pendidikan'] == 3){
                        $temp_pend = 'S3';
                    }

                    if ($temp_pend != '') {
                        $all_data['pendidikan'][$temp_pend]['total'] += 1;
                        $d['pendidikan'][$temp_pend]['total'] += 1;
                        $p['pendidikan'][$temp_pend]['total'] += 1;

                        if ($m['kelamin'] == 1) {
                            $all_data['pendidikan'][$temp_pend]['wanita'] += 1;
                            $d['pendidikan'][$temp_pend]['wanita'] += 1;
                            $p['pendidikan'][$temp_pend]['wanita'] += 1;
                        } elseif ($m['kelamin'] == 0) {
                            $all_data['pendidikan'][$temp_pend]['pria'] += 1;
                            $d['pendidikan'][$temp_pend]['pria'] += 1;
                            $p['pendidikan'][$temp_pend]['pria'] += 1;
                        }
                    }

                    //Mengolah data Fungsional
                    $temp_fung = '';
                    if ($m['fungsional'] == 1) {
                        $temp_fung = 'asisten_ahli';
                    } elseif ($m['fungsional'] == 2) {
                        $temp_fung = 'lektor';
                    } elseif ($m['fungsional'] == 3) {
                        $temp_fung = 'lektor_kepala';
                    } elseif ($m['fungsional'] == 4) {
                        $temp_fung = 'guru_besar';
                    } elseif ($m['fungsional'] == 5) {
                        $temp_fung = 'tenaga_pengajar';
                    }

                    if ($temp_fung != '') {
                        $all_data['fungsional'][$temp_fung]['total'] += 1;
                        $d['fungsional'][$temp_fung]['total'] += 1;
                        $p['fungsional'][$temp_fung]['total'] += 1;

                        if ($m['kelamin'] == 1) {
                            $all_data['fungsional'][$temp_fung]['wanita'] += 1;
                            $d['fungsional'][$temp_fung]['wanita'] += 1;
                            $p['fungsional'][$temp_fung]['wanita'] += 1;
                        } elseif ($m['kelamin'] == 0) {
                            $all_data['fungsional'][$temp_fung]['pria'] += 1;
                            $d['fungsional'][$temp_fung]['pria'] += 1;
                            $p['fungsional'][$temp_fung]['pria'] += 1;
                        }
                    }

                    //Mengolah Data Golongan
                    $temp_gol = '';
                    if ($m['golongan'] == 'II/a') {
                        $temp_gol = 'a';
                    }elseif ($m['golongan'] == 'II/b') {
                        $temp_gol = 'b';
                    }elseif ($m['golongan'] == 'II/c') {
                        $temp_gol = 'c';
                    }elseif ($m['golongan'] == 'II/d') {
                        $temp_gol = 'd';
                    }elseif ($m['golongan'] == 'III/a') {
                        $temp_gol = 'e';
                    }elseif ($m['golongan'] == 'III/b') {
                        $temp_gol = 'f';
                    }elseif ($m['golongan'] == 'III/c') {
                        $temp_gol = 'g';
                    }elseif ($m['golongan'] == 'III/d') {
                        $temp_gol = 'h';
                    }elseif ($m['golongan'] == 'IV/a') {
                        $temp_gol = 'i';
                    }elseif ($m['golongan'] == 'IV/b') {
                        $temp_gol = 'j';
                    }elseif ($m['golongan'] == 'IV/c') {
                        $temp_gol = 'k';
                    }elseif ($m['golongan'] == 'IV/d') {
                        $temp_gol = 'l';
                    }elseif ($m['golongan'] == 'IV/e') {
                        $temp_gol = 'm';
                    }
                    
                    if ($temp_gol != '') {
                        $all_data['golongan'][$temp_gol]['total'] += 1;
                        $d['golongan'][$temp_gol]['total'] += 1;
                        $p['golongan'][$temp_gol]['total'] += 1;

                        if ($m['kelamin'] == 1) {
                            $all_data['golongan'][$temp_gol]['wanita'] += 1;
                            $d['golongan'][$temp_gol]['wanita'] += 1;
                            $p['golongan'][$temp_gol]['wanita'] += 1;
                        } elseif ($m['kelamin'] == 0) {
                            $all_data['golongan'][$temp_gol]['pria'] += 1;
                            $d['golongan'][$temp_gol]['pria'] += 1;
                            $p['golongan'][$temp_gol]['pria'] += 1;
                        }
                    }

                }
            }
        }

        return response()->json(['data' => $data->all(), 'status' => $all_data->all()], 200);
    }
}
