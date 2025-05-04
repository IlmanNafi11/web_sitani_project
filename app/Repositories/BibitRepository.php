<?php

namespace App\Repositories;

use App\Exceptions\DataAccessException;
use App\Models\BibitBerkualitas;
use App\Repositories\Interfaces\BibitRepositoryInterface;
use App\Repositories\Interfaces\CrudInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class BibitRepository implements CrudInterface, BibitRepositoryInterface
{
    use LoggingError;

    /**
     * @throws DataAccessException
     */
    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = BibitBerkualitas::select(['id', 'nama', 'deskripsi', 'komoditas_id']);
            if ($withRelations) {
                $query->with(['komoditas:id,nama']);
            }
            return $query->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw $e;
        } catch (\Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Terjadi kesalahan tak terduga direpository.', 500, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return BibitBerkualitas::find($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            throw $e;
        } catch (\Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Terjadi kesalahan tak terduga direpository.', 500, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function create(array $data): ?Model
    {
        try {
            return BibitBerkualitas::create($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            throw $e;
        } catch (\Throwable $e) {
            $this->LogGeneralException($e, ['data' => $data]);
            throw new DataAccessException('Terjadi kesalahan tak terduga direpository.', 500, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            return BibitBerkualitas::where('id', $id)->update($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e,['data_baru' => $data]);
            throw $e;
        } catch (\Throwable $e) {
            $this->LogGeneralException($e, ['data_baru' => $data]);
            throw new DataAccessException('Terjadi kesalahan tak terduga direpository.', 500, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function delete(string|int $id): Model|bool|int
    {
        try {
            return BibitBerkualitas::destroy($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e,['id' => $id]);
            throw $e;
        } catch (\Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id]);
            throw new DataAccessException('Terjadi kesalahan tak terduga direpository.', 500, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function calculateTotal(): int
    {
        try {
            return BibitBerkualitas::count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw $e;
        } catch (\Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Terjadi kesalahan tak terduga direpository.', 500, $e);
        }
    }
}
