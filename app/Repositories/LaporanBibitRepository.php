<?php

namespace App\Repositories;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\LaporanKondisi;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\LaporanRepositoryInterface;
use App\Trait\LoggingError;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Throwable;

class LaporanBibitRepository implements CrudInterface, LaporanRepositoryInterface
{
    use LoggingError;

    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = LaporanKondisi::query();
            if ($withRelations) {
                $query->with([
                    'kelompokTani' => fn($q) => $q->select(['id', 'nama']),
                    'komoditas' => fn($q) => $q->select(['id', 'nama', 'musim']),
                    'penyuluh' => fn($q) => $q->select(['id', 'penyuluh_terdaftar_id'])->with([
                        'penyuluhTerdaftar' => fn($q2) => $q2->select(['id', 'nama', 'no_hp']),
                    ]),
                    'laporanKondisiDetail' => fn($q) => $q->select(['id', 'laporan_kondisi_id', 'luas_lahan', 'estimasi_panen', 'jenis_bibit', 'foto_bibit', 'lokasi_lahan']),
                ]);
            }
            return $query->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Unexpected repository error in getAll.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            $query = LaporanKondisi::query();
            $query->with([
                'kelompokTani' => fn($q) => $q->select(['id', 'nama', 'desa_id', 'kecamatan_id'])->with([
                    'desa' => fn($q2) => $q2->select(['id', 'nama']),
                    'kecamatan' => fn($q2) => $q2->select(['id', 'nama']),
                ]),
                'komoditas' => fn($q) => $q->select(['id', 'nama', 'musim']),
                'penyuluh' => fn($q) => $q->select(['id', 'penyuluh_terdaftar_id'])->with([
                    'penyuluhTerdaftar' => fn($q2) => $q2->select(['id', 'nama', 'no_hp']),
                ]),
                'laporanKondisiDetail' => fn($q) => $q->select(['id', 'laporan_kondisi_id', 'luas_lahan', 'estimasi_panen', 'jenis_bibit', 'foto_bibit', 'lokasi_lahan']),
            ]);

            return $query->find($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id]);
            throw new DataAccessException('Unexpected repository error in getById.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function create(array $data): ?Model
    {
        try {
            $model = LaporanKondisi::create($data);
            if (!$model) {
                throw new DataAccessException('Failed to create LaporanKondisi model.');
            }
            return $model;
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            throw $e;
        } catch (DataAccessException $e) {
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['data' => $data]);
            throw new DataAccessException('Unexpected repository error during create.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            $model = LaporanKondisi::findOrFail($id);
            $result = $model->update($data);

            if (!$result) {
                $this->LogGeneralException(new \Exception("LaporanKondisi update returned false."), ['id' => $id, 'data' => $data]);
            }

            return (bool)$result;
        } catch (ModelNotFoundException $e) {
            $this->LogNotFoundException($e, ['id' => $id]);
            throw new ResourceNotFoundException("LaporanKondisi with ID {$id} not found for update.", 0, $e);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id, 'data_baru' => $data]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id, 'data_baru' => $data]);
            throw new DataAccessException('Unexpected repository error during update.', 0, $e);
        }
    }

    /**
     * @throws ResourceNotFoundException
     * @throws DataAccessException
     */
    public function delete(string|int $id): Model|bool|int
    {
        try {
            $model = LaporanKondisi::findOrFail($id);
            $result = $model->delete();

            if (!$result) {
                $this->LogGeneralException(new \Exception("LaporanKondisi delete returned false."), ['id' => $id]);
            }

            return (bool)$result;
        } catch (ModelNotFoundException $e) {
            $this->LogNotFoundException($e, ['id' => $id]);
            throw new ResourceNotFoundException("LaporanKondisi with ID {$id} not found for deletion.", 0, $e);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['id' => $id]);
            throw new DataAccessException('Unexpected repository error during delete.', 0, $e);
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
            $this->LogSqlException($e);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Unexpected repository error in getByPenyuluhId.', 0, $e);
        }
    }

    public function calculateTotal(): int
    {
        try {
            return LaporanKondisi::count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e);
            throw new DataAccessException('Unexpected repository error in calculateTotal.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function getLaporanStatusCounts(?int $penyuluhId = null): array
    {
        $statusCounts = [
            'rejected' => 0,
            'approved' => 0,
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
                0 => 'rejected',
                1 => 'approved',
                2 => 'pending',
            ];

            foreach ($statusMap as $statusValue => $statusName) {
                $statusCounts[$statusName] = $rawCounts[$statusValue] ?? 0;
            }
            return $statusCounts;
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['penyuluh_id' => $penyuluhId]);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, ['penyuluh_id' => $penyuluhId]);
            throw new DataAccessException('Unexpected repository error in getLaporanStatusCounts.', 0, $e);
        }
    }
}

