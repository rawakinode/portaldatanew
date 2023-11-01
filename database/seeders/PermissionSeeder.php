<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Admin
        Permission::create(['name' => 'view kelola user']);
        Permission::create(['name' => 'view kelola prodi']);
        Permission::create(['name' => 'view kelola spmi']);
        Permission::create(['name' => 'view kelola periode']);
        Permission::create(['name' => 'view kelola validasi']);
        Permission::create(['name' => 'tambah user']);
        Permission::create(['name' => 'hapus user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'tambah prodi']);
        Permission::create(['name' => 'hapus prodi']);
        Permission::create(['name' => 'edit prodi']);
        Permission::create(['name' => 'ubah aktivasi']);
        Permission::create(['name' => 'ubah periode aktif']);
        Permission::create(['name' => 'tambah periode']);
        Permission::create(['name' => 'view rincian validasi']);
        Permission::create(['name' => 'konfirmasi validasi']);
        Permission::create(['name' => 'kelola dosen']);

        //Universitas
        Permission::create(['name' => 'pangkalan data universitas']);

        //Universitas & Prodi
        Permission::create(['name' => 'view spmi']);
        Permission::create(['name' => 'input spmi']);
        Permission::create(['name' => 'input spmi tambahan']);

        //Universitas & Rektor & Dekan
        Permission::create(['name' => 'view program studi']);
        Permission::create(['name' => 'akreditasi']);

        //Prodi
        Permission::create(['name' => 'view profil']);
        Permission::create(['name' => 'view pangkalan data']);
        Permission::create(['name' => 'input profil']);
        Permission::create(['name' => 'input mahasiswa']);
        Permission::create(['name' => 'input dosen']);

    }
}
