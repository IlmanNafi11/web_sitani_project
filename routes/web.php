<?php

use App\Http\Controllers\BibitBerkualitasController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelompokTaniController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\LaporanBibitController;
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
Route::get('laporan-bibit', [LaporanBibitController::class, 'index'])->name('laporan-bibit.index');
Route::put('laporan-bibit/{id}', [LaporanBibitController::class, 'update'])->name('laporan-bibit.update');
Route::delete('laporan-bibit/{id}', [LaporanBibitController::class, 'destroy'])->name('laporan-bibit.destroy');


Route::get('test-component', fn()=> view('test-components'));
Route::get('kecamatan/{id}/desa', [DesaController::class, 'getByKecamatanId']);
Route::get('kecamatan/{id}/penyuluh', [PenyuluhTerdaftarController::class, 'getByKecamatanId']);
