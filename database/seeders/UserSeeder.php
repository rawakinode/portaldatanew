<?php

namespace Database\Seeders;

use App\Models\Prodi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Menambahkan Admin
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'adminuntad',
            'password' => bcrypt('vkrjvxr5wv'),
            'role' => 1,
            'account' => 0,
            'fakultas' => 0
        ]);
        $admin->assignRole('admin');
        $admin->givePermissionTo('view kelola user');
        $admin->givePermissionTo('view kelola prodi');
        $admin->givePermissionTo('view kelola spmi');
        $admin->givePermissionTo('view kelola periode');
        $admin->givePermissionTo('view kelola validasi');
        $admin->givePermissionTo('tambah user');
        $admin->givePermissionTo('hapus user');
        $admin->givePermissionTo('edit user');
        $admin->givePermissionTo('tambah prodi');
        $admin->givePermissionTo('hapus prodi');
        $admin->givePermissionTo('edit prodi');
        $admin->givePermissionTo('ubah aktivasi');
        $admin->givePermissionTo('ubah periode aktif');
        $admin->givePermissionTo('tambah periode');
        $admin->givePermissionTo('view rincian validasi');
        $admin->givePermissionTo('konfirmasi validasi');
        $admin->givePermissionTo('kelola dosen');

        //Menambahkan Universitas
        $universitas = User::create([
            'name' => 'Universitas Tadulako',
            'username' => 'universitas',
            'password' => bcrypt('6j1qmvzqh0'),
            'role' => 2,
            'account' => 0,
            'fakultas' => 0
        ]);
        $universitas->assignRole('universitas');
        $universitas->givePermissionTo('view spmi');
        $universitas->givePermissionTo('input spmi');
        $universitas->givePermissionTo('input spmi tambahan');
        $universitas->givePermissionTo('view program studi');
        $universitas->givePermissionTo('akreditasi');
        $universitas->givePermissionTo('view rincian validasi');
        $universitas->givePermissionTo('pangkalan data universitas');

        //Menambahkan Rektor
        $rektor = User::create([
            'name' => 'Rektor',
            'username' => 'rektor',
            'password' => bcrypt('8jpc75f6vq'),
            'role' => 3,
            'account' => 0,
            'fakultas' => 0
        ]);
        $rektor->assignRole('rektor');
        $rektor->givePermissionTo('view program studi');
        $rektor->givePermissionTo('akreditasi');
        $rektor->givePermissionTo('view rincian validasi');

        //Menambahkan Dekan
        $datadekan = [[ 'name' => 'FKIP', 'username' => 'fkipuntad', 'password' => bcrypt('os1hibt46a'), 'role' => 4, 'account' => 0, 'fakultas' => 1 ], [ 'name' => 'FISIP', 'username' => 'fisipuntad', 'password' => bcrypt('glk28yt3ys'), 'role' => 4, 'account' => 0, 'fakultas' => 2 ], [ 'name' => 'FEKON', 'username' => 'fekonuntad', 'password' => bcrypt('ehl3ulwozq'), 'role' => 4, 'account' => 0, 'fakultas' => 3 ], [ 'name' => 'FAKUM', 'username' => 'fakumuntad', 'password' => bcrypt('gqib72aqi1'), 'role' => 4, 'account' => 0, 'fakultas' => 4 ], [ 'name' => 'FAPERTA', 'username' => 'fapertauntad', 'password' => bcrypt('2mhpitumn8'), 'role' => 4, 'account' => 0, 'fakultas' => 5 ], [ 'name' => 'FATEK', 'username' => 'fatekuntad', 'password' => bcrypt('vxapuy8dys'), 'role' => 4, 'account' => 0, 'fakultas' => 6 ], [ 'name' => 'FMIPA', 'username' => 'fmipauntad', 'password' => bcrypt('hywn2hr1nw'), 'role' => 4, 'account' => 0, 'fakultas' => 7 ], [ 'name' => 'FAHUT', 'username' => 'fahutuntad', 'password' => bcrypt('vbcoevziyg'), 'role' => 4, 'account' => 0, 'fakultas' => 8 ], [ 'name' => 'FKEDOKTERAN', 'username' => 'dokteranuntad', 'password' => bcrypt('mpvioehy03'), 'role' => 4, 'account' => 0, 'fakultas' => 9 ], [ 'name' => 'FAPETKAN', 'username' => 'fapetkanuntad', 'password' => bcrypt('8isajilygw'), 'role' => 4, 'account' => 0, 'fakultas' => 10 ], [ 'name' => 'FKM', 'username' => 'fkmuntad', 'password' => bcrypt('h9ou2msb1p'), 'role' => 4, 'account' => 0, 'fakultas' => 11 ], [ 'name' => 'PASCA SARJANA', 'username' => 'pascasarjanauntad', 'password' => bcrypt('vdq1rkbvyr'), 'role' => 4, 'account' => 0, 'fakultas' => 12 ], [ 'name' => 'PSDKU MOROWALI', 'username' => 'psdkumorowaliuntad', 'password' => bcrypt('3k5g88dxit'), 'role' => 4, 'account' => 0, 'fakultas' => 13 ], [ 'name' => 'PSDKU TOUNA', 'username' => 'psdkutounauntad', 'password' => bcrypt('kzafbe46wn'), 'role' => 4, 'account' => 0, 'fakultas' => 14 ], ];

        foreach ($datadekan as $d) {
            $dekan = User::create($d);
            $dekan->assignRole('dekan');
            $dekan->givePermissionTo('view program studi');
            $dekan->givePermissionTo('akreditasi');
            $dekan->givePermissionTo('view rincian validasi');
        }

        //Menambahkan Prodi
        $filePath = public_path('json/prodi_untad_pddikti_kemendikbud.json');
        $jsonString = File::get($filePath);
        $data = collect(json_decode($jsonString));

        foreach ($data as $d) { 

            $createProdi = Prodi::create([
                'kode' => $d->kode_prodi,
                'nama' => $d->nm_lemb,
                'fakultas' => $d->fakultas,
                'jenjang' => $d->jenjang,
            ]);

            $prodi = User::create([
                'account' => $createProdi['id'],
                'name' => $d->nm_lemb,
                'username' => $d->username,
                'password' => bcrypt($d->password),
                'role' => $d->role,
                'fakultas' => $d->fakultas,
            ]);

            $prodi->assignRole('prodi');
            $prodi->givePermissionTo('view spmi');
            $prodi->givePermissionTo('input spmi');
            $prodi->givePermissionTo('input spmi tambahan');
            $prodi->givePermissionTo('view profil');
            $prodi->givePermissionTo('view pangkalan data');
            $prodi->givePermissionTo('input profil');
            $prodi->givePermissionTo('input mahasiswa');
            $prodi->givePermissionTo('input dosen');
        }

    }
}
