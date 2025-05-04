<?php

namespace App\Services;

use App\Exceptions\DataAccessException;
use App\Exceptions\ImportFailedException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\ManyRelationshipManagement;
use App\Services\Interfaces\KelompokTaniServiceInterface;
use App\Trait\LoggingError;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\KelompokTaniImport;
use App\Exports\KelompokTaniExport;
use Throwable;

class KelompokTaniService implements KelompokTaniServiceInterface
{
    use LoggingError;

    protected CrudInterface $crudRepository;
    protected ManyRelationshipManagement $relationManager;

    public function __construct(CrudInterface $crudRepository, ManyRelationshipManagement $relationManager)
    {
        $this->crudRepository = $crudRepository;
        $this->relationManager = $relationManager;
    }

    /**
     * @throws DataAccessException
     */
    public function getAll(bool $withRelations = false): Collection
    {
        try {
            return $this->crudRepository->getAll($withRelations);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while fetching kelompok tani data.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while fetching kelompok tani data.', 0, $e);
        }
    }

    /**
     * @throws ResourceNotFoundException
     * @throws DataAccessException
     */
    public function getById(int|string $id): Model
    {
        try {
            $kelompokTani = $this->crudRepository->getById($id);

            if ($kelompokTani === null) {
                throw new ResourceNotFoundException("Kelompok Tani with ID {$id} not found.");
            }

            if ($kelompokTani instanceof Collection) {
                $kelompokTani = $kelompokTani->first();
                if ($kelompokTani === null) {
                    throw new ResourceNotFoundException("Kelompok Tani with ID {$id} not found or incorrect type returned.");
                }
            }

            return $kelompokTani;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error while fetching Kelompok Tani with ID {$id}.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Unexpected error while fetching Kelompok Tani with ID {$id}.", 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function create(array $data): Model
    {
        try {
            return DB::transaction(function () use ($data) {
                $kelompokTani = $this->crudRepository->create(Arr::except($data, ['penyuluh_terdaftar_id']));

                if ($kelompokTani === null) {
                    throw new DataAccessException('Failed to create Kelompok Tani data in repository.');
                }

                $penyuluhIds = $data['penyuluh_terdaftar_id'] ?? [];
                if (!empty($penyuluhIds)) {
                    $penyuluhIdsToAttach = Arr::flatten($penyuluhIds);
                    $this->relationManager->attach($kelompokTani, $penyuluhIdsToAttach);
                }

                $kelompokTani->load('penyuluhTerdaftars');

                return $kelompokTani;
            });
        } catch (QueryException $e) {
            throw new DataAccessException('Database error during Kelompok Tani creation transaction.', 0, $e);
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error during Kelompok Tani creation transaction.', 0, $e);
        }
    }

    /**
     * @throws ResourceNotFoundException
     * @throws DataAccessException
     */
    public function update(int|string $id, array $data): bool
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $kelompokTani = $this->getById($id);
                $updated = $this->crudRepository->update($id, Arr::except($data, ['penyuluh_terdaftar_id']));

                if (!$updated) {
                    throw new DataAccessException("Failed to update Kelompok Tani data in repository for ID {$id}.");
                }

                $penyuluhIds = $data['penyuluh_terdaftar_id'] ?? [];
                $penyuluhIdsToSync = Arr::flatten($penyuluhIds);
                $this->relationManager->sync($kelompokTani, $penyuluhIdsToSync);


                return true;
            });
        } catch (ResourceNotFoundException|DataAccessException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error during Kelompok Tani update transaction.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error during Kelompok Tani update transaction.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function delete(int|string $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $kelompokTani = $this->getById($id);

                $this->relationManager->detach($kelompokTani);
                $deleted = $this->crudRepository->delete($id);

                if (!$deleted) {
                    throw new DataAccessException("Failed to delete Kelompok Tani data in repository for ID {$id}.");
                }

                return true;
            });
        } catch (ResourceNotFoundException|DataAccessException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error during Kelompok Tani deletion transaction.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error during Kelompok Tani deletion transaction.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ImportFailedException
     */
    public function import(mixed $file): array
    {
        try {
            $import = new KelompokTaniImport();
            Excel::import($import, $file);

            $failures = $import->getFailures();

            if ($failures->isNotEmpty()) {
                throw new ImportFailedException("Import completed with failures.", 0, null, $failures);
            }
            return [];
        } catch (ImportFailedException $e) {
            throw $e;
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw new DataAccessException("Database error during Kelompok Tani import.", 0, $e);
        } catch (Throwable $e) {
            $this->LogGeneralException($e);
            throw new ImportFailedException("Unexpected error during Kelompok Tani import.", 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function export(): FromCollection
    {
        try {
            return new KelompokTaniExport();
        } catch (Throwable $e) {
            throw new DataAccessException("Failed to prepare Kelompok Tani data for export.", 0, $e);
        }
    }
}
