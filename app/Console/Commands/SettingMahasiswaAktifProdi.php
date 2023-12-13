<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\StatusMahasiswa;
use Illuminate\Console\Command;

class SettingMahasiswaAktifProdi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:aktif-prodi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $terkecuali = [44201, 44502];
        $prodi = collect([
            [
                "prodi" => 44201,
                "data" => [
                    [
                        "tahun" => 2022,
                        "semester" => 1,
                        "aktif" => 282
                    ],
                    [
                        "tahun" => 2022,
                        "semester" => 2,
                        "aktif" => 280
                    ],
                    [
                        "tahun" => 2021,
                        "semester" => 1,
                        "aktif" => 279
                    ],
                    [
                        "tahun" => 2021,
                        "semester" => 2,
                        "aktif" => 275
                    ],
                    [
                        "tahun" => 2020,
                        "semester" => 1,
                        "aktif" => 280
                    ],
                    [
                        "tahun" => 2020,
                        "semester" => 2,
                        "aktif" => 278
                    ],
                    [
                        "tahun" => 2019,
                        "semester" => 1,
                        "aktif" => 284
                    ],
                    [
                        "tahun" => 2019,
                        "semester" => 2,
                        "aktif" => 280
                    ],
                    [
                        "tahun" => 2018,
                        "semester" => 1,
                        "aktif" => 285
                    ],
                    [
                        "tahun" => 2018,
                        "semester" => 2,
                        "aktif" => 286
                    ],

                ]
            ],
            [
                "prodi" => 45201,
                "data" => [
                    [
                        "tahun" => 2021,
                        "semester" => 1,
                        "aktif" => 170
                    ],
                    [
                        "tahun" => 2021,
                        "semester" => 2,
                        "aktif" => 168
                    ],
                    [
                        "tahun" => 2020,
                        "semester" => 1,
                        "aktif" => 175
                    ],
                    [
                        "tahun" => 2020,
                        "semester" => 2,
                        "aktif" => 177
                    ],
                    [
                        "tahun" => 2019,
                        "semester" => 1,
                        "aktif" => 189
                    ],
                    [
                        "tahun" => 2019,
                        "semester" => 2,
                        "aktif" => 191
                    ],
                    [
                        "tahun" => 2018,
                        "semester" => 1,
                        "aktif" => 182
                    ],
                    [
                        "tahun" => 2018,
                        "semester" => 2,
                        "aktif" => 181
                    ],
                    [
                        "tahun" => 2017,
                        "semester" => 1,
                        "aktif" => 157
                    ],
                    [
                        "tahun" => 2017,
                        "semester" => 2,
                        "aktif" => 158
                    ],

                ]
            ]
        ]);

        foreach ($prodi as $item) {

            $this->info("Prodi " . $item['prodi']);

            $info_prodi = Prodi::where('kode', $item['prodi'])->first();
            if (!$info_prodi) {
                return 0;
            }

            foreach ($item['data'] as $i) {
                $this->info("Tahun " . $i['tahun'] . " Semester " . $i['semester']);

                $mahasiswa_aktif = StatusMahasiswa::where('kode_prodi', $item['prodi'])
                    ->where('status', 'aktif')
                    ->where('tahun', $i['tahun'])
                    ->where('semester', $i['semester'])
                    ->get();

                $ma = $mahasiswa_aktif->count();

                if ($ma != $i['aktif']) {

                    if ($ma < $i['aktif']) {

                        $selisih = $i['aktif'] - $ma;
                        $this->info("kurang : " . $selisih);
                        $cari_mahasiswa = Mahasiswa::where('kode_prodi', $item['prodi'])
                            ->where('tahun_masuk', '>=', $i['tahun'] - 5)
                            ->with('status_mahasiswa')
                            ->get()
                            ->filter(function ($i) {
                                return !isset($i->status_mahasiswa->id) || $i->status_mahasiswa->status == "cuti";
                            })
                            ->sortByDesc('tahun_masuk')->values();

                        $cari_aktif_hapus = StatusMahasiswa::where('status', 'aktif')
                            ->where('tahun', $i['tahun'])
                            ->where('semester', $i['semester'])
                            ->whereHas('prodi', function ($query) use ($terkecuali, $info_prodi) {
                                $query->where('jenjang', $info_prodi->jenjang)->whereNotIn('kode_prodi', $terkecuali);
                            })
                            ->get();

                        $this->info("Akan dihapus : " . $cari_aktif_hapus->count());

                        $mahasiswa_pilih = $cari_mahasiswa->take($selisih);
                        $count_berhasil = 0;

                        foreach ($mahasiswa_pilih as $mp) {
                            try {
                                StatusMahasiswa::create([
                                    "kode_prodi" => $item['prodi'],
                                    "tahun" => $i['tahun'],
                                    "semester" => $i['semester'],
                                    "mahasiswa_id" => $mp->id,
                                    'ipk' => (mt_rand(240, 370) / 100),
                                    'sks' => 0,
                                    'status' => 'aktif',
                                ]);
                                $count_berhasil++;
                            } catch (\Throwable $th) {
                            }
                        }

                        $mahasiswa_hapus = $cari_aktif_hapus->random($count_berhasil);

                        foreach ($mahasiswa_hapus as $ah) {
                            $ah->delete();
                        }

                        $this->info("Berhasil menambahkan mahasiswa aktif");

                    } else {

                        $selisih = $ma - $i['aktif'];
                        
                        $cari_aktif_hapus = StatusMahasiswa::where('status', 'aktif')
                            ->where('tahun', $i['tahun'])
                            ->where('semester', $i['semester'])
                            ->whereHas('prodi', function ($query) use ($item) {
                                $query->where('kode_prodi', $item['prodi']);
                            })
                            ->get()->random($selisih);

                        $count_berhasil = 0;
                        foreach ($cari_aktif_hapus as $cah) {
                            try {
                                $cah->delete();
                                $count_berhasil++;
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                        }

                        $cari_mahasiswa = Mahasiswa::whereNotIn('kode_prodi', $terkecuali)
                            ->where('tahun_masuk', '>=', $i['tahun'] - 5)
                            ->with('status_mahasiswa')
                            ->get()
                            ->filter(function ($i) {
                                return !isset($i->status_mahasiswa->id);
                            })
                            ->sortByDesc('tahun_masuk')
                            ->values()
                            ->random($count_berhasil);

                        foreach ($cari_mahasiswa as $cm) {
                            StatusMahasiswa::create([
                                "kode_prodi" => $cm->kode_prodi,
                                "tahun" => $i['tahun'],
                                "semester" => $i['semester'],
                                "mahasiswa_id" => $cm->id,
                                'ipk' => (mt_rand(240, 370) / 100),
                                'sks' => 0,
                                'status' => 'aktif',
                            ]);
                        }

                        $this->info("Berhasil mengurangi mahasiswa aktif");
                    }
                }else{
                    $this->info("Sudah Sama");
                }
            }
        }
        return 0;
    }
}
