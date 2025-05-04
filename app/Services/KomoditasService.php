<?php

namespace App\Services;

use App\Exceptions\DataAccessException;
use App\Exceptions\ImportFailedException;
use App\Exceptions\ResourceNotFoundException;
use App\Exports\KomoditasExport;
use App\Imports\KomoditasImport;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Services\Interfaces\KomoditasServiceInterface;
use App\Trait\LoggingError;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class KomoditasService implements KomoditasServiceInterface
{
    use LoggingError;

    protected CrudInterface $crudRepository;
    protected KomoditasRepositoryInterface $repository;

    public function __construct(CrudInterface $crudRepository, KomoditasRepositoryInterface $repository)
    {
        $this->crudRepository = $crudRepository;
        $this->repository = $repository;
    }

    public function getAll(bool $withRelations = false): Collection
    {
        try {
            return $this->crudRepository->getAll($withRelations);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat fetch data komoditas.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat fetch data komoditas.', 0, $e);
        }
    }

    public function getById(string|int $id): Model
    {
        try {
            $komoditas = $this->crudRepository->getById($id);

            if (empty($komoditas)) {
                throw new ResourceNotFoundException("Komoditas dengan id {$id} tidak ditemukan.");
            }

            // Noted, rencana dihapus
//            if ($komoditas instanceof Collection) {
//                $komoditas = $komoditas->first();
//                if (empty($komoditas)) {
//                    throw new ResourceNotFoundException("Komoditas with ID {$id} not found or incorrect type returned.");
//                }
//            }

            return $komoditas;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat fetch data komoditas dengan id {$id} .", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat fetch data komoditas dengan id {$id} .", 0, $e);
        }
    }

    public function create(array $data): Model
    {
        try {
            $komoditas = $this->crudRepository->create($data);

            if ($komoditas === null) {
                throw new DataAccessException('Gagal menyimpan data komoditas di repository.');
            }

            return $komoditas;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat menyimpan data komoditas.', 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat menyimpan data komoditas.', 0, $e);
        }
    }

    public function update(string|int $id, array $data): bool
    {
        try {
            $result = $this->crudRepository->update($id, $data);

            if(!$result) {
                throw new DataAccessException("Gagal memperbarui komoditas dengan id {$id} direpository.");
            }

            return (bool) $result;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat memperbarui komoditas dengan id {$id}.", 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat memperbarui data komoditas dengan id {$id}.", 0, $e);
        }
    }

    public function delete(string|int $id): bool
    {
        try {
            $result = $this->crudRepository->delete($id);

            if (!$result) {
                throw new DataAccessException("Gagal menghapus data komoditas dengan id {$id} di repository.");
            }

            return (bool) $result;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat menghapus data komoditas dengan id {$id}.", 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat menghapus data komoditas dengan id {$id}.", 0, $e);
        }
    }

    public function calculateTotal(): int
    {
        try {
            return $this->repository->calculateTotal();
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat menghitung total komoditas.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat menghitung total komoditas.', 0, $e);
        }
    }

    public function import(mixed $file): array
    {
        try {
            $import = new KomoditasImport();
            Excel::import($import, $file);

            return $import->getFailures();
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            throw new ImportFailedException("Validasi data saat import Gagal.", 0, $e, collect($failures));
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat import data.", 0, $e);
        } catch (Throwable $e) {
            throw new ImportFailedException("Terjadi kesalahan tak terduga saat import data.", 0, $e);
        }
    }

    public function export(): FromCollection
    {
        try {
            return new KomoditasExport();
        } catch (Throwable $e) {
            throw new DataAccessException("Gagal export data.", 0, $e);
        }
    }
}
