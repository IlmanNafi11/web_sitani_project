<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpCodeRequest;
use App\Http\Requests\PasswordRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthWebController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Authentikasi login admin panel.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = $this->service->findUser(['email' => $validated['email']]);

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }

        if (!in_array($user->role, ['admin', 'super_admin'])) {
            return back()->with('failed', 'Akses ditolak! Akun anda tidak memiliki izin login ke admin panel.');
        }

        if (!Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return back()->withErrors(['password' => 'Password yang anda masukkan salah.'])->withInput();
        }

        if (!$user->is_password_set) {
            $request->session()->regenerate();
            return redirect()->route('setup-password');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard.admin');
    }

    /**
     * Form untuk setup password.
     *
     * @param PasswordRequest $request
     * @return RedirectResponse
     */
    public function setupPassword(PasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $result = $this->service->resetPassword(Auth::user(), $validated['password']);

        if (!$result) {
            return back()->with('failed', 'Gagal memperbarui password.')->withInput();
        }

        return redirect()->route('dashboard.admin')->with('Selamat Datang di Web Admin Panel SiTani');
    }

    /**
     * Form untuk verifikasi email sebelum reset password.
     *
     * @param EmailRequest $request
     * @return RedirectResponse
     */
    public function sendForgotPasswordEmail(EmailRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = $this->service->findUser(['email' => $validated['email']]);

        if (!$user || !in_array($user->role, ['admin', 'super_admin'])) {
            return back()->withErrors(['email' => 'Email tidak terdaftar atau tidak punya akses.'])->withInput();
        }

        if (!$this->service->sendOtpToEmail($user)) {
            return back()->with('failed', 'Gagal mengirim OTP ke email. Silakan coba lagi.');
        }

        session(['otp_user_id' => $user->id]);
        return redirect()->route('verifikasi-otp')->with('success', 'Kode OTP berhasil dikirim ke email anda.');
    }

    /**
     * Form untuk verifikasi OTP.
     *
     * @return View
     */
    public function showOtpVerificationForm(): View
    {
        return view('pages.auth.otp-verification');
    }

    /**
     * Form untuk reset password.
     *
     * @return View
     */
    public function showResetPasswordForm(): View
    {
        return view('pages.auth.reset-password');
    }

    /**
     * Verifikasi OTP.
     *
     * @param OtpCodeRequest $request
     * @return RedirectResponse
     */
    public function verifyOtp(OtpCodeRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $this->service->findUser(['id' => session('otp_user_id')]);

        if (!$user) {
            return redirect()->route('verifikasi-email')->with('failed', 'Kesalahan sesi. Silakan mulai ulang proses.');
        }

        if (!$this->service->verifyOtp($user, $validated)) {
            Log::warning('Invalid OTP attempt', ['user_id' => $user->id]);
            return back()->withErrors(['otp' => 'Kode OTP salah atau telah kadaluarsa.'])->withInput();
        }

        return redirect()->route('reset-password');
    }

    /**
     * Resend OTP ke email.
     *
     * @return RedirectResponse
     */
    public function resendOtp(): RedirectResponse
    {
        $user = $this->service->findUser(['id' => session('otp_user_id')]);

        if (!$user) {
            return redirect()->route('verifikasi-email')->with('failed', 'Kesalahan sesi. Silakan mulai ulang proses.');
        }
        if (!$this->service->sendOtpToEmail($user)) {
            return back()->with('failed', 'Gagal mengirim ulang OTP.');
        }
        return back()->with('success', 'Kode OTP baru berhasil dikirim!');
    }

    /**
     * Reset password.
     *
     * @param PasswordRequest $request
     * @return RedirectResponse
     */
    public function performPasswordReset(PasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = $this->service->findUser(['id' => session('otp_user_id')]);

        if (!$user) {
            return redirect()->route('verifikasi-email')->withErrors('Sesi tidak valid.');
        }

        $this->service->invalidateOtps($user);
        if (!$this->service->resetPassword($user, $validated['password'])) {
            Log::error('Password update failed on reset', ['user_id' => $user->id]);
            return back()->with('failed', 'Gagal memperbarui password.')->withInput();
        }

        session()->forget('otp_user_id');
        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login.');
    }

    /**
     * Logout.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
