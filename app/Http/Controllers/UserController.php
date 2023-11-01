<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use UserTrait;

    //MENAMPILKAN USER KE BLADE
    public function index()
    {
        $this->authorize('view kelola user');

        $user = User::orderBy('role', 'ASC')->orderBy('created_at', 'DESC')->get();
        $fakultas = Faculty::orderBy('code', 'ASC')->get();
        $roles = Role::all();
        
        return view('admin.administrator.user.user', ['user' => $user, 'fakultas' => $fakultas, 'role' => $roles]);
    }

    //MANEMBAHKAN USER
    public function create(Request $request)
    {
        $this->authorize('tambah user');

        $validate = $request->validate([
            'name' => 'required|string|max:20',
            'username' => 'required|alpha_dash|max:20|unique:users,username',
            'password' => 'required|confirmed',
            'role' => 'integer',
            'fakultas' => 'integer',
        ]);

        if ($request->role != 4) {
            $validate['fakultas'] = 0;
        }

        $validate['account'] = 0;
        $validate['password'] = bcrypt($request->password);

        $this->cekJikaRolesAda($request);
        $this->cekJikaFakultasAda($request);

        DB::transaction(function () use ($validate,$request) {
            $user = User::create($validate);
            if (!$user) { return redirect()->back()->withErrors('Gagal menambahkan user.'); }
            $this->terapkanRolesDanPermissionUser($user, $request);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan user.');

    }

    //EDIT UPDATE USER
    public function update(Request $request)
    {
        $this->authorize('edit user');

        $user = User::find($request->id);
        if(!$user){abort(403,'Id Tidak Ada.');}

        $rules = [
            'name' => 'string|max:20',
            'username' => 'alpha_dash|max:20|unique:users,username',
        ];
        
        if ($request->username == $user->username) { $rules['username'] = 'alpha_dash|max:20'; }

        $validate = $request->validate($rules);

        DB::transaction(function () use ($user, $validate) {
            $user->update($validate);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui user.');
    }

    //MENGHAPUS USER
    public function destroy(Request $request)
    {
        $this->authorize('hapus user');

        $request->validate(['id' => 'required|integer']);

        $user = User::find($request->id);
        if (!$user) {return redirect()->back()->withErrors('User tidak ditemukan.');}
        if ($user->role < 4) {return redirect()->back()->withErrors('User tidak boleh dihapus.');};

        DB::transaction(function () use ($user) {
            $this->hapusRolesDanPermissions($user);
            $user->delete(); 
        });

        return redirect()->back()->with('success', 'Berhasil menghapus user.');
    }

    //RESET PASSWORD 
    public function reset_password(Request $request)
    {
        $this->authorize('edit user');

        $validate = $request->validate([ 'password' => 'required|confirmed' ]);

        $validate['password'] = bcrypt($request->password);

        $user = User::find($request->id);
        if (!$user) {return redirect()->back()->withErrors('User tidak ditemukan.');}

        DB::transaction(function () use ($user, $validate) {
            $user->update($validate); 
        });

        return redirect()->back()->with('success', 'Berhasil mereset password user.');
    }
}
