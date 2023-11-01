<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Activation;
use App\Models\Prodi;
use App\Models\Profil;
use App\Models\Akreditasi;
use App\Models\Faculty;
use App\Models\Dosen;
use App\Models\Pengaturan;
use App\Models\Subpengaturan;
use App\Models\Periode;
use App\Models\Mahasiswa;
use App\Models\IsianPengaturan;
use App\Models\IsianEvaluasiTambahan;
use App\Models\JadwalKuliah;
use App\Models\JadwalPengajar;
use App\Models\MataKuliah;
use App\Traits\ImportSpmiTrait;
use Database\Seeders\AktivitasMahasiswaMatematikaSeeder;
use Database\Seeders\DosenMatematikaSeeder;
use Database\Seeders\InstrumenAkreditasiSeeder;
use Database\Seeders\MahasiswaLulusMatematikaSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\ProdiSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\MahasiswaMatematikaSeeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     use ImportSpmiTrait;

    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        
        //$this->call(ProdiSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(InstrumenAkreditasiSeeder::class);
        $this->call(MahasiswaMatematikaSeeder::class);
        $this->call(DosenMatematikaSeeder::class);
        $this->call(AktivitasMahasiswaMatematikaSeeder::class);


        //Menambahkan Aktivasi
        Activation::create(['activation' => 1]);

        //Menambahkan Akreditasi
        Akreditasi::create(['code' => 0,'name' => 'Tidak Terakreditasi','singkatan' => '0',]); 
        Akreditasi::create(['code' => 1, 'name' => 'Terakreditasi A', 'singkatan' => 'A', ]); 
        Akreditasi::create(['code' => 2, 'name' => 'Terakreditasi B', 'singkatan' => 'B', ]); 
        Akreditasi::create(['code' => 3, 'name' => 'Terakreditasi C', 'singkatan' => 'C', ]);
        Akreditasi::create(['code' => 4, 'name' => 'Terakreditasi Unggul', 'singkatan' => 'Unggul', ]);
        Akreditasi::create(['code' => 5, 'name' => 'Terakreditasi Baik', 'singkatan' => 'Baik', ]);
        Akreditasi::create(['code' => 6, 'name' => 'Terakreditasi Baik Sekali', 'singkatan' => 'Baik Sekali', ]);

        //Menambahkan Fakultas
        Faculty::create([ 'code' => 1, 'name' => 'Keguruan dan Ilmu Pendidikan', 'singkatan' => 'FKIP', ]);
        Faculty::create([ 'code' => 2, 'name' => 'Ilmu Sosial dan Ilmu Politik', 'singkatan' => 'FISIP', ]);
        Faculty::create([ 'code' => 3, 'name' => 'Ekonomi', 'singkatan' => 'FEKON', ]);
        Faculty::create([ 'code' => 4, 'name' => 'Hukum', 'singkatan' => 'FAKUM', ]); 
        Faculty::create([ 'code' => 5, 'name' => 'Pertanian', 'singkatan' => 'FAPERTA', ]); 
        Faculty::create([ 'code' => 6, 'name' => 'Teknik', 'singkatan' => 'FATEK', ]); 
        Faculty::create([ 'code' => 7, 'name' => 'Matematika dan Ilmu Pengetahuan Alam', 'singkatan' => 'FMIPA', ]); Faculty::create([ 'code' => 8, 'name' => 'Kehutanan', 'singkatan' => 'FAHUT', ]); 
        Faculty::create([ 'code' => 9, 'name' => 'Kedokteran', 'singkatan' => 'FK', ]); 
        Faculty::create([ 'code' => 10, 'name' => 'Peternakan dan Perikanan', 'singkatan' => 'FAPETKAN', ]);
        Faculty::create([ 'code' => 11, 'name' => 'Kesehatan Masyarakat', 'singkatan' => 'FKM', ]); 
        Faculty::create([ 'code' => 12, 'name' => 'Pasca Sarjana', 'singkatan' => 'PASCASARJANA', ]); 
        Faculty::create([ 'code' => 13, 'name' => 'PSDKU Morowali', 'singkatan' => 'PSDKU MOROWALI', ]); 
        Faculty::create([ 'code' => 14, 'name' => 'PSDKU Tojo Una-Una', 'singkatan' => 'PSDKU TOUNA', ]);

        //Menambahkan Periode
        Periode::create(['tahun'=>2020, 'status'=>0]);
        Periode::create(['tahun'=>2021, 'status'=>0]);
        $tahun = Periode::create(['tahun'=>2022, 'status'=>1]);

        //Menambahkan Pengaturan dan Subpengaturan
        $this->buatPengaturanSubPengaturan($tahun->tahun);

        //Artisan::call('prodi-rekap-mahasiswa-aktif');
        Artisan::call('rekap-data-universitas');
        
    }
}
