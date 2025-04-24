<?php

namespace App\Repositories;

use App\Models\OtpCode;
use App\Models\User;
use App\Repositories\Interfaces\AuthInterface;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserRepository implements AuthInterface
{
    public function findUser(array $conditions, bool $multiple = false): ?User
    {
        try {
            $query = User::query();

            foreach ($conditions as $field => $value) {
                $query->where($field, $value);
            }

            return $query->first();
        } catch (QueryException $e) {
            Log::error('Gagal mencari data user', [
                'source'     => __METHOD__,
                'error'      => $e->getMessage(),
                'sql'        => $e->getSQL(),
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal mencari data user', [
                'source'     => __METHOD__,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);
            return null;
        }

    }

    public function resetPassword(User $user, string $password): bool
    {
        try {
            $user->password = $password;
            $user->is_password_set = true;
            $result = $user->save();
            if (!$result) {
                Log::error('Password gagal disimpan', ['user_id' => $user->id]);
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error('Gagal memperbarui password', [
                'source'   => __METHOD__,
                'error'    => $e->getMessage(),
                'sql'      => $e->getSQL(),
                'user_id'  => $user->id,
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui password', [
                'source'  => __METHOD__,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'user_id' => $user->id,
            ]);
            return false;
        }
    }

    /**
     * @throws Throwable
     */
    public function generateAndSaveOtp(User $user): string
    {
        try {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $this->invalidateOtps($user);

            OtpCode::create([
                'user_id'    => $user->id,
                'code'       => $code,
                'expires_at' => Carbon::now()->addMinutes(5),
            ]);

            return $code;
        } catch (QueryException $e) {
            Log::error('Gagal generate dan menyimpan kode OTP', [
                'source'   => __METHOD__,
                'error'    => $e->getMessage(),
                'sql'      => $e->getSQL(),
                'user_id'  => $user->id,
            ]);
            throw $e;
        } catch (Throwable $e) {
            Log::error('Gagal generate dan menyimpan kode OTP', [
                'source'  => __METHOD__,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'user_id' => $user->id,
            ]);
            throw $e;
        }
    }

    public function validateOtp(User $user, string $code): bool
    {
        try {
            $otp = OtpCode::where('user_id', $user->id)
                ->where('code', $code)
                ->where('expires_at', '>', now())
                ->latest()
                ->first();

            return $otp !== null;
        } catch (QueryException $e) {
            Log::error('Gagal memvalidasi kode OTP', [
                'source'   => __METHOD__,
                'error'    => $e->getMessage(),
                'sql'      => $e->getSQL(),
                'data' => [
                    'user_id'  => $user->id,
                    'code'     => $code,
                ],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal memvalidasi kode OTP', [
                'source'  => __METHOD__,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'data' => [
                    'user_id'  => $user->id,
                    'code'     => $code,
                ],
            ]);
            return false;
        }
    }

    /**
     * @throws Throwable
     */
    public function invalidateOtps(User $user): void
    {
        try {
            OtpCode::where('user_id', $user->id)->delete();
        } catch (QueryException $e) {
            Log::error('Gagal menghapus kode OTP', [
                'source'  => __METHOD__,
                'error'   => $e->getMessage(),
                'sql'     => $e->getSQL(),
                'user_id' => $user->id,
            ]);
            throw $e;
        } catch (Throwable $e) {
            Log::error('Gagal menghapus kode OTP', [
                'source'  => __METHOD__,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'user_id' => $user->id,
            ]);
            throw $e;
        }
    }

}
