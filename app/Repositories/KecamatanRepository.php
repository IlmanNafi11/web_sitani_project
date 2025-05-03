<?php

namespace App\Repositories;

use App\Models\Kecamatan;
use App\Repositories\Interfaces\CrudInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

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
            return Collection::make();
        } catch (\Throwable $e) {
            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return Kecamatan::where('id', $id)->first();
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
            return Kecamatan::create($data);
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
            return Kecamatan::where('id', $id)->update($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id, 'data_baru' => $data]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            return Kecamatan::destroy($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }
}

