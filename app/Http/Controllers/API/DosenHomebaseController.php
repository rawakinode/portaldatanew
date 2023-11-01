<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DosenHomebase;
use Illuminate\Http\Request;

class DosenHomebaseController extends Controller
{
    public function index(Request $request){

        $search = $request->search;
        $query = DosenHomebase::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')->orWhere('nidn', 'like', '%' . $search . '%');
        }

        $dosen = $query->get();

        $data = $dosen->map(function ($i){
            unset($i['created_at']);
            unset($i['updated_at']);

            return $i;
        });

        return response()->json($data, 200);

    }
}
