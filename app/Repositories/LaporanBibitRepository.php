<?php

namespace App\Repositories;

use App\Models\LaporanKondisi;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

class LaporanBibitRepository implements CrudInterface
{
    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = LaporanKondisi::select(['id', 'status', 'created_at', 'kelompok_tani_id', 'komoditas_id', 'penyuluh_id']);
            if ($withRelations) {
                $query->with([
                    'kelompokTani' => function ($q) {
                        $q->select(['id', 'nama']);
                    },
                    'komoditas' => function ($q) {
                        $q->select(['id', 'nama', 'musim']);
                    },
                    'penyuluh' => function ($q) {
                        $q->select(['id', 'penyuluh_terdaftar_id']);
                    },
                    'penyuluh.penyuluhTerdaftar' => function ($q) {
                        $q->select(['id', 'nama', 'no_hp']);
                    },
                    'laporanKondisiDetail'
                ]);
            }
            return $query->get();
        } catch (QueryException $e) {
            Log::error('Failed to get all laporan kondisi bibit: ' . $e->getMessage(), [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
            ]);
            return Collection::make();
        } catch (Throwable $e) {
            Log::error('Failed to get all laporan kondisi bibit: ' . $e->getMessage(), [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
            ]);
            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            $query = LaporanKondisi::select(['id', 'status', 'created_at', 'kelompok_tani_id', 'komoditas_id', 'penyuluh_id']); // Select columns
            $query->with([
                'kelompokTani' => function ($q) {
                    $q->select(['id', 'nama', 'desa_id', 'kecamatan_id']);
                    $q->with([
                        'desa' => function ($q2) {
                            $q2->select(['id', 'nama']);
                        },
                        'kecamatan' => function ($q2) {
                            $q2->select(['id', 'nama']);
                        }
                    ]);
                },
                'komoditas' => function ($q) {
                    $q->select(['id', 'nama', 'musim']);
                },
                'penyuluh' => function ($q) {
                    $q->select(['id', 'penyuluh_terdaftar_id']);
                    $q->with([
                        'penyuluhTerdaftar' => function ($q2) {
                            $q2->select(['id', 'nama', 'no_hp']);
                        }
                    ]);
                },
                'laporanKondisiDetail'
            ]);

            return $query->findOrFail($id);
        } catch (QueryException $e) {
            Log::error('Gagal mengambil laporan bibit berdasarkan id', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
                'data'   => ['id' => $id],
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal mengambil laporan bibit berdasarkan id', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
                'data'   => ['id' => $id],
            ]);
            return null;
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return LaporanKondisi::create($data);
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan laporan bibit baru', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
                'data'   => $data,
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal menyimpan laporan bibit baru', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
                'data'   => $data,
            ]);
            return null;
        }
    }

    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            $model = LaporanKondisi::findOrFail($id);
            $model->update($data);
            return true;
        } catch (QueryException $e) {
            Log::error('Gagal memperbarui laporan bibit', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
                'data'   => [
                    'id'   => $id,
                    'data' => $data,
                ],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui laporan bibit', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
                'data'   => [
                    'id'   => $id,
                    'data' => $data,
                ],
            ]);
            return false;
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            $model = LaporanKondisi::findOrFail($id);
            $model->delete();
            return true;
        } catch (QueryException $e) {
            Log::error('Gagal menghapus laporan bibit', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'sql'    => $e->getSQL(),
                'data'   => ['id' => $id],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal menghapus laporan bibit', [
                'source' => __METHOD__,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
                'data'   => ['id' => $id],
            ]);
            return false;
        }
    }
}

