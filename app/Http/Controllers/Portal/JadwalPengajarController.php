<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JadwalPengajarController extends Controller
{
    public function index()
    {
        return view('portaldata.jadwal');
    }

    public function get_data(Request $request)
    {
        $status = $request->status;
        $fakultas = $request->fakultas;
        $periode = Str::substr($request->tahun, 0, 4);
        $semester = Str::substr($request->tahun, 4, 1);
        $jenjang = $request->jenjang;

        $data = [];

        // Query data dengan filter fakultas dan jenjang sesuai parameter
        $query = Faculty::query();
        if ($fakultas != 0) {
            $query->where('code', $fakultas);
        }
        $query->with(['prodi' => function ($query) use ($periode, $semester) {
            $query->with(['jadwal' => function ($query) use ($periode, $semester) {
                $query->where('tahun', $periode)->where('semester', $semester)->with('mata_kuliah')->with(['dosen_pengajar' => function ($query) {
                    $query->with('rincian_dosen');
                }]);
            }]);
        }]);
        if ($jenjang != null) {
            $query->with(['prodi' => function ($query) use ($periode, $semester, $jenjang) {
                $query->where('jenjang', $jenjang)->with(['jadwal' => function ($query) use ($periode, $semester) {
                    $query->where('tahun', $periode)->where('semester', $semester)->with('mata_kuliah')->with('dosen_pengajar');
                }]);
            }]);
        }

        $data = $query->get();

        //Membuat Variabel
        $all_status = collect();
        $all_status['total_kelas'] = 0;
        $all_status['jumlah_kelas_pengajar'] = collect();

        $nama_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $all_status['hari_perkuliahan'] = collect();
        foreach ($nama_hari as $index => $nama) {
            $all_status['hari_perkuliahan']->push(collect([
                'nama' => $nama,
                'jumlah' => 0
            ]));
        }

        $all_status['jam_perkuliahan'] = collect();
        $all_status['jam_perkuliahan']->push(collect(['nama' => '07:00 - 07:30', 'jumlah' => 0]))->push(collect(['nama' => '07:30 - 08:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '08:00 - 08:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '08:30 - 09:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '09:00 - 09:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '09:30 - 10:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '10:00 - 10:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '10:30 - 11:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '11:00 - 11:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '11:30 - 12:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '12:00 - 12:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '12:30 - 13:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '13:00 - 13:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '13:30 - 14:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '14:00 - 14:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '14:30 - 15:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '15:00 - 15:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '15:30 - 16:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '16:00 - 16:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '16:30 - 17:00', 'jumlah' => 0]))
            ->push(collect(['nama' => '17:00 - 17:30', 'jumlah' => 0]))
            ->push(collect(['nama' => '17:30 - 18:00', 'jumlah' => 0]));

        //Perulangan fakulas
        foreach ($data as $fak) {

            //Membuat Variabel
            $fak['total_kelas'] = 0;
            $fak['jumlah_kelas_pengajar'] = collect();

            $fak['hari_perkuliahan'] = collect();
            foreach ($nama_hari as $index => $nama) {
                $fak['hari_perkuliahan']->push(collect([
                    'nama' => $nama,
                    'jumlah' => 0
                ]));
            }

            $fak['jam_perkuliahan'] = collect();
            $fak['jam_perkuliahan']->push(collect(['nama' => '07:00 - 07:30', 'jumlah' => 0]))->push(collect(['nama' => '07:30 - 08:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '08:00 - 08:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '08:30 - 09:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '09:00 - 09:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '09:30 - 10:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '10:00 - 10:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '10:30 - 11:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '11:00 - 11:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '11:30 - 12:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '12:00 - 12:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '12:30 - 13:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '13:00 - 13:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '13:30 - 14:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '14:00 - 14:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '14:30 - 15:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '15:00 - 15:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '15:30 - 16:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '16:00 - 16:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '16:30 - 17:00', 'jumlah' => 0]))
                ->push(collect(['nama' => '17:00 - 17:30', 'jumlah' => 0]))
                ->push(collect(['nama' => '17:30 - 18:00', 'jumlah' => 0]));

            //Perulangan Prodi
            foreach ($fak->prodi as $pro) {

                //Membuat Variabel
                $pro['total_kelas'] = 0;
                $pro['jumlah_kelas_pengajar'] = collect();

                $pro['hari_perkuliahan'] = collect();
                foreach ($nama_hari as $index => $nama) {
                    $pro['hari_perkuliahan']->push(collect([
                        'nama' => $nama,
                        'jumlah' => 0
                    ]));
                }

                $pro['jam_perkuliahan'] = collect();
                $pro['jam_perkuliahan']->push(collect(['nama' => '07:00 - 07:30', 'jumlah' => 0]))->push(collect(['nama' => '07:30 - 08:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '08:00 - 08:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '08:30 - 09:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '09:00 - 09:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '09:30 - 10:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '10:00 - 10:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '10:30 - 11:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '11:00 - 11:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '11:30 - 12:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '12:00 - 12:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '12:30 - 13:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '13:00 - 13:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '13:30 - 14:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '14:00 - 14:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '14:30 - 15:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '15:00 - 15:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '15:30 - 16:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '16:00 - 16:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '16:30 - 17:00', 'jumlah' => 0]))
                    ->push(collect(['nama' => '17:00 - 17:30', 'jumlah' => 0]))
                    ->push(collect(['nama' => '17:30 - 18:00', 'jumlah' => 0]));

                //Perulangan Jadwal
                foreach ($pro->jadwal as $jadwal) {
                    $all_status['total_kelas'] += 1;
                    $fak['total_kelas'] += 1;
                    $pro['total_kelas'] += 1;

                    //Jumlah Kelas Pengajar
                    foreach ($jadwal->dosen_pengajar as $e) {
                        $checks_alldata = -1;
                        foreach ($all_status['jumlah_kelas_pengajar'] as $i => $item) {
                            if ($item['nidn'] == $e['rincian_dosen']['nidn']) {
                                $checks_alldata = $i;
                                break;
                            }
                        }
                        if ($checks_alldata == -1) {
                            $all_status['jumlah_kelas_pengajar']->push(collect(['nidn' => $e['rincian_dosen']['nidn'], 'nama' => $e['rincian_dosen']['nama'], 'jumlah' => 1]));
                        } else {
                            $all_status['jumlah_kelas_pengajar'][$checks_alldata]['jumlah'] += 1;
                        }

                        $checks_fak = -1;
                        foreach ($fak['jumlah_kelas_pengajar'] as $i => $item) {
                            if ($item['nidn'] == $e['rincian_dosen']['nidn']) {
                                $checks_fak = $i;
                                break;
                            }
                        }
                        if ($checks_fak == -1) {
                            $fak['jumlah_kelas_pengajar']->push(collect(['nidn' => $e['rincian_dosen']['nidn'], 'nama' => $e['rincian_dosen']['nama'], 'jumlah' => 1]));
                        } else {
                            $fak['jumlah_kelas_pengajar'][$checks_fak]['jumlah'] += 1;
                        }

                        $checks_pro = -1;
                        foreach ($pro['jumlah_kelas_pengajar'] as $i => $item) {
                            if ($item['nidn'] == $e['rincian_dosen']['nidn']) {
                                $checks_pro = $i;
                                break;
                            }
                        }
                        if ($checks_pro == -1) {
                            $pro['jumlah_kelas_pengajar']->push(collect(['nidn' => $e['rincian_dosen']['nidn'], 'nama' => $e['rincian_dosen']['nama'], 'jumlah' => 1]));
                        } else {
                            $pro['jumlah_kelas_pengajar'][$checks_pro]['jumlah'] += 1;
                        }
                    }

                    //Jumlah Hari Perkuliahan
                    $index_hari = $jadwal['hari'] - 1;
                    $all_status['hari_perkuliahan'][$index_hari]['jumlah'] += 1;
                    $fak['hari_perkuliahan'][$index_hari]['jumlah'] += 1;
                    $pro['hari_perkuliahan'][$index_hari]['jumlah'] += 1;

                    //Jumlah Jam Perkuliahan
                    $index_waktu = -1;
                    if ($jadwal['jam_mulai'] >= '07:00' && $jadwal['jam_selesai'] < '07:30') {
                        $index_waktu = 0;
                    } elseif ($jadwal['jam_mulai'] >= '07:30' && $jadwal['jam_mulai'] < '08:00') {
                        $index_waktu = 1;
                    } elseif ($jadwal['jam_mulai'] >= '08:00' && $jadwal['jam_mulai'] < '08:30') {
                        $index_waktu = 2;
                    } elseif ($jadwal['jam_mulai'] >= '08:30' && $jadwal['jam_mulai'] < '09:00') {
                        $index_waktu = 3;
                    } elseif ($jadwal['jam_mulai'] >= '09:00' && $jadwal['jam_mulai'] < '09:30') {
                        $index_waktu = 4;
                    } elseif ($jadwal['jam_mulai'] >= '09:30' && $jadwal['jam_mulai'] < '10:00') {
                        $index_waktu = 5;
                    } elseif ($jadwal['jam_mulai'] >= '10:00' && $jadwal['jam_mulai'] < '10:30') {
                        $index_waktu = 6;
                    } elseif ($jadwal['jam_mulai'] >= '10:30' && $jadwal['jam_mulai'] < '11:00') {
                        $index_waktu = 7;
                    } elseif ($jadwal['jam_mulai'] >= '11:00' && $jadwal['jam_mulai'] < '11:30') {
                        $index_waktu = 8;
                    } elseif ($jadwal['jam_mulai'] >= '11:30' && $jadwal['jam_mulai'] < '12:00') {
                        $index_waktu = 9;
                    } elseif ($jadwal['jam_mulai'] >= '12:00' && $jadwal['jam_mulai'] < '12:30') {
                        $index_waktu = 10;
                    } elseif ($jadwal['jam_mulai'] >= '12:30' && $jadwal['jam_mulai'] < '13:00') {
                        $index_waktu = 11;
                    } elseif ($jadwal['jam_mulai'] >= '13:00' && $jadwal['jam_mulai'] < '13:30') {
                        $index_waktu = 12;
                    } elseif ($jadwal['jam_mulai'] >= '13:30' && $jadwal['jam_mulai'] < '14:00') {
                        $index_waktu = 13;
                    } elseif ($jadwal['jam_mulai'] >= '14:00' && $jadwal['jam_mulai'] < '14:30') {
                        $index_waktu = 14;
                    } elseif ($jadwal['jam_mulai'] >= '14:30' && $jadwal['jam_mulai'] < '15:00') {
                        $index_waktu = 15;
                    } elseif ($jadwal['jam_mulai'] >= '15:00' && $jadwal['jam_mulai'] < '15:30') {
                        $index_waktu = 16;
                    } elseif ($jadwal['jam_mulai'] >= '15:30' && $jadwal['jam_mulai'] < '16:00') {
                        $index_waktu = 17;
                    } elseif ($jadwal['jam_mulai'] >= '16:00' && $jadwal['jam_mulai'] < '16:30') {
                        $index_waktu = 18;
                    } elseif ($jadwal['jam_mulai'] >= '16:30' && $jadwal['jam_mulai'] < '17:00') {
                        $index_waktu = 19;
                    } elseif ($jadwal['jam_mulai'] >= '17:00' && $jadwal['jam_mulai'] < '17:30') {
                        $index_waktu = 20;
                    } elseif ($jadwal['jam_mulai'] >= '17:30' && $jadwal['jam_mulai'] < '18:00') {
                        $index_waktu = 21;
                    }

                    if ($index_waktu != -1) {
                        $all_status['jam_perkuliahan'][$index_waktu]['jumlah'] += 1;
                        $fak['jam_perkuliahan'][$index_waktu]['jumlah'] += 1;
                        $pro['jam_perkuliahan'][$index_waktu]['jumlah'] += 1;
                    }
                }
            }
        }

        return response()->json(['data' => $data->all(), 'status' => $all_status], 200);
    }
}
