<?php

namespace App\Services;

use App\Exceptions\DataAccessException;
use App\Exceptions\ImportFailedException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\DesaRepositoryInterface;
use App\Services\Interfaces\DesaServiceInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DesaImport;
use App\Exports\DesaExport;
use Throwable;

class DesaService implements DesaServiceInterface
{
    use LoggingError;

    protected CrudInterface $crudRepository;
    protected DesaRepositoryInterface $repository;

    public function __construct(CrudInterface $crudRepository, DesaRepositoryInterface $repository)
    {
        $this->crudRepository = $crudRepository;
        $this->repository = $repository;
    }

    public function getAll(bool $withRelations = false): Collection
    {
        try {
            return $this->crudRepository->getAll($withRelations);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat fetch data desa.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat fetch data desa', 0, $e);
        }
    }

    public function getById(string|int $id): Model
    {
        try {
            $desa = $this->crudRepository->getById($id);

            if (empty($desa)) {
                throw new ResourceNotFoundException("Desa dengan id {$id} tidak ditemukan.");
            }

//            if ($desa instanceof Collection) {
//                $desa = $desa->first();
//                if (empty($desa)) {
//                    throw new ResourceNotFoundException("Desa with ID {$id} not found or incorrect type returned.");
//                }
//            }

            return $desa;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat fetch data desa dengan id {$id}.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat fetch data desa dengan id {$id}.", 0, $e);
        }
    }

    public function create(array $data): Model
    {
        try {
            $desa = $this->crudRepository->create($data);

            if ($desa === null) {
                throw new DataAccessException('Gagal menyimpan data desa di repository.');
            }

            return $desa;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat menyimpan data desa.', 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat menyimpan data desa.', 0, $e);
        }
    }

    public function update(string|int $id, array $data): bool
    {
        try {
            $result = $this->crudRepository->update($id, $data);

            if(!$result) {
                throw new DataAccessException("Gagal memperbarui data desa dengan id {$id} di repository.");
            }

            return (bool) $result;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat memperbarui data desa dengan id {$id}.", 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat memperbarui data desa dengan id {$id}.", 0, $e);
        }
    }

    public function delete(string|int $id): bool
    {
        try {
            $result = $this->crudRepository->delete($id);

            if (!$result) {
                throw new DataAccessException("Gagal menghapus data desa dengan id {$id} di repository.");
            }

            return (bool) $result;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat menghapus data desa dengan id {$id}.", 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat menghapus data desa dengan id {$id}.", 0, $e);
        }
    }

    public function getByKecamatanId(string|int $id): Collection
    {
        try {
            return $this->repository->getByKecamatanId($id);
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat fetch data desa berdasarkan kecamatan dengan id {$id}.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat fetch data desa berdasarkan kecamatan dengan id {$id}.", 0, $e);
        }
    }

    public function import(mixed $file): array
    {
        try {
            $import = new DesaImport();
            Excel::import($import, $file);

            return $import->getFailures();
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            throw new ImportFailedException("Validasi data gagal saat import data desa.", 0, $e, collect($failures));
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat import data desa.", 0, $e);
        } catch (Throwable $e) {
            throw new ImportFailedException("Terjadi kesalahan tak terduga saat import data desa.", 0, $e);
        }
    }

    public function export(): FromCollection
    {
        try {
            return new DesaExport();
        } catch (Throwable $e) {
            throw new DataAccessException("Gagal export data desa.", 0, $e);
        }
    }
}
