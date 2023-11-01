<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Traits\StatusPeriodeTrait;

class DashboardController extends Controller
{
    use StatusPeriodeTrait;

    public function index()
    {

        //Return Halaman Dashboard
        return view('admin.dashboard.index');
    }
}
