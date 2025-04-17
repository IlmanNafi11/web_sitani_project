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
})->name('login');
Route::get('verif-email', fn() => view('pages.auth.email-verification'))->name('verifikasi-email');
Route::get('verifikasi-otp', fn() => view('pages.auth.otp-verification'))->name('verifikasi-otp');
Route::get('perbaru-sandi', fn() => view('pages.auth.reset-password'))->name('reset-password');
Route::get('/dashboard', function() {
    return view('pages.dashboard');
})->name('dashboard.admin');

Route::resource('bibit', BibitBerkualitasController::class);
Route::resource('desa', DesaController::class);
Route::resource('kecamatan', KecamatanController::class);
Route::resource('kelompok-tani', KelompokTaniController::class);
Route::resource('komoditas', KomoditasController::class);
Route::resource('penyuluh-terdaftar', PenyuluhTerdaftarController::class);
Route::resource('laporan-bibit', LaporanBibitController::class);

Route::get('test-component', fn()=> view('test-components'));
Route::get('kecamatan/{id}/desa', [DesaController::class, 'getByKecamatanId']);
Route::get('kecamatan/{id}/penyuluh', [PenyuluhTerdaftarController::class, 'getByKecamatanId']);
