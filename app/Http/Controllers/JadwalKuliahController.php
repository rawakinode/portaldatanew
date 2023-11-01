<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\DosenHomebase;
use App\Models\JadwalKuliah;
use App\Models\JadwalPengajar;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalKuliahController extends Controller
{
    public function index()
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        //Cek jika ada request
        if (request('tahun') && request('semester')) {
            $jadwalkuliah = JadwalKuliah::whereKodeProdi($kodeprodi)->whereTahun(request('tahun'))->whereSemester(request('semester'))->get();
        }else{
            $jadwalkuliah = [];
        }
        return view('admin.pangkalan.jadwalkuliah.index', compact('jadwalkuliah'));
    }

    public function create()
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        return view('admin.pangkalan.jadwalkuliah.create');
    }

    public function edit($id)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $jadwal = JadwalKuliah::findOrFail($id);
        $pengajar = JadwalPengajar::whereJadwalKuliahId($jadwal->id)->orderBy('dosen_ke', 'ASC')->get();

        return view('admin.pangkalan.jadwalkuliah.edit', ['jadwal' => $jadwal, 'pengajar' => $pengajar]);
    }

    public function get_dosen_list(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        if ($request->has('keyword')) { // menggunakan has() untuk mengecek apakah keyword ada atau tidak
            $search = $request->keyword;
            $data = DosenHomebase::where(function ($query) use ($search) { // menggunakan closure untuk grouping kondisi
                $query->where('nidn', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like', '%' . $search . '%');
            })->get();
        } else {
            $data = []; // jika keyword tidak ada, set data sebagai array kosong
        }
        
        return response()->json(['keyword' => $request->keyword, 'data' => $data], 200);
    }

    public function store(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = [
            'kode_mk' => 'required|string|max:20',
            'tahun' => 'required|integer',
            'semester' => 'required|integer|max:5',
            'kelas' => 'required|string|max:20',
            'ruang' => 'required|string|max:100',
            'hari' => 'required|integer|max:7',
            'jam_mulai' => 'nullable|string|max:20',
            'jam_selesai' => 'nullable|string|max:20',
        ];
        $validasi = $request->validate($rules);

        $rules_pengajar = [
            'dosen1' => 'nullable|string|max:20',
            'dosen2' => 'nullable|string|max:20',
            'dosen3' => 'nullable|string|max:20',
        ];

        $request->validate($rules_pengajar);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;

        $find = MataKuliah::whereKodeProdi($kodeprodi)->whereKode($request->kode_mk)->get();
        if (!$find->count()) {
            return redirect()->back()->withErrors(['kode_mk' => 'Mata kuliah tidak ditemukan. Harap input kurikulum.'])->withInput();
        }

        DB::transaction(function () use ($validasi, $request){
            $storing = JadwalKuliah::create($validasi);
            if ($storing) {
                if ($request->dosen1) {
                    JadwalPengajar::create([
                        'jadwal_kuliah_id' => $storing->id,
                        'dosen_nidn' => $request->dosen1,
                        'dosen_ke' => 1
                    ]);
                }
                if ($request->dosen2) {
                    JadwalPengajar::create([
                        'jadwal_kuliah_id' => $storing->id,
                        'dosen_nidn' => $request->dosen2,
                        'dosen_ke' => 2
                    ]);
                }
                if ($request->dosen3) {
                    JadwalPengajar::create([
                        'jadwal_kuliah_id' => $storing->id,
                        'dosen_nidn' => $request->dosen3,
                        'dosen_ke' => 3
                    ]);
                }
            }
        });

        return redirect('/prodi/data/jadwalkuliah?tahun='.$request->tahun.'&semester='.$request->semester)->with('success', 'Berhasil menambahkan jadwal kuliah.');

    }

    public function update(Request $request, $id)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = [
            'kode_mk' => 'required|string|max:20',
            'kelas' => 'required|string|max:20',
            'ruang' => 'required|string|max:100',
            'hari' => 'required|integer|max:7',
            'jam_mulai' => 'nullable|string|max:20',
            'jam_selesai' => 'nullable|string|max:20',
        ];
        $validasi = $request->validate($rules);

        $rules_pengajar = [
            'dosen1' => 'nullable|string|max:20',
            'dosen2' => 'nullable|string|max:20',
            'dosen3' => 'nullable|string|max:20',
        ];

        $request->validate($rules_pengajar);

        //Cek periode dan Prodi
        $kodeprodi = auth()->user()->prodi['kode'];
        $validasi['kode_prodi'] = $kodeprodi;

        $data = JadwalKuliah::whereKodeProdi($kodeprodi)->whereId($id)->first();
        if (!$data) { abort(404);}

        $find = MataKuliah::whereKodeProdi($kodeprodi)->whereKode($request->kode_mk)->get();
        if (!$find->count()) {
            return redirect()->back()->withErrors(['kode_mk' => 'Mata kuliah tidak ditemukan. Harap input kurikulum.'])->withInput();
        }

        $pengajar = JadwalPengajar::whereJadwalKuliahId($id)->get();

        DB::transaction(function () use ($validasi, $request, $data, $pengajar, $id){

            $updating = $data->update($validasi);

            foreach ($pengajar as $p) {
                $p->delete();
            }

            if ($updating) {
                if ($request->dosen1) {
                    JadwalPengajar::create([
                        'jadwal_kuliah_id' => $id,
                        'dosen_nidn' => $request->dosen1,
                        'dosen_ke' => 1
                    ]);
                }
                if ($request->dosen2) {
                    JadwalPengajar::create([
                        'jadwal_kuliah_id' => $id,
                        'dosen_nidn' => $request->dosen2,
                        'dosen_ke' => 2
                    ]);
                }
                if ($request->dosen3) {
                    JadwalPengajar::create([
                        'jadwal_kuliah_id' => $id,
                        'dosen_nidn' => $request->dosen3,
                        'dosen_ke' => 3
                    ]);
                }
            }
        });
        
        return redirect()->back()->with('success', 'Berhasil menambahkan jadwal kuliah.');
    }

    public function destroy(Request $request)
    {
        //Permission Role Set
        $this->authorize('view pangkalan data');

        $rules = ['id' => 'required|integer'];
        $request->validate($rules);

        //Cek Prodi
        $kodeprodi = auth()->user()->prodi['kode'];

        $data = JadwalKuliah::whereId($request->id)->whereKodeProdi($kodeprodi)->first();
        $pengajar = JadwalPengajar::whereJadwalKuliahId($request->id)->get();

        DB::transaction(function () use ($data, $pengajar){
            $data->delete();
            foreach ($pengajar as $p) {
                $p->delete();
            }
        });
        
        return redirect()->back()->with('success', 'Berhasil menghapus jadwal kuliah.');

    }

}
