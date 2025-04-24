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
use Illuminate\Database\QueryException;

class RoleRepository implements CrudInterface, RoleRepositoryInterface
{
    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = Role::query();
            if ($withRelations) {
                $query->with('permissions');
            }
            return $query->get();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil semua data role', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
            ]);
            return Collection::make();
        } catch (Throwable $e) {
            Log::error('Gagal mengambil semua data role', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
            ]);
            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return Role::with('permissions')->findOrFail($id);
        } catch (QueryException $e) {
            Log::error('Gagal mengambil data role berdasarkan id', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
                'data'   => ['id' => $id],
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal mengambil data role berdasarkan id', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
                'data'   => ['id' => $id],
            ]);
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
            Log::error('Gagal menyimpan role baru', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
                'data'   => $data,
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal menyimpan role baru', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
                'data'   => $data,
            ]);
            return null;
        }
    }

    public function update(string|int $id, array $data): bool
    {
        try {
            $role = Role::findOrFail($id);
            $role->update([
                'name'       => $data['name'] ?? $role->name,
                'guard_name' => $data['guard_name'] ?? $role->guard_name,
            ]);
            return true;
        } catch (QueryException $e) {
            Log::error('Gagal memperbarui data role', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
                'data'   => [
                    'id'   => $id,
                    'data' => $data,
                ],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui data role', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
                'data'   => [
                    'id'   => $id,
                    'data' => $data,
                ],
            ]);
            return false;
        }
    }

    public function delete(string|int $id): bool
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return true;
        } catch (QueryException $e) {
            Log::error('Gagal menghapus data role', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
                'data'   => ['id' => $id],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal menghapus data role', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
                'data'   => ['id' => $id],
            ]);
            return false;
        }
    }

    public function syncPermissions(int $roleId, array $permissionIds): void
    {
        try {
            $role = $this->getById($roleId);
            if (!$role) {
                Log::warning(__METHOD__ . ' - Role tidak ditemukan', ['role_id' => $roleId]);
                return;
            }

            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

            if (count($permissionNames) !== count($permissionIds)) {
                $notFound = array_diff($permissionIds, Permission::whereIn('id', $permissionIds)->pluck('id')->toArray());
                Log::warning(__METHOD__ . ' - Beberapa izin tidak ditemukan', [
                    'role_id' => $roleId,
                    'not_found_permission_ids' => $notFound,
                ]);
            }

            $role->syncPermissions($permissionNames);
        } catch (QueryException $e) {
            Log::error('Gagal sync permissions pada role', [
                'source'         => __METHOD__,
                'error'          => $e->getMessage(),
                'sql'            => $e->getSQL(),
                'data'           => [
                    'role_id'      => $roleId,
                    'permission_ids' => $permissionIds,
                ],
            ]);
            throw $e;
        } catch (Throwable $e) {
            Log::error('Gagal sync permissions pada role', [
                'source'         => __METHOD__,
                'error'          => $e->getMessage(),
                'trace'          => $e->getTraceAsString(),
                'data'           => [
                    'role_id'      => $roleId,
                    'permission_ids' => $permissionIds,
                ],
            ]);
            throw $e;
        }
    }
}

