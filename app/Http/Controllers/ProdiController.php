<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdiController extends Controller
{
    //MENAMPILKAN PRODI KE BLADE
    public function index()
    {
        $this->authorize('view kelola prodi');

        $prodi = Prodi::orderBy('fakultas', 'ASC')->with('users')->get();
        $fakultas = Faculty::orderBy('code', 'ASC')->get();
        $user = User::whereRole(5)->with('prodi')->get();
        
        return view('admin.administrator.prodi.prodi', ['prodi' => $prodi, 'fakultas'=>$fakultas, 'user' => $user]);
    }

    //MENAMBAHKAN PRODI
    public function store(Request $request)
    {
        $this->authorize('tambah prodi');

        $validate = $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|numeric|unique:profils,kode|digits_between:4,10',
            'jenjang' => 'required|string|max:10',
            'fakultas' => 'required|integer|max:10'
        ]);

        $validate['nama'] = strtolower($request->nama);

        if (!Faculty::whereCode($request->fakultas)->first()) {
            return redirect()->back()->withErrors('Kode fakultas salah.');
        }

        DB::transaction(function () use ($validate) {
            Prodi::create($validate);  
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan prodi.');
    }

    //MENGHAPUS PRODI
    public function destroy(Request $request)
    {
        $this->authorize('hapus prodi');

        $request->validate(['id' => 'required|integer']);

        $prodi = Prodi::find($request->id);
        if (!$prodi) {return redirect()->back()->withErrors('Prodi tidak ditemukan.');}

        DB::transaction(function () use ($prodi) {
            $prodi->delete(); 
        });

        return redirect()->back()->with('success', 'Berhasil menghapus Program Studi.');
    }

    //LINKED AKUN
    public function link(Request $request)
    {
        $this->authorize('tambah prodi');

        $request->validate([
            'id' => 'required|integer',
            'account' => 'required|integer'
        ]);

        $prodi = Prodi::find($request->id);
        if (!$prodi) {return redirect()->back()->withErrors('Prodi tidak ditemukan.');}

        $user = User::find($request->account);
        if (!$user) {return redirect()->back()->withErrors('User tidak ditemukan.');}

        if ($user->prodi) { return redirect()->back()->withErrors('User tidak bisa di sambungkan.');}

        DB::transaction(function () use ($user, $request) {
            $user->update([ 'account' => $request->id ]);
        });

        return redirect()->back()->with('success', 'Berhasil menyambungkan akun.');
    }
}
