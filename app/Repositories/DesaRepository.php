<?php

namespace App\Repositories;

use App\Models\Desa;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\DesaRepositoryInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

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
            return Collection::make();
        } catch (\Throwable $e) {
            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return Desa::where('id', $id)->with(['kecamatan:id,nama'])->first();
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
            return Desa::create($data);
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
            return Desa::where('id', $id)->update($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['data_baru' => $data]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            return Desa::destroy($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function getByKecamatanId(int|string $id): Collection
    {
        try {
            return Desa::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return Collection::make();
        } catch (\Throwable $e) {
            return Collection::make();
        }
    }
}
