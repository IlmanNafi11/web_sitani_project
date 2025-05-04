<?php
namespace App\Services;

use App\Events\NotifGenerated;
use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\ImportFailedException;
use App\Models\User;
use App\Repositories\Interfaces\BibitRepositoryInterface;
use App\Repositories\Interfaces\CrudInterface;
use App\Services\Interfaces\BibitServiceInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Throwable;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BibitImport;

class BibitService implements BibitServiceInterface
{
    use LoggingError;

    protected CrudInterface $crudRepository;
    protected BibitRepositoryInterface $repository;

    public function __construct(CrudInterface $crudRepository, BibitRepositoryInterface $repository)
    {
        $this->crudRepository = $crudRepository;
        $this->repository = $repository;
    }

    public function getAll(bool $withRelations = false): Collection
    {
        try {
            return $this->crudRepository->getAll($withRelations);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat fetch data.', 500, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga.', 500, $e);
        }
    }

    public function getById(string|int $id): Model
    {
        try {
            $bibit = $this->crudRepository->getById($id);

            if (empty($bibit)) {
                throw new ResourceNotFoundException("Bibit dengan {$id} tidak ditemukan.");
            }

            return $bibit;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat mengambil data dengan id {$id}.", 500, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat mengambil data dengan id {$id}.", 500, $e);
        }
    }

    public function create(array $data): Model
    {
        try {
            $bibit = $this->crudRepository->create($data);
            if ($bibit === null) {
                throw new DataAccessException('Gagal menyimpan data bibit di repository.');
            }

            $users = User::role('penyuluh')->get();
            foreach ($users as $user) {
                event(new NotifGenerated(
                    $user,
                    'Bibit Baru Tersedia',
                    'Admin menambahkan bibit baru: ' . ($bibit->nama ?? 'bibit'),
                    'bibit_baru'
                ));
            }
            return $bibit;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat menyimpan data bibit.', 500, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat menyimpan data bibit.', 500, $e);
        }
    }

    public function update(string|int $id, array $data): bool
    {
        try {
            $result = $this->crudRepository->update($id, $data);

            if(!$result) {
                throw new DataAccessException("Gagal memperbarui data bibit dengan id {$id} di repository.");
            }

            return (bool) $result;

        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat memperbarui data bibit dengan id {$id}.", 500, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat memperbarui data bibit dengan id {$id}.", 0, $e);
        }
    }

    public function delete(string|int $id): bool
    {
        try {
            $result = $this->crudRepository->delete($id);

            if (!$result) {
                throw new DataAccessException("Gagal menghapus data bibit dengan id {$id} di repository.");
            }
            return (bool) $result;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat menghapus data bibit dengan id {$id}.", 500, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException("Terjadi kesalahan tak terduga saat menghapus data bibit dengan id {$id}.", 500, $e);
        }
    }

    public function calculateTotal(): int
    {
        try {
            return $this->repository->calculateTotal();
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat menghitung total bibit.', 500, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat menghitung total bibit.', 500, $e);
        }
    }

    public function import(mixed $file): array
    {
        try {
            $import = new BibitImport();
            Excel::import($import, $file);

            return $import->getFailures();

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            throw new ImportFailedException("validasi import gagal.", 400, $e, $failures);

        } catch (QueryException $e) {
            throw new DataAccessException("Database error saat import data bibit", 500, $e);
        } catch (Throwable $e) {
            throw new ImportFailedException("Unexpected error during bibit import.", 500, $e);
        }
    }

    public function export()
    {
        try {
            return new \App\Exports\BibitExport();
        } catch (Throwable $e) {
            throw new DataAccessException("Gagal saat akan export data.", 500, $e);
        }
    }
}
