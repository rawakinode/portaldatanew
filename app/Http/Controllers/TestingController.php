<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Prodi;


class TestingController extends Controller
{

    public function index()
    {
        $prodi = Prodi::all();
        return $prodi;
    }
}
