<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface AuthInterface
{
    public function resetPassword(User $user, string $password): bool;
}
