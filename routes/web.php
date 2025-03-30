<?php

use App\Http\Controllers\BibitBerkualitasController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelompokTaniController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\PenyuluhTerdaftarController;
use Illuminate\Support\Facades\Route;

// sementara
Route::get('/', function () {
    return view('pages.auth.login');
});
Route::get('/dashboard', function() {
    return view('pages.dashboard');
})->name('dashboard.admin');

Route::resource('bibit', BibitBerkualitasController::class);
Route::resource('desa', DesaController::class);
Route::resource('kecamatan', KecamatanController::class);
Route::resource('kelompok-tani', KelompokTaniController::class);
Route::resource('komoditas', KomoditasController::class);
Route::resource('penyuluh-terdaftar', PenyuluhTerdaftarController::class);
