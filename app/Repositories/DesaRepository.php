<?php

namespace App\Repositories;

use App\Exceptions\DataAccessException;
use App\Models\Desa;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\DesaRepositoryInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Throwable;

class DesaRepository implements CrudInterface, DesaRepositoryInterface
{
    use LoggingError;

    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = Desa::select(['id', 'nama', 'kecamatan_id']);
            if ($withRelations) {
                $query->with(['kecamatan:id,nama']);
            }
            return $query->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return Desa::where('id', $id)->with(['kecamatan:id,nama'])->first();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return Desa::create($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['data' => $data]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }

    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            return Desa::where('id', $id)->update($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id, 'data_baru' => $data]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id, 'data_baru' => $data]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            return Desa::destroy($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }

    public function getByKecamatanId(int|string $id): Collection
    {
        try {
            return Desa::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }

    public function calculateTotal(): int
    {
        try {
            return Desa::count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }
}
