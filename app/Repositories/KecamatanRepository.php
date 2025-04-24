<?php

namespace App\Repositories;

use App\Models\Kecamatan;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class KecamatanRepository implements CrudInterface
{
    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = Kecamatan::select(['id', 'nama']);
            if ($withRelations) {
                $query->with(['desa:id,nama']);
            }
            return $query->get();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil seluruh data kecamatan', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);
            return Collection::make();
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil seluruh data kecamatan', [
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
            return Kecamatan::where('id', $id)->first();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil data kecamatan berdasarkan id: ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
                'data' => ['id' => $id],
            ]);
            return null;
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data kecamatan berdasarkan id: ' . $id, [
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
            return Kecamatan::create($data);
        } catch (QueryException $e) {
            Log::error('Gagal membuat data kecamatan', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
                'data' => $data,
            ]);
            return null;
        } catch (\Throwable $e) {
            Log::error('Gagal membuat data kecamatan', [
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
            return Kecamatan::where('id', $id)->update($data);
        } catch (QueryException $e) {
            Log::error('Gagal memperbarui data kecamatan', [
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
            Log::error('Gagal memperbarui data kecamatan', [
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
            return Kecamatan::destroy($id);
        } catch (QueryException $e) {
            Log::error('Gagal menghapus data kecamatan', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
                'data' => ['id' => $id],
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus data kecamatan', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => ['id' => $id],
            ]);
            return false;
        }
    }
}

