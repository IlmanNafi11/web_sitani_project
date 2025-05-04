<?php

namespace App\Repositories;

use App\Exceptions\DataAccessException;
use App\Models\PenyuluhTerdaftar;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarRepositoryInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Throwable;

class PenyuluhTerdaftarRepository implements CrudInterface, PenyuluhTerdaftarRepositoryInterface
{
    use LoggingError;

    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = PenyuluhTerdaftar::select(['id' , 'nama', 'no_hp', 'alamat', 'kecamatan_id']);

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
            return PenyuluhTerdaftar::where('id', $id)->select(['id', 'nama', 'no_hp', 'alamat', 'kecamatan_id'])->with(['kecamatan:id,nama'])->first();
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
            return PenyuluhTerdaftar::create($data);
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
            return PenyuluhTerdaftar::where('id', $id)->update($data);
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
            return PenyuluhTerdaftar::where('id', $id)->delete();
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
            return PenyuluhTerdaftar::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }

    public function getByPhone(string $phone): ?Model
    {
        try {
            return PenyuluhTerdaftar::select(['id', 'nama', 'no_hp', 'alamat', 'kecamatan_id'])->where('no_hp', $phone)->with(['kecamatan:id,nama'])->first();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['phone' => $phone]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['phone' => $phone]);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }

    public function calculateTotal(): int
    {
        try {
            return PenyuluhTerdaftar::count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__, 0, $e);
        }
    }
}
