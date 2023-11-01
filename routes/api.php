<?php

use App\Http\Controllers\API\DosenHomebaseController;
use App\Http\Controllers\API\ProdiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Menampilkan semua prodi
Route::get('/prodi', [ProdiController::class, 'index'])->name('prodi');

// Menampilkan semua prodi
Route::get('/dosen_homebase', [DosenHomebaseController::class, 'index'])->name('dosen_homebase');
