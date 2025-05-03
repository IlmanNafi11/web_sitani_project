<?php

namespace App\Repositories;

use App\Models\PenyuluhTerdaftar;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarRepositoryInterface;
use App\Trait\LoggingError;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

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
            return Collection::make();
        } catch (Exception $e) {
            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return PenyuluhTerdaftar::where('id', $id)->select(['id', 'nama', 'no_hp', 'alamat', 'kecamatan_id'])->with(['kecamatan:id,nama'])->first();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return PenyuluhTerdaftar::create($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            return PenyuluhTerdaftar::where('id', $id)->update($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['data_baru' => $data]);
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            return PenyuluhTerdaftar::where('id', $id)->delete();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getByKecamatanId(int|string $id): Collection
    {
        try {
            return PenyuluhTerdaftar::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return Collection::make();
        } catch (Exception $e) {
            return Collection::make();
        }
    }

    public function getByPhone(string $phone): ?Model
    {
        try {
            return PenyuluhTerdaftar::select(['id', 'nama', 'no_hp', 'alamat', 'kecamatan_id'])->where('no_hp', $phone)->with(['kecamatan:id,nama'])->first();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['phone' => $phone]);
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @throws Exception
     */
    public function calculateTotal(): int
    {
        try {
            return PenyuluhTerdaftar::count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw new Exception('Terjadi kesalahan pada query', 500);
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan pada server saat menghitung record', 500);
        }
    }
}
