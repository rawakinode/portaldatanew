<?php

namespace App\Console\Commands;

use App\Models\PortalMahasiswaAktif;
use App\Models\Prodi;
use App\Models\StatusMahasiswa;
use Illuminate\Console\Command;

class HitungMahasiswaAktif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hitung:mahasiswa-aktif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk hitung status mahasiswa untuk portal data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $program_studi = Prodi::all();

        foreach ($program_studi as $pd) {

            $this->info("Menghitung status mahasiswa prodi : " . $pd->nama);
            
            $periode = collect([2022, 2021, 2020, 2019, 2018, 2017, 2016]);
            foreach ($periode as $pr) {

                $semester = collect([1, 2]);
                foreach ($semester as $sm) {

                    $status = collect(['aktif', 'nonaktif', 'cuti']);
                    foreach ($status as $st) {

                        //Hitung Aktifitas Perkuliahan
                        $aktivitas = StatusMahasiswa::where('status', $st)
                            ->where('tahun', $pr)
                            ->where('semester', $sm)
                            ->where('kode_prodi', $pd->kode)
                            ->with(['mahasiswa' => function ($query) {
                                return $query->with('prodi');
                            }])->get();

                        $aktivitas = $aktivitas->filter(function ($i) {
                            return isset($i->mahasiswa->prodi->jenjang);
                        });

                        $data = $this->hitung_data($aktivitas, $pr, $pd->kode);
                        $data = $data->all();


                        //Hitung Total dan Prodi
                        $p = Prodi::where('kode', $pd->kode)->first();
                        unset($p['created_at']);
                        unset($p['updated_at']);
                        $p->total = $aktivitas->count();

                        $c = PortalMahasiswaAktif::where('kode_prodi', $pd->kode)
                            ->where('status', $st)
                            ->where('tahun', $pr)
                            ->where('semester', $sm)
                            ->first();

                        if (!$c) {
                            PortalMahasiswaAktif::create([
                                'kode_prodi' => $pd->kode,
                                'fakultas' => $pd->fakultas,
                                'jenjang' => $pd->jenjang,
                                'tahun' => $pr,
                                'semester' => $sm,
                                'status' => $st,
                                'total' => $aktivitas->count(),
                                'jalur_masuk' => json_encode($data['jalurmasuk']),
                                'tahun_masuk' => json_encode($data['angkatan']),
                                'jenis_kelamin' => json_encode($data['jeniskelamin']),
                                'ipk' => json_encode($data['ipk']),
                            ]);
                        } else {
                            $c->update([
                                'fakultas' => $pd->fakultas,
                                'jenjang' => $pd->jenjang,
                                'tahun' => $pr,
                                'semester' => $sm,
                                'status' => $st,
                                'total' => $aktivitas->count(),
                                'jalur_masuk' => json_encode($data['jalurmasuk']),
                                'tahun_masuk' => json_encode($data['angkatan']),
                                'jenis_kelamin' => json_encode($data['jeniskelamin']),
                                'ipk' => json_encode($data['ipk']),
                            ]);
                        }
                    }
                }
            }
        }

        $this->info("Berhasil hitung semua status mahasiswa untuk semua prodi");
    }

    //Internal fungsi untuk menghitung
    private function hitung_data($aktivitas, $periode, $prodi)
    {

        $a = $aktivitas->filter(function ($i) use ($prodi) {
            return $i->mahasiswa->prodi->kode == $prodi;
        });

        //Tahun Angkatan
        $tahun_angkatan = collect([$periode - 6, $periode - 5, $periode - 4, $periode - 3, $periode - 2, $periode - 1, $periode - 0]);
        $angkatan = collect();

        foreach ($tahun_angkatan as $t) {
            $angkatan->push([
                'tahun' => $t,
                'pria' => $a->filter(function ($i) use ($t) {
                    return $i->mahasiswa->tahun_masuk == $t && $i->mahasiswa->kelamin == 1;
                })->count(),
                'wanita' => $a->filter(function ($i) use ($t) {
                    return $i->mahasiswa->tahun_masuk == $t && $i->mahasiswa->kelamin == 0;
                })->count(),
                'total' => $a->filter(function ($i) use ($t) {
                    return $i->mahasiswa->tahun_masuk == $t;
                })->count(),
            ]);
        }

        //Jalur Masuk
        $jalur = [];
        $j = collect(['snmptn', 'sbmptn', 'smmptn', 'lainnya']);
        foreach ($j as $item) {
            $jalur[$item] = [
                'jalur' => $item,
                'cowo' => $a->filter(function ($i) use ($item) {
                    return $i->mahasiswa->jalur_masuk == $item && $i->mahasiswa->kelamin == 1;
                })->count(),
                'cewe' => $a->filter(function ($i) use ($item) {
                    return $i->mahasiswa->jalur_masuk == $item && $i->mahasiswa->kelamin == 0;
                })->count(),
                'total' => $a->filter(function ($i) use ($item) {
                    return $i->mahasiswa->jalur_masuk == $item;
                })->count(),
            ];
        }

        //Jenis Kelamin
        $kelamin = collect(
            [
                'pria' => $a->filter(function ($i) use ($item) {
                    return $i->mahasiswa->kelamin == 1;
                })->count(),
                'wanita' => $a->filter(function ($i) use ($item) {
                    return $i->mahasiswa->kelamin == 0;
                })->count(),
                'total' => $a->count(),
            ]
        );

        //IPK
        $ipk = collect(
            [
                'a' => $a->filter(function ($i) {
                    return $i->ipk <= 2;
                })->count(),
                'b' => $a->filter(function ($i) {
                    return $i->ipk > 2 && $i->ipk <= 2.5;
                })->count(),
                'c' => $a->filter(function ($i) {
                    return $i->ipk > 2.5 && $i->ipk <= 3;
                })->count(),
                'd' => $a->filter(function ($i) {
                    return $i->ipk > 3 && $i->ipk <= 3.5;
                })->count(),
                'e' => $a->filter(function ($i) {
                    return $i->ipk > 3.5 && $i->ipk <= 4;
                })->count(),
            ]
        );

        $m = collect([
            'angkatan' => $angkatan,
            'jalurmasuk' => $jalur,
            'jeniskelamin' => $kelamin,
            'ipk' => $ipk,
        ]);

        return $m;
    }
}
