<?php

namespace App\Repositories;

use App\Models\Komoditas;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Trait\LoggingError;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class KomoditasRepository implements CrudInterface, KomoditasRepositoryInterface
{
    use LoggingError;

    public function getAll($withRelations = false): Collection|array
    {
        try {
            $query = Komoditas::select(['id', 'nama', 'deskripsi', 'musim']);
            if ($withRelations) {
                $query->with(['bibitBerkualitas:id,komoditas_id']);
            }

            return $query->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            return Collection::make();
        } catch (\Throwable $e) {
            return Collection::make();
        }
    }

    public function getById($id): Model|Collection|array|null
    {
        try {
            return Komoditas::select(['id', 'nama', 'deskripsi', 'musim'])->where('id', $id)->first();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return Komoditas::create($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            return null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function update($id, array $data): Model|bool|int
    {
        try {
            return Komoditas::where('id', $id)->update($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id, 'data_baru' => $data]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }

    }

    public function delete($id): Model|bool|int
    {
        try {
            return Komoditas::where('id', $id)->delete();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function calculateTotal(): int
    {
        try {
            return Komoditas::count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw new Exception('Terjadi kesalahan pada query', 500);
        } catch (\Throwable $e) {
            throw new Exception('Terjadi kesalahan pada server saat menghitung total komoditas', 500);
        }
    }

    /**
     * @throws Exception
     */
    public function GetMusim(): Collection
    {
        try {
            return Komoditas::select(['nama', 'musim'])->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw new Exception('Terjadi kesalahan pada query', 500);
        } catch (\Throwable $e) {
            throw new Exception('Terjadi kesalahan direpository', 500);
        }
    }
}
