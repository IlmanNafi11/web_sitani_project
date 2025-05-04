<?php

namespace App\Services\Api;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\KelompokTaniRepositoryInterface;
use App\Services\Interfaces\KelompokTaniApiServiceInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Throwable;

class KelompokTaniApiService implements KelompokTaniApiServiceInterface
{
    use LoggingError;

    protected KelompokTaniRepositoryInterface $kelompokTaniRepository;
    protected CrudInterface $crudRepository;

    public function __construct(KelompokTaniRepositoryInterface $kelompokTaniRepository, CrudInterface $crudRepository)
    {
        $this->kelompokTaniRepository = $kelompokTaniRepository;
        $this->crudRepository = $crudRepository;
    }

    public function getAllByPenyuluhId(array $penyuluhIds): Collection
    {
        try {
            return $this->kelompokTaniRepository->getByPenyuluhId($penyuluhIds);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while fetching Kelompok Tani by Penyuluh ID.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while fetching Kelompok Tani by Penyuluh ID.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ResourceNotFoundException
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
            throw new DataAccessException("Database error while fetching Kelompok Tani with ID {$id} for API.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Unexpected error while fetching Kelompok Tani with ID {$id} for API.", 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function calculateTotal(): int
    {
        try {
            return $this->kelompokTaniRepository->calculateTotal();
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while calculating total Kelompok Tani.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while calculating total Kelompok Tani.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function countByKecamatanId(int|string $id): int
    {
        try {
            return $this->kelompokTaniRepository->countByKecamatanId($id);
        } catch (QueryException $e) {
            throw new DataAccessException("Database error while counting Kelompok Tani by Kecamatan ID {$id}.", 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException("Unexpected error while counting Kelompok Tani by Kecamatan ID {$id}.", 0, $e);
        }
    }
}
