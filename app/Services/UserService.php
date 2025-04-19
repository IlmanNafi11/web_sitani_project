<?php

namespace App\Services;

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

    public function findUser(array $conditions)
    {
        $user = null;
        try {
            $user = $this->repository->findUser($conditions);
        } catch (Exception $th) {
            Log::error('Gagal mengambil data user: ' . $th->getMessage());
        }

        return $user;
    }

    public function resetPassword(User $user, string $password)
    {
        try {
            return $this->repository->resetPassword($user, bcrypt($password));
        } catch (Exception $th) {
            Log::error('Gagal mengubah password user: ' . $th->getMessage());
        }

        return false;
    }

    public function sendOtpToEmail(User $user): bool
    {
        try {
            $code = $this->repository->generateAndSaveOtp($user);

            Mail::to($user->email)->send(new \App\Mail\SendOtpCode($code));
            return true;
        } catch (Exception $e) {
            Log::error('OTP Email Send Failed', ['user_id' => $user->id, 'error' => $e->getMessage()]);
        }

        return false;
    }

    public function verifyOtp(User $user, array $data): bool
    {
        try {
            $otp = implode('', $data['otp']);
            return $this->repository->validateOtp($user, $otp);
        } catch (Exception $e) {
            Log::error('Gagal mengverifikasi OTP: ' . $e->getMessage());
        }

        return false;
    }

    public function invalidateOtps(User $user): void
    {
        try {
            $this->repository->invalidateOtps($user);
        } catch (Exception $e) {
            Log::error('Gagal menghapus OTP: ' . $e->getMessage());
        }
    }
}
