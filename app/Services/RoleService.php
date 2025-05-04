<?php

namespace App\Services;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Throwable;

class RoleService implements RoleServiceInterface
{
    use LoggingError;

    protected CrudInterface $repository;
    protected RoleRepositoryInterface $roleRepository;

    public function __construct(CrudInterface $repository, RoleRepositoryInterface $roleRepository)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @throws DataAccessException
     */
    public function getAll($withRelations = false): Collection
    {
        try {
            return $this->repository->getAll($withRelations);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while fetching roles.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while fetching roles.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function getById(int|string $id): Model
    {
        try {
            $role = $this->repository->getById($id);

            if ($role === null) {
                throw new ResourceNotFoundException("Role with ID {$id} not found.");
            }

            if ($role instanceof Collection) {
                $role = $role->first();
                if ($role === null) {
                    throw new ResourceNotFoundException("Role with ID {$id} not found or incorrect type returned.");
                }
            }


            return $role;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error while fetching role with ID {$id}.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Unexpected error while fetching role with ID {$id}.", 0, $e);
        }
    }

    /**
     * @throws ResourceNotFoundException
     * @throws DataAccessException
     */
    public function createWithPermissions(array $roleData, array $permissionIds = []): Model
    {
        try {
            return DB::transaction(function () use ($roleData, $permissionIds) {
                $role = $this->repository->create($roleData);

                if ($role === null) {
                    throw new DataAccessException('Failed to create role data in repository.');
                }

                $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

                $this->roleRepository->syncPermissions($role->id, $permissionNames);

                $role->load('permissions');


                return $role;
            });
        } catch (QueryException $e) {
            throw new DataAccessException('Database error during role creation transaction.', 0, $e);
        } catch (DataAccessException|ResourceNotFoundException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error during role creation transaction.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function updateRoleAndPermissions(int $id, array $roleData, array $permissionIds): Model
    {
        try {
            return DB::transaction(function () use ($id, $roleData, $permissionIds) {
                $updated = $this->repository->update($id, $roleData);

                if (!$updated) {
                    throw new DataAccessException("Failed to update role data in repository for ID {$id}.");
                }

                $role = $this->repository->getById($id);

                if ($role === null) {
                    throw new ResourceNotFoundException("Role with ID {$id} not found after update.");
                }

                $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

                $this->roleRepository->syncPermissions($role->id, $permissionNames);

                $role->load('permissions');

                return $role;
            });
        } catch (QueryException $e) {
            throw new DataAccessException('Database error during role update transaction.', 0, $e);
        } catch (DataAccessException|ResourceNotFoundException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error during role update transaction.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function delete(int $id): bool
    {
        try {
            $deleted = $this->repository->delete($id);

            if (!$deleted) {
                throw new ResourceNotFoundException("Role with ID {$id} not found for deletion.");
            }

            return true;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while deleting role.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while deleting role.', 0, $e);
        }
    }
}
