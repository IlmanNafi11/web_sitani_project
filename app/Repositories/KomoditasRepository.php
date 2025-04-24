<?php

namespace App\Repositories;

use App\Models\Komoditas;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class KomoditasRepository implements CrudInterface
{
    public function getAll($withRelations = false): Collection|array
    {
        try {
            $query = Komoditas::select(['id', 'nama', 'deskripsi', 'musim']);
            if ($withRelations) {
                $query->with(['bibitBerkualitas:id,komoditas_id']);
            }

            return $query->get();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil seluruh data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return Collection::make();
        } catch (\Exception $e) {
            Log::error('Gagal mengambil seluruh data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Collection::make();
        }
    }

    public function find($id): Model|Collection|array|null
    {
        try {
            return Komoditas::select(['id', 'nama', 'deskripsi', 'musim'])->where('id', $id)->first();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil data komoditas berdasarkan ID', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data komoditas berdasarkan ID', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return Komoditas::create($data);
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    public function update($id, array $data): Model|bool|int
    {
        try {
            return Komoditas::where('id', $id)->update($data);
        } catch (QueryException $e) {
            Log::error('Gagal memperbarui data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }

    }

    public function delete($id): Model|bool|int
    {
        try {
            return Komoditas::where('id', $id)->delete();
        } catch (QueryException $e) {
            Log::error('Gagal menghapus data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }
}
