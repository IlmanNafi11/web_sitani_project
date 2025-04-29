<?php

namespace App\Services;

use App\Events\OtpGenerated;
use App\Models\User;
use App\Repositories\Interfaces\AuthInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserService
{
    protected AuthInterface $repository;

    public function __construct(AuthInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Mencari data pengguna berdasarkan conditions dan relations
     *
     * @param array $conditions Kondisi untuk memfilter pencarian
     * @param array $relations Relasi, set null jika tidak ingin mengambil beserta relasi
     * @return array
     */
    public function findUser(array $conditions, array $relations = []): array
    {
        try {
            $user = $this->repository->findUser($conditions, false, $relations);
            if ($user !== null) {
                return [
                    'success' => true,
                    'message' => 'Data pengguna ditemukan',
                    'data' => $user,
                    'code' => 200,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data pengguna tidak ditemukan',
                'data' => [],
                'code' => 404,
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mencari data pengguna', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencari data pengguna.',
                'data' => [],
                'code' => 500,
            ];
        }
    }

    /**
     * Reset kata sandi pengguna
     *
     * @param User $user Model user yang akan diperbarui
     * @param string $password Password baru
     * @return array
     */
    public function resetPassword(User $user, string $password): array
    {
        try {
            $result = $this->repository->resetPassword($user, bcrypt($password));
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Kata sandi berhasil diperbarui',
                    'code' => 200,
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal memperbarui kata sandi pengguna',
                'data' => [],
                'code' => 500,
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat memperbarui kata sandi pengguna', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kata sandi pengguna',
                'data' => [],
                'code' => 500,
            ];
        }
    }

    /**
     * Mengirim kode otp ke email
     *
     * @param User $user Model user yang akan dikirim otp
     * @return array
     */
    public function sendOtpToEmail(User $user): array
    {
        try {
            $code = $this->repository->generateAndSaveOtp($user);
            event(new OtpGenerated($user, $code));
            return [
                'success' => true,
                'message' => 'Kode OTP berhasil dikirim',
                'data' => [],
                'code' => 200,
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat generate dan kirim kode OTP', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim kode OTP',
                'data' => [],
                'code' => 500,
            ];
        }
    }

    /**
     * Memverifikasi kode OTP
     *
     * @param User $user Model user yang akan divalidasi OTPnya
     * @param array $data Kode OTP
     * @return array
     */
    public function verifyOtp(User $user, array $data): array
    {
        try {
            $otp = implode('', $data['otp']);
            $result = $this->repository->validateOtp($user, $otp);
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Kode OTP terverifikasi',
                    'data' => ['OTP' => $otp],
                    'code' => 200,
                ];
            }

            return [
                'success' => false,
                'message' => 'Kode OTP salah atau kadaluarsa',
                'data' => [],
                'code' => 401,
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat memvalidasi kode OTP', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memvalidasi kode OTP',
                'data' => [],
                'code' => 500,
            ];
        }
    }

    /**
     * Menghapus kode OTP
     *
     * @param User $user Model user yang akan dihapus kode OTPnya
     * @return void
     */
    public function invalidateOtps(User $user): void
    {
        try {
            $this->repository->invalidateOtps($user);
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menghapus kode OTP', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
