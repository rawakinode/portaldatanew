<?php

namespace App\Traits;

use App\Models\Faculty;
use Illuminate\Http\Request;

trait UserTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    
     protected function terapkanRolesDanPermissionUser($user, $request)
     {
        if ($request->role == 5) {
            $user->assignRole('prodi');
            $user->givePermissionTo('view spmi');
            $user->givePermissionTo('input spmi');
            $user->givePermissionTo('input spmi tambahan');
            $user->givePermissionTo('view profil');
            $user->givePermissionTo('view pangkalan data');
            $user->givePermissionTo('input profil');
            $user->givePermissionTo('input mahasiswa');
            $user->givePermissionTo('input dosen');
        
        }
        
        if ($request->role == 4) {
            $user->assignRole('dekan');
            $user->givePermissionTo('view program studi');
            $user->givePermissionTo('akreditasi');
        }

        if ($request->role == 3) {
            $user->assignRole('rektor');
            $user->givePermissionTo('view program studi');
            $user->givePermissionTo('akreditasi');
        }

        if ($request->role == 2) {
            $user->assignRole('universitas');
            $user->givePermissionTo('view spmi');
            $user->givePermissionTo('input spmi');
            $user->givePermissionTo('input spmi tambahan');
            $user->givePermissionTo('view program studi');
            $user->givePermissionTo('akreditasi');
        }

        if ($request->role == 1) {
            $user->assignRole('admin');
            $user->givePermissionTo('view kelola user');
            $user->givePermissionTo('view kelola prodi');
            $user->givePermissionTo('view kelola spmi');
            $user->givePermissionTo('view kelola periode');
            $user->givePermissionTo('view kelola validasi');
            $user->givePermissionTo('tambah user');
            $user->givePermissionTo('hapus user');
            $user->givePermissionTo('edit user');
            $user->givePermissionTo('tambah prodi');
            $user->givePermissionTo('hapus prodi');
            $user->givePermissionTo('edit prodi');
            $user->givePermissionTo('ubah aktivasi');
            $user->givePermissionTo('ubah periode aktif');
            $user->givePermissionTo('tambah periode');
            $user->givePermissionTo('view rincian validasi');
            $user->givePermissionTo('konfirmasi validasi');
        }
     }

     protected function cekJikaFakultasAda($request)
     {
        if ($request->fakultas != 0) {
            if (!Faculty::whereCode($request->fakultas)->first()) {
                return redirect()->back()->withErrors('Fakultas tidak ada.');
            }    
        }
     }

     protected function cekJikaRolesAda($request)
     {
        if ($request->role > 5 || $request->role == 0) {
            return redirect()->back()->withErrors('Roles tidak dikenali.');
        }
     }

     protected function hapusRolesDanPermissions($user)
     {
        $user->removeRole('prodi');
        $user->revokePermissionTo('view spmi');
        $user->revokePermissionTo('input spmi');
        $user->revokePermissionTo('input spmi tambahan');
        $user->revokePermissionTo('view profil');
        $user->revokePermissionTo('view pangkalan data');
        $user->revokePermissionTo('input profil');
        $user->revokePermissionTo('input mahasiswa');
        $user->revokePermissionTo('input dosen');
    
        $user->removeRole('dekan');
        $user->revokePermissionTo('view program studi');
        $user->revokePermissionTo('akreditasi');

        $user->removeRole('rektor');
        $user->revokePermissionTo('view program studi');
        $user->revokePermissionTo('akreditasi');

        $user->removeRole('universitas');
        $user->revokePermissionTo('view spmi');
        $user->revokePermissionTo('input spmi');
        $user->revokePermissionTo('input spmi tambahan');
        $user->revokePermissionTo('view program studi');
        $user->revokePermissionTo('akreditasi');

        $user->removeRole('admin');
        $user->revokePermissionTo('view kelola user');
        $user->revokePermissionTo('view kelola prodi');
        $user->revokePermissionTo('view kelola spmi');
        $user->revokePermissionTo('view kelola periode');
        $user->revokePermissionTo('view kelola validasi');
        $user->revokePermissionTo('tambah user');
        $user->revokePermissionTo('hapus user');
        $user->revokePermissionTo('edit user');
        $user->revokePermissionTo('tambah prodi');
        $user->revokePermissionTo('hapus prodi');
        $user->revokePermissionTo('edit prodi');
        $user->revokePermissionTo('ubah aktivasi');
        $user->revokePermissionTo('ubah periode aktif');
        $user->revokePermissionTo('tambah periode');
        $user->revokePermissionTo('view rincian validasi');
        $user->revokePermissionTo('konfirmasi validasi');

     }

}