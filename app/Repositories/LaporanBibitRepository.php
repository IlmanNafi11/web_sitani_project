<?php

namespace App\Repositories;

use App\Models\LaporanKondisi;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\LaporanRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class LaporanBibitRepository implements CrudInterface, LaporanRepositoryInterface
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
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);
            return Collection::make();
        } catch (Throwable $e) {
            Log::error('Failed to get all laporan kondisi bibit: ' . $e->getMessage(), [
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
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => ['id' => $id],
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal mengambil laporan bibit berdasarkan id', [
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
            return LaporanKondisi::create($data);
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan laporan bibit baru', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => $data,
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal menyimpan laporan bibit baru', [
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
            $model = LaporanKondisi::findOrFail($id);
            $model->update($data);
            return true;
        } catch (QueryException $e) {
            Log::error('Gagal memperbarui laporan bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => [
                    'id' => $id,
                    'data' => $data,
                ],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui laporan bibit', [
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
            $model = LaporanKondisi::findOrFail($id);
            $model->delete();
            return true;
        } catch (QueryException $e) {
            Log::error('Gagal menghapus laporan bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => ['id' => $id],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal menghapus laporan bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => ['id' => $id],
            ]);
            return false;
        }
    }

    public function getByPenyuluhId(array $conditions = [], array $relations = []): Collection|array
    {
        try {
            $query = LaporanKondisi::query();

            if (!empty($relations)) {
                $query->with($relations);
            }

            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }

            return $query->get();
        } catch (QueryException $e) {
            Log::error('Gagal mengambil seluruh laporan bibit berdasarkan penyuluh id', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);
            return Collection::make();
        } catch (Throwable $e) {
            Log::error('Gagal mengambil seluruh laporan bibit berdasarkan penyuluh id', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return Collection::make();
        }
    }

    /**
     * @throws Exception
     */
    public function calculateTotal(): int
    {
        try {
            return LaporanKondisi::count();
        } catch (QueryException $e) {
            Log::error('Terjadi kesalahan pada query saat mencoba menghitung total record', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);
            throw new Exception('Terjadi kesalahan pada query.', 500);
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat menghitung total record', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new Exception('Terjadi kesalahan pada server saat menghitung total record.', 500);
        }
    }

    /**
     * @throws Exception
     */
    public function getLaporanStatusCounts(?int $penyuluhId = null): array
    {
        $statusCounts = [
            'approved' => 0,
            'rejected' => 0,
            'pending' => 0,
        ];

        try {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();

            $query = LaporanKondisi::select('status', DB::raw('count(*) as total'))
                ->whereIn('status', [1, 2, 3])
                ->whereBetween('created_at', [$startDate, $endDate]);

            if (!is_null($penyuluhId)) {
                $query->where('penyuluh_id', $penyuluhId);
            }

            $rawCounts = $query->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();

            $statusMap = [
                1 => 'approved',
                2 => 'rejected',
                3 => 'pending',
            ];

            foreach ($statusMap as $statusValue => $statusName) {
                $statusCounts[$statusName] = $rawCounts[$statusValue] ?? 0;
            }
            return $statusCounts;
        } catch (QueryException $e) {
            Log::error('Repository Error: Terjadi kesalahan pada query', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'penyuluh_id' => $penyuluhId,
                'trace' => $e->getTraceAsString(),
            ]);

            throw new Exception('Terjadi kesalahan pada query saat menghitung record', 500, $e);

        } catch (Throwable $e) {
            Log::error('Repository Error: Terjadi kesalahan saat menghitung record', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'penyuluh_id' => $penyuluhId,
                'trace' => $e->getTraceAsString(),
            ]);

            throw new Exception('Terjadi kesalahan saat menghitung record', 500, $e);
        }
    }
}

