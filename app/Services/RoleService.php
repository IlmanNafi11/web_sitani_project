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
    protected RoleRepositoryInterface $syncPerm;

    public function __construct(CrudInterface $repository, RoleRepositoryInterface $syncPerm)
    {
        $this->repository = $repository;
        $this->syncPerm = $syncPerm;
    }

    public function getAll($withRelations = false): Collection|array
    {
        try {
            $roles = $this->repository->getAll($withRelations);
            if ($roles->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Data role berhasil diambil',
                    'data' => $roles,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data role gagal diambil',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data role.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data role.',
                'data' => []
            ];
        }
    }

    public function getById(int|string $id): array
    {
        try {
            $role = $this->repository->getById($id);
            if ($role !== null) {
                return [
                    'success' => true,
                    'message' => 'Data role ditemukan',
                    'data' => $role,
                ];
            }
            return [
                'success' => false,
                'message' => 'Data role tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data role.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data role.',
                'data' => []
            ];
        }
    }

    public function createWithPermissions(array $data, array $permissionIds = []): array
    {
        try {
            return DB::transaction(function () use ($data, $permissionIds) {
                $role = $this->repository->create($data);
                if ($role !== null) {
                    $this->syncPerm->syncPermissions($role->id, $permissionIds);
                    return [
                        'success' => true,
                        'message' => 'Data role berhasil ditambahkan',
                        'data' => $role,
                    ];
                }
                return [
                    'success' => false,
                    'message' => 'Data role gagal ditambahkan',
                    'data' => [],
                ];
            });
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menyimpan data role.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
                'permission_ids' => $permissionIds,
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data role.',
                'data' => []
            ];
        }
    }

    public function updateRoleAndPermissions(int $id, array $roleData, array $permissionIds): array
    {
        try {
            return DB::transaction(function () use ($id, $roleData, $permissionIds) {
                $updated = $this->repository->update($id, $roleData);

                if (!$updated) {
                    throw new \Exception('Role gagal diperbarui');
                }
                $this->syncPerm->syncPermissions($id, $permissionIds);
                return [
                    'success' => true,
                    'message' => 'Data role berhasil diperbarui',
                ];
            });
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat memperbarui data role.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Gagal memperbarui data role.',
                'data' => [],
            ];
        }
    }

    public function delete(int $id): array
    {
        try {
            DB::beginTransaction();
            $deleted = $this->repository->delete($id);
            if (!$deleted) {
                DB::rollBack();
                Log::warning(__METHOD__ . ' - Role tidak ditemukan.', ['role_id' => $id]);
                return [
                    'success' => false,
                    'message' => 'Data role tidak ditemukan.',
                ];
            }
            DB::commit();
            return [
                'success' => true,
                'message' => 'Data role berhasil dihapus.',
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Terjadi kesalahan saat menghapus data role.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Gagal menghapus data role.',
            ];
        }
    }
}
