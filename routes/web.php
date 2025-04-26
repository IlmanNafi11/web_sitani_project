<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthWebController;
use App\Http\Controllers\BibitBerkualitasController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelompokTaniController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\LaporanBibitController;
use App\Http\Controllers\PenyuluhTerdaftarController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

/**
 * Auth Routes (Tanpa middleware)
 */
Route::controller(AuthWebController::class)->group(function () {
    Route::get('admin', static fn() => view('pages.auth.login'))->name('login');
    Route::post('admin', 'login')->name('login.post');
    Route::get('admin/setup-password', static fn() => view('pages.auth.setup-password'))->name('setup-password');
    Route::post('admin/setup-password', 'setupPassword')->name('setup-password.post');
    Route::get('verif-email', fn() => view('pages.auth.email-verification'))->name('verifikasi-email');
    Route::post('verif-email', 'sendForgotPasswordEmail')->name('verifikasi-email.post');
});

/**
 * Auth Routes (Terproteksi OTP Session)
 */
Route::middleware('otp.session')->controller(AuthWebController::class)->group(function () {
    Route::get('verifikasi-otp', 'showOtpVerificationForm')->name('verifikasi-otp');
    Route::post('verifikasi-otp', 'verifyOtp')->name('verifikasi-otp.post');
    Route::post('verifikasi-otp/resend', 'resendOtp')->name('verifikasi-otp.resend');
    Route::get('perbaru-sandi', 'showResetPasswordForm')->name('reset-password');
    Route::post('perbaru-sandi', 'performPasswordReset')->name('reset-password.post');
});

/**
 * Route Panel Admin (Terproteksi)
 */
