<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Throwable;
use Illuminate\Database\QueryException;

class RoleRepository implements CrudInterface, RoleRepositoryInterface
{
    use LoggingError;

    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = Role::query();
            if ($withRelations) {
                $query->with('permissions');
            }
            return $query->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            return Collection::make();
        } catch (Throwable $e) {
            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return Role::with('permissions')->findOrFail($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return null;
        } catch (Throwable $e) {
            return null;
        }
    }

    public function create(array $data): ?Role
    {
        try {
            return Role::create([
                'name'       => $data['name'],
                'guard_name' => $data['guard_name'] ?? 'web',
            ]);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            return null;
        } catch (Throwable $e) {
            return null;
        }
    }

    public function update(string|int $id, array $data): bool
    {
        try {
            $role = Role::findOrFail($id);
            return $role->update([
                'name'       => $data['name'] ?? $role->name,
                'guard_name' => $data['guard_name'] ?? $role->guard_name,
            ]);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['data_baru' => $data]);
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function delete(string|int $id): bool
    {
        try {
            $role = Role::findOrFail($id);
            return (bool) $role->delete();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * @throws Throwable
     */
    public function syncPermissions(int $roleId, array $permissionIds): void
    {
        try {
            $role = $this->getById($roleId);
            if (!$role) {
                $this->LogNotFoundException(null, ['role_id' => $roleId]);
                return;
            }

            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

            if (count($permissionNames) !== count($permissionIds)) {
                $notFound = array_diff($permissionIds, Permission::whereIn('id', $permissionIds)->pluck('id')->toArray());
                $this->LogNotFoundException(null, [
                    'role_id' => $roleId,
                    'not_found_permission_ids' => $notFound,
                ]);
            }

            $role->syncPermissions($permissionNames);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['role_id' => $roleId]);
            throw $e;
        } catch (Throwable $e) {
            throw $e;
        }
    }
}

