<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PenyuluhRequest;
use App\Http\Requests\PhonePenyuluhRequest;
use App\Http\Resources\UserLoginResource;
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

    /**
     * Login Penyuluh
     *
     * @param LoginRequest $request Form request
     * @return JsonResponse response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Email atau password salah', 401);
        }

        $user = Auth::user();

        if (!$user->hasRole('penyuluh')) {
            return $this->errorResponse('Akun ini tidak memiliki izin untuk login sebagai penyuluh.', 403, [
                'email' => $credentials['email'],
            ]);
        }

        return $this->respondWithToken($token, "Login Berhasil");
    }

    /**
     * Verifikasi no hp penyuluh saat registrasi
     *
     * @param PhonePenyuluhRequest $request Form request
     * @return JsonResponse response
     */
    public function validatePhone(PhonePenyuluhRequest $request)
    {
        $result = $this->penyuluhTerdaftarService->getByPhone($request->validated('no_hp'));
        if ($result['success']) {
            return $this->successResponse($result['data'], $result['message']);
        }

        return $this->errorResponse($result['message'], $result['data']);
    }

    /**
     * Registrasi akun penyuluh
     *
     * @param PenyuluhRequest $request Form request
     * @return JsonResponse response
     */
    public function register(PenyuluhRequest $request)
    {
        $result = $this->service->create($request->validated());

        if ($result['success']) {
            return $this->successResponse($result['data'], $result['message'], 201);
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
        $user = Auth::user()->load([
            'penyuluh:id,user_id,penyuluh_terdaftar_id',
            'penyuluh.penyuluhTerdaftar:id,nama,no_hp,alamat,kecamatan_id',
            'penyuluh.penyuluhTerdaftar.kecamatan:id,nama',
        ]);

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTFactory::getTTL() * 60,
            'user' => new UserLoginResource($user),
        ], $message);
    }
}
