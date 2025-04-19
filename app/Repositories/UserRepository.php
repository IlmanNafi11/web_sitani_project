<?php

namespace App\Repositories;

use App\Models\OtpCode;
use App\Models\User;
use App\Repositories\Interfaces\AuthInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserRepository implements AuthInterface
{
    public function findUser(array $conditions, bool $multiple = false): ?User
    {
        $query = User::query();

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }
        
        return $query->first();
    }

    public function resetPassword(User $user, string $password): bool
    {
        $user->password = $password;
        $user->is_password_set = true;
        $result = $user->save();

        if (!$result) {
            Log::error('Failed to reset password', ['user_id' => $user->id]);
        }
        return $result;
    }

    public function generateAndSaveOtp(User $user): string
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->invalidateOtps($user);

        OtpCode::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        return $code;
    }

    public function validateOtp(User $user, string $code): bool
    {
        $otp = OtpCode::where('user_id', $user->id)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        return $otp !== null;
    }

    public function invalidateOtps(User $user): void
    {
        OtpCode::where('user_id', $user->id)->delete();
    }

}
