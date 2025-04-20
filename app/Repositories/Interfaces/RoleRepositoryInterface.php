<?php

namespace App\Repositories\Interfaces;

use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    /**
     * Menyinkronkan permission dengan role
     *
     * @param int $roleId
     * @param array $permissionIds
     * @return void
     */
    public function syncPermissions(int $roleId, array $permissionIds): void;
}
