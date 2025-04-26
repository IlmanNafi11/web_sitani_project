<?php

use App\Http\Controllers\api\BibitController;
use App\Http\Controllers\api\KelompokTaniController;
use App\Http\Controllers\api\KomoditasController;
use App\Http\Controllers\api\LaporanBibitController;
use App\Http\Controllers\api\PenyuluhController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\Auth\AuthApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

/**
 * Route untuk fungsional login, register, otp, dan reset password
 */
Route::controller(AuthApiController::class)->group(function () {
    Route::post('login', 'login')->withoutMiddleware(JwtMiddleware::class)->name('login');
    Route::post('register', 'register')->withoutMiddleware(JwtMiddleware::class)->name('register');
    Route::post('validate-phone', 'validatePhone')->withoutMiddleware(JwtMiddleware::class)->name('validate-phone');
    Route::post('forgot-password', 'sendOtp')->withoutMiddleware(JwtMiddleware::class)->name('forgot-password');
    Route::post('verify-otp', 'validateOtp')->withoutMiddleware(JwtMiddleware::class)->name('verify-otp');
    Route::post('reset-password', 'passwordReset')->withoutMiddleware(JwtMiddleware::class)->name('reset-password');

});

/**
 * Route untuk memperbarui data penyuluh terdaftar.
 * Gunakan jika waktu proses registrasi data penyuluh tidak valid
 */
Route::post('users/penyuluh-terdaftar/{id}', [PenyuluhController::class, 'update'])->withoutMiddleware(JwtMiddleware::class);

/**
 * Route untuk mengambil data profil
 */
Route::get('users/{id}', [UserController::class, 'getProfile']);

/**
 * Route untuk mengambil data bibit berkualitas
 */
Route::get('bibit', [BibitController::class, 'getAll']);

/**
 * Route untuk mengambil seluruh data komoditas dan berdasarkan id komoditas
 */
Route::controller(KomoditasController::class)->group(function () {
    Route::get('komoditas/{id}','getById');
    Route::get('komoditas','getAll');
});

/**
 * Route untuk mengambil data kelompok tani berdasarkan id penyuluh dan id kelompok tani
 */
Route::controller(KelompokTaniController::class)->group(function () {
    Route::get('kelompok-tani', 'getAllByPenyuluhId');
    Route::get('kelompok-tani/{id}', 'getById');
});

/**
 * Route untuk mengirim laporan bibit dan mengambil history laporan bibit berdasarkan id penyuluh
 */
Route::controller(LaporanBibitController::class)->group(function () {
    Route::post('laporan-kondisi', 'saveReport');
    Route::get('history-laporan/{id}', 'getByPenyuluhId');
});
