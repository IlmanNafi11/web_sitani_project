<?php

namespace App\Repositories;

use App\Models\Desa;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\DesaCustomQueryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class DesaRepository implements CrudInterface, DesaCustomQueryInterface
{

    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = Desa::select(['id', 'nama', 'kecamatan_id']);
            if ($withRelations) {
                $query->with(['kecamatan:id,nama']);
            }
            return $query->get();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil seluruh data desa', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);
            return Collection::make();
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil seluruh data desa', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return Desa::where('id', $id)->with(['kecamatan:id,nama'])->first();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil data desa berdasarkan id: ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
                'data' => ['id' => $id],
            ]);
            return null;
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data desa berdasarkan id: ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => ['id' => $id],
            ]);
            return null;
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return Desa::create($data);
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan data desa', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
                'data' => $data,
            ]);
            return null;
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan data desa', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
            ]);
            return null;
        }
    }

    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            return Desa::where('id', $id)->update($data);
        } catch (QueryException $e) {
            Log::error('Gagal memperbarui data desa', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
                'data' => [
                    'id' => $id,
                    'data' => $data,
                ],
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui data desa', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'id' => $id,
                    'data' => $data,
                ],
            ]);
            return false;
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            return Desa::destroy($id);
        } catch (QueryException $e) {
            Log::error('Gagal menghapus data desa', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
                'data' => ['id' => $id],
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus data desa', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => ['id' => $id],
            ]);
            return false;
        }
    }

    public function getByKecamatanId(int|string $id): Collection
    {
        try {
            return Desa::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil data desa berdasarkan kecamatan_id: ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
                'data' => ['kecamatan_id' => $id],
            ]);
            return Collection::make();
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data desa berdasarkan kecamatan_id: ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => ['kecamatan_id' => $id],
            ]);
            return Collection::make();
        }
    }
}
