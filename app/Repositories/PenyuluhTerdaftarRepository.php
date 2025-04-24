<?php

namespace App\Repositories;

use App\Models\PenyuluhTerdaftar;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarCustomQueryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class PenyuluhTerdaftarRepository implements CrudInterface, PenyuluhTerdaftarCustomQueryInterface
{
    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = PenyuluhTerdaftar::select(['id' , 'nama', 'no_hp', 'alamat', 'kecamatan_id']);

            if ($withRelations) {
                $query->with(['kecamatan:id,nama']);
            }

            return $query->get();

        } catch (QueryException $e) {
            Log::error('Gagal mengambil seluruh data penyuluh terdaftar', [
                'source' => __METHOD__,
                'erorr' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return Collection::make();
        } catch (\Exception $e) {
            Log::error('Gagal mengambil seluruh data penyuluh terdaftar', [
                'source' => __METHOD__,
                'erorr' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return PenyuluhTerdaftar::where('id', $id)->select(['id', 'nama', 'no_hp', 'alamat', 'kecamatan_id'])->with(['kecamatan:id,nama'])->first();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil data penyuluh terdaftar berdasarkan id : ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data penyuluh terdaftar berdasarkan id : ' . $id, [
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
            return PenyuluhTerdaftar::create($data);
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan penyuluh terdaftar', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan penyuluh terdaftar', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            return PenyuluhTerdaftar::where('id', $id)->update($data);
        } catch (QueryException $e) {
            Log::error('Gagal memperbarui data penyuluh Terdaftar', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data penyuluh Terdaftar', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            return PenyuluhTerdaftar::where('id', $id)->delete();
        } catch (QueryException $e) {
            Log::error('Gagal menghapus penyuluh terdaftar', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Gagal menghapus penyuluh terdaftar', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    public function getByKecamatanId(int|string $id): Collection
    {
        try {
            return PenyuluhTerdaftar::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil data penyuluh berdasarkan kecamatan id', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return Collection::make();
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data penyuluh berdasarkan kecamatan id', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Collection::make();
        }
    }

    public function getByPhone(string $phone): ?Model
    {
        try {
            return PenyuluhTerdaftar::select(['id', 'nama', 'no_hp', 'alamat', 'kecamatan_id'])->where('no_hp', $phone)->with(['kecamatan:id,nama'])->first();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil data penyuluh berdasarkan no telp', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSQL(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data penyuluh berdasarkan no telp', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }
}
