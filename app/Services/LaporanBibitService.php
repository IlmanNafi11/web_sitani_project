<?php

namespace App\Services;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Interfaces\CrudInterface;
use App\Services\Interfaces\LaporanBibitServiceInterface;
use App\Trait\LoggingError;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class LaporanBibitService implements LaporanBibitServiceInterface
{
    use LoggingError;

    protected CrudInterface $crudRepository;

    public function __construct(CrudInterface $crudRepository)
    {
        $this->crudRepository = $crudRepository;
    }

    /**
     * @throws DataAccessException
     */
    public function getAll(bool $withRelations = false): Collection
    {
        try {
            return $this->crudRepository->getAll($withRelations);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while fetching laporan bibit data.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while fetching laporan bibit data.', 0, $e);
        }
    }

    /**
     * @throws ResourceNotFoundException
     * @throws DataAccessException
     */
    public function getById(string|int $id): Model
    {
        try {
            $laporan = $this->crudRepository->getById($id);

            if ($laporan === null) {
                throw new ResourceNotFoundException("Laporan Bibit with ID {$id} not found.");
            }

            if ($laporan instanceof Collection) {
                $laporan = $laporan->first();
                if ($laporan === null) {
                    throw new ResourceNotFoundException("Laporan Bibit with ID {$id} not found or incorrect type returned.");
                }
            }


            return $laporan;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException("Database error while fetching Laporan Bibit with ID {$id}.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Unexpected error while fetching Laporan Bibit with ID {$id}.", 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function update(string|int $id, array $data): bool
    {
        try {
            $updated = $this->crudRepository->update($id, $data);
            if (!$updated) {
                throw new ResourceNotFoundException("Laporan Bibit with ID {$id} not found for update.");
            }
            return true;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error during laporan bibit update.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error during laporan bibit update.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function delete(string|int $id): bool
    {
        try {
            $laporan = $this->getById($id);

            if ($laporan->laporanKondisiDetail && $laporan->laporanKondisiDetail->foto_bibit) {
                try {
                    Storage::disk('public')->delete($laporan->laporanKondisiDetail->foto_bibit);
                } catch (Throwable $fileDeleteError) {
                    $this->LogGeneralException($fileDeleteError, ['message' => 'Failed to delete report file', 'laporan_id' => $id]);
                }
            }

            $deleted = $this->crudRepository->delete($id);

            if (!$deleted) {
                throw new DataAccessException("Failed to delete Laporan Bibit data in repository for ID {$id}.");
            }

            return true;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error during laporan bibit deletion.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error during laporan bibit deletion.', 0, $e);
        }
    }
}
