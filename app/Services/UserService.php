<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\AuthInterface;

class UserService
{
    protected AuthInterface $repository;

    public function __construct(AuthInterface $repository)
    {
        $this->repository = $repository;
    }

    public function setupassword(User $user, string $password)
    {
        return $this->repository->resetPassword($user, bcrypt($password));
    }

}
