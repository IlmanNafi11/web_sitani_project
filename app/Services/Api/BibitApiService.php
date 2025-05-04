<?php

namespace App\Services\Api;

use App\Exceptions\DataAccessException;
use App\Repositories\Interfaces\BibitRepositoryInterface;
use App\Repositories\Interfaces\CrudInterface;
use App\Services\Interfaces\BibitApiServiceInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Throwable;

class BibitApiService implements BibitApiServiceInterface
{
    protected CrudInterface $crudRepository;
    protected BibitRepositoryInterface $repository;

    public function __construct(CrudInterface $crudRepository, BibitRepositoryInterface $repository)
    {
        $this->crudRepository = $crudRepository;
        $this->repository = $repository;
    }

    /**
     * @throws DataAccessException
     */
    public function getAllApi(): Collection
    {
        try {
            return $this->crudRepository->getAll(false);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat fetch data bibit.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat fetch data bibit', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function calculateTotal(): int
    {
        try {
            return $this->repository->calculateTotal();
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat menghitung totol data bibit.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat menghitung total data bibit', 0, $e);
        }
    }
}
