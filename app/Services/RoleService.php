<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Throwable;

class RoleService
{
    protected CrudInterface $repository;
    protected RoleRepositoryInterface $roleRepository;

    public function __construct(CrudInterface $repository, RoleRepositoryInterface $roleRepository)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
    }

    public function getAll(): Collection|array
    {
        return $this->repository->getAll(true);
    }

    public function getById(int|string $id): ?Role
    {
        return $this->repository->find($id);
    }

    public function create(array $data): ?Model
    {
        try {
            return $this->repository->create($data);
        } catch (Throwable $e) {
            Log::error('RoleService::create error', ['error' => $e->getMessage(), 'data' => $data]);
            throw $e;
        }
    }

    public function updateRoleAndPermissions(int $id, array $roleData, array $permissionIds): void
    {
        try {
            $updated = $this->repository->update($id, $roleData);
            if (!$updated) {
                throw new \Exception('Role not found or failed to update.');
            }

            $this->roleRepository->syncPermissions($id, $permissionIds);
        } catch (\Throwable $e) {
            Log::error('RoleService::updateRoleAndPermissions error', [
                'role_id' => $id,
                'role_data' => $roleData,
                'permission_ids' => $permissionIds,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        DB::beginTransaction();
        try {
            $deleted = $this->repository->delete($id);
            if (!$deleted) {
                DB::rollBack();
                Log::warning('RoleService@delete - Role not found', ['role_id' => $id]);
                return false;
            }
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('RoleService@delete failed', [
                'role_id' => $id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function syncPermissions(int $roleId, array $permissionIds): void
    {
        try {
            $this->roleRepository->syncPermissions($roleId, $permissionIds);
        } catch (Throwable $e) {
            Log::error('RoleService::syncPermissions error', ['role_id' => $roleId, 'permission_ids' => $permissionIds, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getAllRole()
    {
        try {
            return $this->repository->getAll(false);
        } catch (Throwable $e) {
            Log::error('RoleService::getAllRole error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
