<?php

namespace App\Repositories;

use App\Models\Komoditas;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

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
            Log::error('Gagal mengambil seluruh data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);

            return Collection::make();
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil seluruh data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Collection::make();
        }
    }

    public function getById($id): Model|Collection|array|null
    {
        try {
            return Komoditas::select(['id', 'nama', 'deskripsi', 'musim'])->where('id', $id)->first();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil data komoditas berdasarkan ID', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);
            return null;
        } catch (\Throwable $e) {
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
                'sql' => $e->getSql(),
            ]);

            return null;
        } catch (\Throwable $e) {
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
                'sql' => $e->getSql(),
            ]);

            return false;
        } catch (\Throwable $e) {
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
                'sql' => $e->getSql(),
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus data komoditas', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    /**
     * @throws \Exception
     */
    public function calculateTotal(): int
    {
        try {
            return Komoditas::count();
        } catch (QueryException $e) {
            Log::error('Terjadi kesalahan pada query saat mencoba menghitung total record', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);
            throw new \Exception('Terjadi kesalahan pada query', 500);
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menghitung total record', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \Exception('Terjadi kesalahan pada server saat menghitung total komoditas', 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function GetMusim(): Collection
    {
        try {
            return Komoditas::select(['nama', 'musim'])->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw new \Exception('Terjadi kesalahan pada query', 500);
        } catch (\Throwable $e) {
            $this->LogGeneralException($e);
            throw new \Exception('Terjadi kesalahan direpository', 500);
        }
    }
}
