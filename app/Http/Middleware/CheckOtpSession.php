<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOtpSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('otp_user_id')) {
            return redirect()->route('verifikasi-email')->with('failed', 'Kesalahan sesi. Silakan mulai ulang proses.');
        }
        return $next($request);
    }
}
