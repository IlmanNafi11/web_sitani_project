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
 * Auth Routes(Tanpa middleware)
 */
Route::controller(AuthWebController::class)->group(function() {
    Route::get('admin', static fn() => view('pages.auth.login'))->name('login');
    Route::post('admin', 'login')->name('login.post');

    Route::get('admin/setup-password', static fn() => view('pages.auth.setup-password'))->name('setup-password');
    Route::post('admin/setup-password', 'setupPassword')->name('setup-password.post');

    Route::get('verif-email', fn() => view('pages.auth.email-verification'))->name('verifikasi-email');
    Route::post('verif-email','sendForgotPasswordEmail')->name('verifikasi-email.post');
});

/**
 * Auth Routes(Terproteksi)
 * - active.session
 * @see \App\Http\Middleware\ActiveSessionMiddleware
 *
 */
Route::middleware('otp.session')->group(function () {
    Route::controller(AuthWebController::class)->group(function() {
        Route::get('verifikasi-otp', 'showOtpVerificationForm')->name('verifikasi-otp');
        Route::post('verifikasi-otp', 'verifyOtp')->name('verifikasi-otp.post');
        Route::post('verifikasi-otp/resend', 'resendOtp')->name('verifikasi-otp.resend');
        Route::get('perbaru-sandi', 'showResetPasswordForm')->name('reset-password');
        Route::post('perbaru-sandi', 'performPasswordReset')->name('reset-password.post');
    });
});

/**
 * Route Panel Admin(Terproteksi)
 * - active.session
 * @see \App\Http\Middleware\ActiveSessionMiddleware
 *
 */
Route::middleware(['active.session', 'panel.admin.permission'])->group(function() {
    Route::get('admin/dashboard', fn() => view('pages.dashboard'))->name('dashboard.admin');

    Route::resource('admin/bibit', BibitBerkualitasController::class);
    Route::resource('admin/desa', DesaController::class);
    Route::resource('admin/kecamatan', KecamatanController::class);
    Route::resource('admin/kelompok-tani', KelompokTaniController::class);
    Route::resource('admin/komoditas', KomoditasController::class);
    Route::resource('admin/penyuluh-terdaftar', PenyuluhTerdaftarController::class);
    Route::resource('admin/laporan-bibit', LaporanBibitController::class);

    Route::controller(AdminController::class)->group(function() {
        Route::get('admin/admin-users', 'index')->name('admin.index');
        Route::get('admin/admin-users/create', 'create')->name('admin.create');
        Route::post('admin/admin-users', 'store')->name('admin.store');
        Route::get('admin/admin-users/{id}/edit', 'edit')->name('admin.edit');
        Route::put('admin/admin-users/{id}', 'update')->name('admin.update');
        Route::delete('admin/admin-users/{id}', 'destroy')->name('admin.destroy');
        Route::get('admin/profil', 'profile')->name('admin.profile');
    });

    Route::controller(RoleController::class)->group(function() {
        Route::get('admin/roles', 'index')->name('admin.roles.index');
        Route::get('admin/roles/create', 'create')->name('admin.roles.create');
        Route::post('admin/roles', 'store')->name('admin.roles.store');
        Route::delete('admin/roles/{id}', 'destroy')->name('admin.roles.destroy');
        Route::get('admin/roles/{id}/edit', 'edit')->name('admin.roles.edit');
        Route::put('admin/roles/{id}', 'update')->name('admin.roles.update');
    });

    Route::get('kecamatan/{id}/desa', [DesaController::class, 'getByKecamatanId']);
    Route::get('kecamatan/{id}/penyuluh', [PenyuluhTerdaftarController::class, 'getByKecamatanId']);
    Route::post('admin/logout',[AuthWebController::class, 'logout'])->name('admin.logout');
});

// Untuk sementara nggk aku proteksi
Route::get('test-component', fn() => view('test-components'));
