<?php

namespace App\Console\Commands;

use App\Models\DosenHomebase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ImportDosenAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dosen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Semua Dosen HomeBase Untad';

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
        $this->info('Mulai melakukan import ...');

        $filePath = public_path('json/data_dosen_hasil_pddikti.json');
        $jsonString = File::get($filePath);
        $dosen = collect(json_decode($jsonString));

        $ds = DosenHomebase::all();

        foreach ($ds as $hb) {
            $hb->delete();
        }

        $count_true = 0;
        $count_dosen = count($dosen);

        foreach ($dosen as $i) {

            $kelamin = $i->jk == 'L' ? 0 : 1;
            $pendidikan = 2;
            $pendidikan_s2 = '';
            $pendidikan_s3 = '';

            $pend_s1 = collect($i->pendidikan)->where('nm_jenj_didik', 'Profesi')->first();
            if ($pend_s1) {
                $pendidikan = 4;
            }

            $pend_s1 = collect($i->pendidikan)->where('nm_jenj_didik', 'S1')->first();
            if ($pend_s1) {
                $pendidikan = 1;
            }

            $pend_s1 = collect($i->pendidikan)->where('nm_jenj_didik', 'S2')->first();
            if ($pend_s1) {
                $pendidikan = 2;
            }

            $pend_s1 = collect($i->pendidikan)->where('nm_jenj_didik', 'S3')->first();
            if ($pend_s1) {
                $pendidikan = 3;
            }


            foreach ($i->pendidikan as $m) {
                if ($m->nm_jenj_didik == 'S2') {
                    $pendidikan_s2 = $m->nm_sp_formal;
                    break;
                }
            }

            foreach ($i->pendidikan as $m) {
                if ($m->nm_jenj_didik == 'S3') {
                    $pendidikan_s3 = $m->nm_sp_formal;
                    break;
                }
            }

            $nomor_sertifikasi = '';
            foreach ($i->sertifikasi as $n) {
                if ($n->nm_jns_sert == "Sertifikasi Dosen") {
                    $nomor_sertifikasi = $n->sk_sert;
                }
            }

            $fungsional = 5;
            foreach ($i->jabatan_fungsional as $s) {
                switch ($s->nm_jabfung) {
                    case 'Asisten Ahli':
                        $fungsional = 1;
                        break;
                    case 'Lektor':
                        $fungsional = 2;
                        break;
                    case 'Lektor Kepala':
                        $fungsional = 3;
                        break;
                    case 'Profesor':
                        $fungsional = 4;
                        break;
                    case 'Tenaga Pengajar':
                        $fungsional = 5;
                        break;
                }
            }

            $golongan = null;
            foreach ($i->golongan as $m) {
                if ($m->nm_pangkat != '') {
                    
                    if ($m->nm_pangkat == 'Penata Muda') {
                        $golongan = 'III/a';
                    }else if ($m->nm_pangkat == 'Penata Muda Tk. I') {
                        $golongan = 'III/b';
                    }else if ($m->nm_pangkat == 'Penata') {
                        $golongan = 'III/c';
                    }else if ($m->nm_pangkat == 'Penata Tk. I') {
                        $golongan = 'III/d';
                    }else if ($m->nm_pangkat == 'Pembina') {
                        $golongan = 'IV/a';
                    }else if ($m->nm_pangkat == 'Pembina Tk. I') {
                        $golongan = 'IV/b';
                    }else if ($m->nm_pangkat == 'Pembina Utama Muda') {
                        $golongan = 'IV/c';
                    }
                }
            }

            try {
                DosenHomebase::create([
                    'nama' => $i->nm_sdm,
                    'nidn' => $i->nidn,
                    'homebase' => $i->homebase,
                    'kelamin' => $kelamin,
                    'pendidikan' => $pendidikan,
                    'bidang_keahlian' => '',
                    'kesesuaian_kompetensi' => true,
                    'kesesuaian_matakuliah' => true,
                    'pendidikan_magister' => $pendidikan_s2,
                    'pendidikan_doctoral' => $pendidikan_s3,
                    'nomor_sertifikasi' => $nomor_sertifikasi,
                    'fungsional' => $fungsional,
                    'golongan' => $golongan,
                ]);

                $count_true++;

                $this->info($count_true . ' / ' . $count_dosen . ' - Data berhasil di kirim dosen : ' . $i->nm_sdm);
            } catch (\Throwable $th) {
                $this->info($th);
                break;
                $this->info('Gagal !');
            }
        }

        $this->info('Data berhasil di kirim semuanya');



        // $ds = DosenHomebase::all();

        // foreach ($ds as $hb) {
        //     $hb->delete();
        // }

        // $filePath = public_path('json/prodi_untad_pddikti.json');
        // $filePath2 = public_path('json/dosen_from_feeder_untad.json');

        // // Membaca isi file JSON ke dalam string
        // $jsonString = File::get($filePath);
        // $jsonString2 = File::get($filePath2);

        // // Mengubah JSON menjadi koleksi (collection)
        // $prodi_untad = collect(json_decode($jsonString));
        // $dosen_pddikti = collect(json_decode($jsonString2));

        // $dosen_pddikti_dosen = collect($dosen_pddikti[0]);

        // $filter_dosen_pddikti = $dosen_pddikti_dosen->filter(function ($item) {
        //     return $item->a_sp_homebase == 1;
        // })->values();

        // $count_true = 0;
        // $count_false = 0;

        // $prodi_false = collect();

        // foreach ($filter_dosen_pddikti as &$ds) {
        //     $cek = $prodi_untad->where('lembaga', $ds->nm_lemb)->first();
        //     if ($cek) {
        //         $count_true++;
        //         $ds->homebase = $cek->kode;
        //     } else {
        //         $ds->homebase = null;
        //         $count_false++;
        //         $prodi_false->push($ds->nm_lemb);
        //     }
        // }

        // //Filter ke prodi yang aktif
        // $filter_dosen_pddikti = $filter_dosen_pddikti->filter(function ($i) {
        //     return $i->homebase != null;
        // });

        // $this->info('Jumlah dosen yang true: ' . $count_true);
        // $this->info('Jumlah dosen yang false: ' . $count_false);
        // $this->info('Prodi dosen yang false: ' . $prodi_false);
        // $this->info('Jumlah dosen setelah di hapus prodi tutup: ' . count($filter_dosen_pddikti));

        // //Cari Data Lain

        // $token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZF9wZXJhbiI6Niwibm1fcGVyYW4iOiJBZG1pbiBQcm9kaSIsImlkX29yZ2FuaXNhc2kiOiI2MzM3NzliYy0zMWY3LTQ3NmUtYjY3ZC1jMzMzYjY3M2E4NzYiLCJubV9qZW5qX2RpZGlrIjoiUzEiLCJubV9sZW1iIjoiTWF0ZW1hdGlrYSIsImlkX3NtcyI6IjYzMzc3OWJjLTMxZjctNDc2ZS1iNjdkLWMzMzNiNjczYTg3NiIsImlkX3NwIjoiOGU1ZDE5NWEtMDAzNS00MWFhLWFmZWYtZGI3MTVhMzdiOGRhIiwidXNlcmlkIjoiYzNmNmM4OWYtZmY5My00Nzc1LTgxNTUtNmE5MDMwYzAzODAxIiwidXNlcm5hbWUiOiJtYXRlbWF0aWthbWlwYTEiLCJuYW1hIjoiV2FoeXUgRmFkaWwgUHJhc2V0eW8iLCJpZF9zbXQiOiIyMDIyMiIsIm5tX3NtdCI6IjIwMjIvMjAyMyBHZW5hcCIsImlkX3Robl9hamFyYW4iOiIyMDIyIiwiaWRfc210YmVyIjoiMjAyMjEiLCJubV9zbXRiZXIiOiIyMDIyLzIwMjMgR2FuamlsIiwicm9sZV9saXN0IjpbIkFkbWluIFByb2RpIl0sInJvbGVzIjpbeyJpZF9wZXJhbiI6Niwibm1fcGVyYW4iOiJBZG1pbiBQcm9kaSIsImlkX29yZ2FuaXNhc2kiOiI2MzM3NzliYy0zMWY3LTQ3NmUtYjY3ZC1jMzMzYjY3M2E4NzYiLCJubV9sZW1iIjoiUzEgTWF0ZW1hdGlrYSJ9XSwic2Vzc2lvbiI6IjRjNDA1NTQ0NGM0MDU1NDg0YTQwNGM0ODUxNDAxMCIsImFjY2Vzc190b2tlbiI6ImV5SmhiR2NpT2lKSVV6STFOaUlzSW5SNWNDSTZJa3BYVkNKOS5leUpwWkY5d1pYSmhiaUk2Tml3aWJtMWZjR1Z5WVc0aU9pSkJaRzFwYmlCUWNtOWthU0lzSW1sa1gyOXlaMkZ1YVhOaGMya2lPaUkyTXpNM056bGlZeTB6TVdZM0xUUTNObVV0WWpZM1pDMWpNek16WWpZM00yRTROellpTENKdWJWOXFaVzVxWDJScFpHbHJJam9pVXpFaUxDSnViVjlzWlcxaUlqb2lUV0YwWlcxaGRHbHJZU0lzSW1sa1gzTnRjeUk2SWpZek16YzNPV0pqTFRNeFpqY3RORGMyWlMxaU5qZGtMV016TXpOaU5qY3pZVGczTmlJc0ltbGtYM053SWpvaU9HVTFaREU1TldFdE1EQXpOUzAwTVdGaExXRm1aV1l0WkdJM01UVmhNemRpT0dSaElpd2lkWE5sY21sa0lqb2lZek5tTm1NNE9XWXRabVk1TXkwME56YzFMVGd4TlRVdE5tRTVNRE13WXpBek9EQXhJaXdpZFhObGNtNWhiV1VpT2lKdFlYUmxiV0YwYVd0aGJXbHdZVEVpTENKdVlXMWhJam9pVjJGb2VYVWdSbUZrYVd3Z1VISmhjMlYwZVc4aUxDSnBaRjl6YlhRaU9pSXlNREl5TWlJc0ltNXRYM050ZENJNklqSXdNakl2TWpBeU15QkhaVzVoY0NJc0ltbGtYM1JvYmw5aGFtRnlZVzRpT2lJeU1ESXlJaXdpYVdSZmMyMTBZbVZ5SWpvaU1qQXlNakVpTENKdWJWOXpiWFJpWlhJaU9pSXlNREl5THpJd01qTWdSMkZ1YW1sc0lpd2ljbTlzWlY5c2FYTjBJanBiSWtGa2JXbHVJRkJ5YjJScElsMHNJbkp2YkdWeklqcGJleUpwWkY5d1pYSmhiaUk2Tml3aWJtMWZjR1Z5WVc0aU9pSkJaRzFwYmlCUWNtOWthU0lzSW1sa1gyOXlaMkZ1YVhOaGMya2lPaUkyTXpNM056bGlZeTB6TVdZM0xUUTNObVV0WWpZM1pDMWpNek16WWpZM00yRTROellpTENKdWJWOXNaVzFpSWpvaVV6RWdUV0YwWlcxaGRHbHJZU0o5WFN3aWMyVnpjMmx2YmlJNklqUmpOREExTlRRME5HTTBNRFUxTkRnMFlUUXdOR00wT0RVeE5EQXhNQ0lzSW1saGRDSTZNVFk1Tmprd05qRTROeXdpWlhod0lqb3hOamsyT1RBM09UZzNmUS5ueWhSbFBCSWg3bjZxWS1CQXZ3a0VDVDBMd3BrSjRHNldlUXJUUzZNSTNNIiwibm1fc3AiOiJNYXRlbWF0aWthIiwiaWF0IjoxNjk2OTA2MTk4LCJleHAiOjE2OTY5MDc5OTh9.a4aXLK0aqp7n4iRDVZOqsj1y80EIB6_xS0gWwEFWnSE';

        // $jumlah_dosen = count($filter_dosen_pddikti);

        // $counter = 0;

        // foreach ($filter_dosen_pddikti as &$dosens) {

        //     $counter++;

        //     $this->info('Kirim dosen: ' . $counter . ' / ' . $jumlah_dosen);

        //     try {
        //         //Mendapatkan Pendidikan dan SDM
        //         $pendidikan = Http::withHeaders([
        //             'Authorization' => $token,
        //         ])->get('http://feeder.untad.ac.id:8100/ws/dosen/riwayat/pendidikan/' . $dosens->id_sdm . '?filter=');

        //         if ($pendidikan) {
        //             $dosens->pendidikan = $pendidikan['detail'];
        //             $dosens->sdm = $pendidikan['sdm'];
        //         }


        //         // Mendapatkan Fungsional
        //         $fungsional = Http::withHeaders([
        //             'Authorization' => $token,
        //         ])->get('http://feeder.untad.ac.id:8100/ws/dosen/riwayat/fungsional/' . $dosens->id_sdm . '?filter=');

        //         if ($fungsional) {
        //             $dosens->jabatan_fungsional = $fungsional['detail'];
        //            if (!isset($dosens->sdm)) {
        //             $dosens->sdm = $fungsional['sdm'];
        //            }
        //         }

        //         //Mendapatkan Data Sertifikasi
        //         $sertifikasi = Http::withHeaders([
        //             'Authorization' => $token,
        //         ])->get('http://feeder.untad.ac.id:8100/ws/dosen/riwayat/sertifikasi/' . $dosens->id_sdm . '?filter=');

        //         if ($sertifikasi) {
        //             $dosens->sertifikasi = $sertifikasi['detail'];
        //             if (!isset($dosens->sdm)) {
        //                 $dosens->sdm = $sertifikasi['sdm'];
        //                }
        //         }

        //         //Kepangkatan Golongan
        //         $golongan = Http::withHeaders([
        //             'Authorization' => $token,
        //         ])->get('http://feeder.untad.ac.id:8100/ws/dosen/riwayat/kepangkatan/' . $dosens->id_sdm . '?filter=');

        //         if ($golongan) {
        //             $dosens->golongan = $golongan['detail'];
        //             if (!isset($dosens->sdm)) {
        //                 $dosens->sdm = $golongan['sdm'];
        //                }
        //         }

        //     } catch (\Throwable $th) {
        //         $this->info('Gagal !');
        //     }
        // }


        // $json = json_encode($filter_dosen_pddikti, JSON_PRETTY_PRINT);

        // $path = public_path('data_dosen_hasil_pddikti.json'); // Menyimpan file JSON di direktori public dengan nama data.json
        // file_put_contents($path, $json);

        $this->info('Data berhasil di simpan semuanya');
    }
}
