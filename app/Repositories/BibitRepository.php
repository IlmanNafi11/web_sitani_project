<?php

namespace App\Repositories;

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
            return Collection::make();
        } catch (\Throwable $e) {
            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return BibitBerkualitas::where('id', $id)->first();
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
            return BibitBerkualitas::create($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            return null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            return BibitBerkualitas::where('id', $id)->update($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e,['data_baru' => $data]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            return BibitBerkualitas::destroy($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e,['id' => $id]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * @throws \Exception
     */
    public function calculateTotal(): int
    {
        try {
            return BibitBerkualitas::count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw new QueryException($e->getConnectionName(), $e->getSql(), $e->getBindings(), $e->getPrevious());
        } catch (\Throwable $e) {
            throw new \Exception('Terjadi Kesalahan di server saat menghitung total record', 500);
        }
    }
}
