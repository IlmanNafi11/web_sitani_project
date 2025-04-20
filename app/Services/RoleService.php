<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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

    public function update(array $data, int $id): bool
    {
        try {
            return $this->repository->update($id, $data);
        } catch (Throwable $e) {
            Log::error('RoleService::update error', ['id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        try {
            return $this->repository->delete($id);
        } catch (Throwable $e) {
            Log::error('RoleService::delete error', ['id' => $id, 'error' => $e->getMessage()]);
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
