<?php

namespace App\Repositories;

use App\Exceptions\DataAccessException;
use App\Models\Kecamatan;
use App\Repositories\Interfaces\CrudInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Throwable;

class KecamatanRepository implements CrudInterface
{
    use LoggingError;

    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = Kecamatan::select(['id', 'nama']);
            if ($withRelations) {
                $query->with(['desa:id,nama']);
            }
            return $query->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' .  __METHOD__, 0, $e);
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return Kecamatan::where('id', $id)->first();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' .  __METHOD__, 0, $e);
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return Kecamatan::create($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['data' => $data]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' .  __METHOD__, 0, $e);
        }
    }

    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            return Kecamatan::where('id', $id)->update($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id, 'data_baru' => $data]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id, 'data_baru' => $data]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' .  __METHOD__, 0, $e);
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            return Kecamatan::destroy($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' .  __METHOD__, 0, $e);
        }
    }
}

