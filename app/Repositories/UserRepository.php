<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\AuthInterface;

class UserRepository implements AuthInterface
{
    public function resetPassword(User $user, string $password): bool
    {
        $user->password = $password;
        $user->is_password_set = true;
        return $user->save();
    }
}
