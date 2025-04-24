<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PenyuluhRequest;
use App\Http\Requests\PhonePenyuluhRequest;
use App\Services\PenyuluhService;
use App\Services\PenyuluhTerdaftarService;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthApiController extends Controller
{
    use ApiResponse;
    protected PenyuluhService $service;
    protected PenyuluhTerdaftarService $penyuluhTerdaftarService;

    public function __construct(PenyuluhService $service, PenyuluhTerdaftarService $penyuluhTerdaftarService)
    {
        $this->service = $service;
        $this->penyuluhTerdaftarService = $penyuluhTerdaftarService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Email atau password salah', 401);
        }

        $user = Auth::user();

        if (!$user->hasRole('penyuluh')) {
            return $this->errorResponse('Akun ini tidak memiliki izin untuk login sebagai penyuluh.', 403);
        }

        return $this->respondWithToken($token, "Login Berhasil");
    }

    public function validatePhone(PhonePenyuluhRequest $request)
    {
        $result = $this->penyuluhTerdaftarService->getByPhone($request->validated('no_hp'));
        if ($result['success']) {
            return $this->successResponse($result['data'], $result['message']);
        }

        return $this->errorResponse($result['message'], $result['data']);
    }

    public function register(PenyuluhRequest $request)
    {
        $result = $this->service->create($request->validated());

        if ($result['success']) {
            return $this->successResponse($result['data'], $result['message']);
        }

        return $this->errorResponse($result['message']);
    }

    /**
     * Mengembalikan response beserta token
     *
     * @param  string $token token JWT
     * @param string $message Pesan response
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token, string $message) : JsonResponse
    {
        $user = Auth::user()->load('penyuluh:id,user_id,penyuluh_terdaftar_id', 'penyuluh.penyuluhTerdaftar:id,nama,no_hp,alamat,kecamatan_id');

        $userData = $user->only(['id', 'email', 'created_at']);
        $userData['penyuluh'] = null;

        if ($user->relationLoaded('penyuluh') && $user->penyuluh) {
            $userData['penyuluh'] = $user->penyuluh->only(['id', 'penyuluh_terdaftar_id', 'user_id']);
            $userData['penyuluh']['penyuluh_terdaftar'] = null;
            if ($user->penyuluh->relationLoaded('penyuluhTerdaftar') && $user->penyuluh->penyuluhTerdaftar) {
                $userData['penyuluh']['penyuluh_terdaftar'] = $user->penyuluh->penyuluhTerdaftar->only(['id', 'nama', 'no_hp', 'alamat', 'kecamatan_id']);
            }
        }
        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTFactory::getTTL() * 60,
            'user' => $userData,
        ], $message);
    }
}
