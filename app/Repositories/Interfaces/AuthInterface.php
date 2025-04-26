<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface AuthInterface
{
    public function findUser(array $conditions, bool $multiple = false, array $withRelations = []): ?User;
    public function resetPassword(User $user, string $password): bool;
    public function generateAndSaveOtp(User $user): string;
    public function validateOtp(User $user, string $code): bool;
    public function invalidateOtps(User $user): void;
}
