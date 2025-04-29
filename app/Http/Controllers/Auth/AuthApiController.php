<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpCodeRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\PenyuluhRequest;
use App\Http\Requests\PhonePenyuluhRequest;
use App\Http\Resources\UserLoginResource;
use App\Services\PenyuluhService;
use App\Services\PenyuluhTerdaftarService;
use App\Services\UserService;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthApiController extends Controller
{
    use ApiResponse;
    protected PenyuluhService $service;
    protected PenyuluhTerdaftarService $penyuluhTerdaftarService;
    protected UserService $userService;

    public function __construct(PenyuluhService $service, PenyuluhTerdaftarService $penyuluhTerdaftarService, UserService $userService)
    {
        $this->service = $service;
        $this->penyuluhTerdaftarService = $penyuluhTerdaftarService;
        $this->userService = $userService;
    }

    /**
     * Login Penyuluh
     *
     * @param LoginRequest $request Form request
     * @return JsonResponse response
     */
    public function login(LoginRequest $request): JsonResponse
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
    public function validatePhone(PhonePenyuluhRequest $request): JsonResponse
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
    public function register(PenyuluhRequest $request): JsonResponse
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

    /**
     * Mengirim kode OTP untuk reset password
     *
     * @param EmailRequest $request Form request
     * @return JsonResponse response
     */
    public function sendOtp(EmailRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = $this->userService->findUser(['email' => $validated['email']]);
        $user = null;
        if ($data['success']) {
            $user = $data['data'];
        }

        if (!$user || !$user->hasRole('penyuluh')) {
            return $this->errorResponse("Anda tidak memiliki akses, Gunakan akun penyuluh untuk masuk", 403);
        }

        $result = $this->userService->sendOtpToEmail($user);

        if (!$result['success']) {
            return $this->errorResponse('Gagal mengirim OTP', 401);
        }

        return $this->successResponse([
            'id' => $user->id,
            'email' => $validated['email'],
        ], $result['message']);
    }

    /**
     * Validasi kode OTP
     *
     * @param OtpCodeRequest $request Form request
     * @return JsonResponse
     */
    public function validateOtp(OtpCodeRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $email = $request->input('email');
        $data = $this->userService->findUser(['email' => $email]);

        if (!$data['success']) {
            return $this->errorResponse($data['message'], $data['code']);
        }

        $user = $data['data'];
        $result = $this->userService->verifyOtp($user, $validated);

        if (!$result['success']) {
            return $this->errorResponse($result['message'], 401);
        }

        return $this->successResponse(['email' => $email], $result['message']);
    }

    /**
     * Memperbarui kata sandi
     *
     * @param PasswordRequest $request Form request
     * @return JsonResponse
     */
    public function passwordReset(PasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $email = $request->input('email');
        $data = $this->userService->findUser(['email' => $email]);
        $user = null;

        if ($data['success']) {
            $user = $data['data'];
        }

        if (!$data['success']) {
            return $this->errorResponse($data['message'], 401);
        }

        $this->userService->invalidateOtps($user);
        $result = $this->userService->resetPassword($user, $validated['password']);
        if (!$result['success']) {
            return $this->errorResponse($result['message'], 401);
        }

        return $this->successResponse(['email' => $email], $result['message']);
    }
}