Route::middleware(['active.session', 'panel.admin.permission'])->group(function () {
    // Dashboard
    Route::get('admin/dashboard', fn() => view('pages.dashboard'))
        ->name('dashboard.admin');

    // Bibit Berkualitas
    Route::controller(BibitBerkualitasController::class)->prefix('admin/bibit')->group(function () {
        Route::get('/', 'index')->middleware('permission:bibit.lihat')->name('bibit.index');
        Route::get('create', 'create')->middleware('permission:bibit.tambah')->name('bibit.create');
        Route::post('/', 'store')->middleware('permission:bibit.tambah')->name('bibit.store');
        Route::get('{bibit}/edit', 'edit')->middleware('permission:bibit.ubah')->name('bibit.edit');
        Route::put('{bibit}', 'update')->middleware('permission:bibit.ubah')->name('bibit.update');
        Route::delete('{bibit}', 'destroy')->middleware('permission:bibit.hapus')->name('bibit.destroy');
        Route::get('{bibit}', 'show')->middleware('permission:bibit.lihat')->name('bibit.show');
    });

    // Desa
    Route::controller(DesaController::class)->prefix('admin/desa')->group(function () {
        Route::get('/', 'index')->middleware('permission:desa.lihat')->name('desa.index');
        Route::get('create', 'create')->middleware('permission:desa.tambah')->name('desa.create');
        Route::post('/', 'store')->middleware('permission:desa.tambah')->name('desa.store');
        Route::get('{desa}/edit', 'edit')->middleware('permission:desa.ubah')->name('desa.edit');
        Route::put('{desa}', 'update')->middleware('permission:desa.ubah')->name('desa.update');
        Route::delete('{desa}', 'destroy')->middleware('permission:desa.hapus')->name('desa.destroy');
        Route::get('{desa}', 'show')->middleware('permission:desa.lihat')->name('desa.show');
    });

    // Kecamatan
    Route::controller(KecamatanController::class)->prefix('admin/kecamatan')->group(function () {
        Route::get('/', 'index')->middleware('permission:kecamatan.lihat')->name('kecamatan.index');
        Route::get('create', 'create')->middleware('permission:kecamatan.tambah')->name('kecamatan.create');
        Route::post('/', 'store')->middleware('permission:kecamatan.tambah')->name('kecamatan.store');
        Route::get('{kecamatan}/edit', 'edit')->middleware('permission:kecamatan.ubah')->name('kecamatan.edit');
        Route::put('{kecamatan}', 'update')->middleware('permission:kecamatan.ubah')->name('kecamatan.update');
        Route::delete('{kecamatan}', 'destroy')->middleware('permission:kecamatan.hapus')->name('kecamatan.destroy');
        Route::get('{kecamatan}', 'show')->middleware('permission:kecamatan.lihat')->name('kecamatan.show');
    });

    // Kelompok Tani
    Route::controller(KelompokTaniController::class)->prefix('admin/kelompok-tani')->group(function () {
        Route::get('/', 'index')->middleware('permission:kelompok-tani.lihat')->name('kelompok-tani.index');
        Route::get('create', 'create')->middleware('permission:kelompok-tani.tambah')->name('kelompok-tani.create');
        Route::post('/', 'store')->middleware('permission:kelompok-tani.tambah')->name('kelompok-tani.store');
        Route::get('{kelompok_tani}/edit', 'edit')->middleware('permission:kelompok-tani.ubah')->name('kelompok-tani.edit');
        Route::put('{kelompok_tani}', 'update')->middleware('permission:kelompok-tani.ubah')->name('kelompok-tani.update');
        Route::delete('{kelompok_tani}', 'destroy')->middleware('permission:kelompok-tani.hapus')->name('kelompok-tani.destroy');
        Route::get('{kelompok_tani}', 'show')->middleware('permission:kelompok-tani.lihat')->name('kelompok-tani.show');
    });

    // Komoditas
    Route::controller(KomoditasController::class)->prefix('admin/komoditas')->group(function () {
        Route::get('/', 'index')->middleware('permission:komoditas.lihat')->name('komoditas.index');
        Route::get('create', 'create')->middleware('permission:komoditas.tambah')->name('komoditas.create');
        Route::post('/', 'store')->middleware('permission:komoditas.tambah')->name('komoditas.store');
        Route::get('{komoditas}/edit', 'edit')->middleware('permission:komoditas.ubah')->name('komoditas.edit');
        Route::put('{komoditas}', 'update')->middleware('permission:komoditas.ubah')->name('komoditas.update');
        Route::delete('{komoditas}', 'destroy')->middleware('permission:komoditas.hapus')->name('komoditas.destroy');
        Route::get('{komoditas}', 'show')->middleware('permission:komoditas.lihat')->name('komoditas.show');
    });

    // Penyuluh Terdaftar
    Route::controller(PenyuluhTerdaftarController::class)->prefix('admin/penyuluh-terdaftar')->group(function () {
        Route::get('/', 'index')->middleware('permission:penyuluh.lihat')->name('penyuluh-terdaftar.index');
        Route::get('create', 'create')->middleware('permission:penyuluh.tambah')->name('penyuluh-terdaftar.create');
        Route::post('/', 'store')->middleware('permission:penyuluh.tambah')->name('penyuluh-terdaftar.store');
        Route::get('{penyuluh_terdaftar}/edit', 'edit')->middleware('permission:penyuluh.ubah')->name('penyuluh-terdaftar.edit');
        Route::put('{penyuluh_terdaftar}', 'update')->middleware('permission:penyuluh.ubah')->name('penyuluh-terdaftar.update');
        Route::delete('{penyuluh_terdaftar}', 'destroy')->middleware('permission:penyuluh.hapus')->name('penyuluh-terdaftar.destroy');
        Route::get('{penyuluh_terdaftar}', 'show')->middleware('permission:penyuluh.lihat')->name('penyuluh-terdaftar.show');
    });

    // Laporan Bibit
    Route::controller(LaporanBibitController::class)->prefix('admin/laporan-bibit')->group(function () {
        Route::get('/', 'index')->middleware('permission:laporan-bibit.lihat')->name('laporan-bibit.index');
        Route::get('create', 'create')->middleware('permission:laporan-bibit.tambah')->name('laporan-bibit.create');
        Route::post('/', 'store')->middleware('permission:laporan-bibit.tambah')->name('laporan-bibit.store');
        Route::get('{laporan_bibit}/edit', 'edit')->middleware('permission:laporan-bibit.ubah')->name('laporan-bibit.edit');
        Route::put('{laporan_bibit}', 'update')->middleware('permission:laporan-bibit.ubah')->name('laporan-bibit.update');
        Route::delete('{laporan_bibit}', 'destroy')->middleware('permission:laporan-bibit.hapus')->name('laporan-bibit.destroy');
        Route::get('{laporan_bibit}', 'show')->middleware('permission:laporan-bibit.lihat')->name('laporan-bibit.show');
    });

    // Admin User Management
    Route::controller(AdminController::class)->prefix('admin/admin-users')->group(function () {
        Route::get('/', 'index')->middleware('permission:admin.lihat')->name('admin.index');
        Route::get('create', 'create')->middleware('permission:admin.tambah')->name('admin.create');
        Route::post('/', 'store')->middleware('permission:admin.tambah')->name('admin.store');
        Route::get('{id}/edit', 'edit')->middleware('permission:admin.ubah')->name('admin.edit');
        Route::put('{id}', 'update')->middleware('permission:admin.ubah')->name('admin.update');
        Route::delete('{id}', 'destroy')->middleware('permission:admin.hapus')->name('admin.destroy');
    });

    // Role & Permission Management
    Route::controller(RoleController::class)->prefix('admin/roles')->group(function () {
        Route::get('/', 'index')->middleware('permission:role-permission.lihat')->name('admin.roles.index');
        Route::get('create', 'create')->middleware('permission:role-permission.tambah')->name('admin.roles.create');
        Route::post('/', 'store')->middleware('permission:role-permission.tambah')->name('admin.roles.store');
        Route::delete('{id}', 'destroy')->middleware('permission:role-permission.hapus')->name('admin.roles.destroy');
        Route::get('{id}/edit', 'edit')->middleware('permission:role-permission.ubah')->name('admin.roles.edit');
        Route::put('{id}', 'update')->middleware('permission:role-permission.ubah')->name('admin.roles.update');
    });

    // Relasi Kecamatan-Desa/Penyuluh
    Route::get('kecamatan/{id}/desa', [DesaController::class, 'getByKecamatanId']);
    Route::get('kecamatan/{id}/penyuluh', [PenyuluhTerdaftarController::class, 'getByKecamatanId']);

    // Profil
    Route::get('profil', [AdminController::class, 'viewProfile'])->name('profile.index');
    Route::put('profil/{id}/edit', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Logout
    Route::post('admin/logout', [AuthWebController::class, 'logout'])->name('admin.logout');
});

// Untuk sementara nggk aku proteksi
Route::get('test-component', fn() => view('test-components'));
