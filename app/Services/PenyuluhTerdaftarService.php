<?php

namespace App\Services;

use App\Exceptions\DataAccessException;
use App\Exceptions\ImportFailedException;
use App\Exceptions\ResourceNotFoundException;
use App\Imports\PenyuluhTerdaftarImport;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarRepositoryInterface;
use App\Services\Interfaces\PenyuluhTerdaftarServiceInterface;
use App\Trait\LoggingError;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\PenyuluhTerdaftarExport;
use Throwable;

class PenyuluhTerdaftarService implements PenyuluhTerdaftarServiceInterface
{
    use LoggingError;

    protected CrudInterface $crudRepository;
    protected PenyuluhTerdaftarRepositoryInterface $repository;

    public function __construct(CrudInterface $crudRepository, PenyuluhTerdaftarRepositoryInterface $repository)
    {
        $this->crudRepository = $crudRepository;
        $this->repository = $repository;
    }

    public function getAll(bool $withRelations = false): Collection
    {
        try {
            return $this->crudRepository->getAll($withRelations);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat fetch data penyuluh terdaftar.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat saat fetch data penyuluh terdaftar.', 0, $e);
        }
    }

    public function getById(string|int $id): Model
    {
        try {
            $penyuluh = $this->crudRepository->getById($id);

            if (empty($penyuluh)) {
                throw new ResourceNotFoundException("Penyuluh terdaftar dengan id {$id} tidak ditemukan.");
            }

            return $penyuluh;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat fetch data penyuluh terdaftar dengan id {$id}.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat fetch data penyuluh terdaftar dengan id {$id}.", 0, $e);
        }
    }

    public function create(array $data): Model
    {
        try {
            $penyuluh = $this->crudRepository->create($data);

            if ($penyuluh === null) {
                throw new DataAccessException('Gagal menyimpan data penyuluh terdaftar di repository.');
            }

            return $penyuluh;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat menyimpan data penyuluh terdaftar.', 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat menyimpan data penyuluh terdaftar.', 0, $e);
        }
    }

    public function update(string|int $id, array $data): bool
    {
        try {
            $result = $this->crudRepository->update($id, $data);

            if(!$result) {
                throw new DataAccessException("Gagal memperbarui data penyuluh terdaftar dengan id {$id} di repository.");
            }
            return (bool) $result;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat memperbarui data penyuluh terdaftar dengan id {$id}.", 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat memperbarui data penyuluh terdaftar dengan id {$id}.", 0, $e);
        }
    }

    public function delete(string|int $id): bool
    {
        try {
            $result = $this->crudRepository->delete($id);

            if (!$result) {
                throw new DataAccessException("Gagal menghapus data penyuluh terdaftar dengan id {$id} di repository.");
            }

            return (bool) $result;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat menghapus data penyuluh terdaftar dengan id {$id}.", 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat menghapus data penyuluh terdaftar dengan id {$id}.", 0, $e);
        }
    }

    public function getByKecamatanId(string|int $id): Collection
    {
        try {
            return $this->repository->getByKecamatanId($id);
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat fetch data penyuluh terdaftar berdasarkan kecamatan dengan id {$id}.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat fetch data penyuluh terdaftar berdasarkan kecamatan dengan id {$id}.", 0, $e);
        }
    }

    public function calculateTotal(): int
    {
        try {
            return $this->repository->calculateTotal();
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat menghitung total penyuluh terdaftar.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat menghitung total penyuluh terdaftar.', 0, $e);
        }
    }

    public function import(mixed $file): array
    {
        try {
            $import = new PenyuluhTerdaftarImport();
            Excel::import($import, $file);

            return $import->getFailures();
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            throw new ImportFailedException("Validasi gagal saat import data.", 0, $e, collect($failures));
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat import data penyuluh terdaftar.", 0, $e);
        } catch (Throwable $e) {
            throw new ImportFailedException("Terjadi kesalahan tak terduga saat import data penyuluh terdaftar.", 0, $e);
        }
    }

    public function export(): FromCollection
    {
        try {
            return new PenyuluhTerdaftarExport();
        } catch (Throwable $e) {
            throw new DataAccessException("Gagal export data penyuluh terdaftar.", 0, $e);
        }
    }
}
