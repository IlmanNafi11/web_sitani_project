<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\KelompokTaniController;
use App\Http\Controllers\BibitBerkualitasController;
use App\Http\Controllers\LaporanBibitController;
use App\Http\Middleware\JwtMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware(JwtMiddleware::class);

Route::middleware('api')->group(function() {
    // Route::get('/user/{id}', [UserController::class, 'getUserById'])->whereNumber('id');
    Route::get('/komoditas', [KomoditasController::class, 'getAll']);
    Route::get('/komoditas/{id}', [KomoditasController::class, 'getById']);
    Route::get('/kelompok-tani', [KelompokTaniController::class, 'getAllByPenyuluh']);
    Route::get('/kelompok-tani/{id}', [KelompokTaniController::class, 'getById']);
    Route::get('/bibit', [BibitBerkualitasController::class, 'getAll']);
    Route::post('/laporan-kondisi', [LaporanBibitController::class, 'store']);
});
