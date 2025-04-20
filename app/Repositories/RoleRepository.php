<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Throwable;

class RoleRepository implements CrudInterface, RoleRepositoryInterface
{
    public function getAll($withRelations = false): Collection|array
    {
        return $withRelations
            ? Role::with('permissions')->get()
            : Role::all();
    }

    public function find($id): Model|Collection|array|null
    {
        return Role::with('permissions')->find($id);
    }

    public function create(array $data): Role
    {
        try {
            return Role::create([
                'name' => $data['name'],
                'guard_name' => $data['guard_name'] ?? 'web'
            ]);
        } catch (Throwable $e) {
            Log::error('RoleRepository@create failed', ['error' => $e->getMessage(), 'data' => $data]);
            throw $e;
        }
    }

    public function update(int|string $id, array $data): bool
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                Log::warning('RoleRepository@update - Role not found', ['id' => $id]);
                return false;
            }
            $role->update([
                'name'       => $data['name'] ?? $role->name,
                'guard_name' => $data['guard_name'] ?? $role->guard_name,
            ]);
            return true;
        } catch (Throwable $e) {
            Log::error('RoleRepository@update failed', ['id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function delete(int|string $id): bool
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                Log::warning('RoleRepository@delete - Role not found', ['id' => $id]);
                return false;
            }

            return (bool) $role->delete();
        } catch (Throwable $e) {
            Log::error('RoleRepository@delete failed', ['id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function syncPermissions(int $roleId, array $permissionIds): void
    {
        try {
            $role = $this->find($roleId);
            if (!$role) {
                Log::warning('RoleRepository@syncPermissions - Role not found', ['role_id' => $roleId]);
                return;
            }

            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

            if (count($permissionNames) !== count($permissionIds)) {
                $notFound = array_diff($permissionIds, Permission::whereIn('id', $permissionIds)->pluck('id')->toArray());
                Log::warning('RoleRepository@syncPermissions - Some permissions not found', [
                    'role_id' => $roleId,
                    'not_found_permission_ids' => $notFound,
                ]);
            }

            $role->syncPermissions($permissionNames);
        } catch (Throwable $e) {
            Log::error('RoleRepository@syncPermissions failed', [
                'role_id' => $roleId,
                'permission_ids' => $permissionIds,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
