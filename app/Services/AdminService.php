<?php

namespace App\Services;

use App\Exceptions\DataAccessException;
use App\Exceptions\ImportFailedException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Interfaces\CrudInterface;
use App\Services\Interfaces\AdminServiceInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Imports\AdminImport;
use App\Exports\AdminExport;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class AdminService implements AdminServiceInterface
{
    protected CrudInterface $repository;

    public function __construct(CrudInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Mengambil seluruh data admin
     *
     * @return Collection
     * @throws DataAccessException
     */
    public function getAll(): Collection
    {
        try {
            return $this->repository->getAll(true);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while fetching admin data.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while fetching admin data.', 0, $e);
        }
    }

    /**
     * Mengambil data admin berdasarkan id
     *
     * @param string|int $id Id admin
     * @return Model
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function getById(string|int $id): Model
    {
        try {
            $admin = $this->repository->getById($id);

            if ($admin === null) {
                throw new ResourceNotFoundException("Admin with ID {$id} not found.");
            }

            if ($admin instanceof Collection) {
                $admin = $admin->first();
                if ($admin === null) {
                    throw new ResourceNotFoundException("Admin with ID {$id} not found or incorrect type returned.");
                }
            }

            return $admin;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error while fetching admin with ID {$id}.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Unexpected error while fetching admin with ID {$id}.", 0, $e);
        }
    }


    /**
     * Membuat data admin baru
     *
     * @param array $data Data baru
     * @return Model
     * @throws DataAccessException
     */
    public function create(array $data): Model
    {
        try {
            $dt = [
                'email' => $data['email'],
                'nama' => $data['nama'],
                'no_hp' => $data['no_hp'],
                'alamat' => $data['alamat'],
                'password' => 'sitani',
                'role' => $data['role'],
                'is_password_set' => false,
            ];

            $admin = $this->repository->create($dt);

            if ($admin === null) {
                throw new DataAccessException('Failed to create admin data in repository.');
            }

            return $admin;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while creating admin data.', 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while creating admin data.', 0, $e);
        }
    }

    /**
     * Memperbarui data admin berdasarkan id
     *
     * @param string|int $id Id admin
     * @param array $data Data baru
     * @return bool
     * @throws DataAccessException
     */
    public function update(string|int $id, array $data): bool
    {
        try {
            $updated = $this->repository->update($id, $data);

            if (!$updated) {
                throw new DataAccessException("Failed to update admin with ID {$id}.");
            }

            return true;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error while updating admin with ID {$id}.", 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Unexpected error while updating admin with ID {$id}.", 0, $e);
        }
    }

    /**
     * Menghapus data admin berdasarkan id
     *
     * @param string|int $id Id admin
     * @return bool
     * @throws DataAccessException
     */
    public function delete(string|int $id): bool
    {
        try {
            $deleted = $this->repository->delete($id);

            if (!$deleted) {
                throw new DataAccessException("Failed to delete admin with ID {$id}.");
            }

            return true;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error while deleting admin with ID {$id}.", 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Unexpected error while deleting admin with ID {$id}.", 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ImportFailedException
     */
    public function import(mixed $file): array
    {
        try {
            $import = new AdminImport(); // Use AdminImport
            Excel::import($import, $file);

            return $import->getFailures();
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            throw new ImportFailedException("Data import validation failed.", 0, $e, collect($failures));
        } catch (QueryException $e) {
            throw new DataAccessException("Database error during admin import.", 0, $e);
        } catch (Throwable $e) {
            throw new ImportFailedException("Unexpected error during admin import.", 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function export(): FromCollection
    {
        try {
            return new AdminExport();
        } catch (Throwable $e) {
            throw new DataAccessException("Failed to prepare admin data for export.", 0, $e);
        }
    }
}
