<?php

namespace App\Services\Api;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Services\Interfaces\KomoditasApiServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Throwable;

class KomoditasApiService implements KomoditasApiServiceInterface
{
    protected CrudInterface $crudRepository;
    protected KomoditasRepositoryInterface $repository;

    public function __construct(CrudInterface $crudRepository, KomoditasRepositoryInterface $repository)
    {
        $this->crudRepository = $crudRepository;
        $this->repository = $repository;
    }

    public function getAllApi(bool $withRelations = false): Collection
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

            // rencana dihapus
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

    public function GetMusim(): Collection
    {
        try {
            return $this->repository->GetMusim();
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat fetch data musim.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tak terduga saat fetch data musim.', 0, $e);
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
}
