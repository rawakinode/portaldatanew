<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AuditKeuanganExternal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditKeuanganExternalController extends Controller
{
    public function index()
    {
        $auditKeuangan = AuditKeuanganExternal::all();

        return view('admin.administrator.audit.index', compact('auditKeuangan'));
    }

    public function create()
    {
        return view('admin.administrator.audit.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'lembaga' => 'required|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'opini' => 'nullable|string|max:200',
            'keterangan' => 'nullable|string|max:200',
        ];

        $validasi = $request->validate($rules);

        DB::transaction(function () use ($validasi) {
            AuditKeuanganExternal::create($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil menambahkan data.');
    }

    public function update(Request $request, $ids)
    {
        $rules = [
            'lembaga' => 'required|string|max:200',
            'tahun' => 'required|integer|digits:4',
            'opini' => 'nullable|string|max:200',
            'keterangan' => 'nullable|string|max:200',
        ];

        $validasi = $request->validate($rules);

        $data = AuditKeuanganExternal::findOrFail($ids);

        DB::transaction(function () use ($validasi, $data) {
            $data->update($validasi);
        });

        return redirect()->back()->with('success', 'Berhasil memperbarui data.');
    }

    public function edit($ids)
    {
        $audit = AuditKeuanganExternal::findOrFail($ids);

        return view('admin.administrator.audit.edit', compact('audit'));
    }

    public function destroy(Request $request)
    {
        $data = AuditKeuanganExternal::findOrFail($request->id);

        DB::transaction(function () use ($data){
            $data->delete();
        });

        return redirect()->back()->with('success', 'Berhasil menghapus data.');
    }
}
