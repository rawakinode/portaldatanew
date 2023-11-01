<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index(Request $request){

        $search = $request->search;
        $query = Prodi::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')->orWhere('kode', 'like', '%' . $search . '%');
        }

        $prodi = $query->get();
        $data = $prodi->map(function ($i){
            unset($i['created_at']);
            unset($i['updated_at']);

            return $i;
        });

        return response()->json($data, 200);

    }
}
