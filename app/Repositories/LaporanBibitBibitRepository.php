<?php

namespace App\Repositories;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\LaporanKondisi;
use App\Models\LaporanKondisiDetail;
use App\Repositories\Interfaces\LaporanBibitRepositoryInterface;
use App\Trait\LoggingError;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Throwable;

class LaporanBibitBibitRepository implements LaporanBibitRepositoryInterface
{
    use LoggingError;

    /**
     * @inheritDoc
     * @param bool $withRelations
     * @return Collection|array
     * @throws DataAccessException
     */
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
     * @inheritDoc
     * @param string|int $id
     * @return Model|null
     * @throws DataAccessException
     */
    public function getById(string|int $id): ?Model
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
                'laporanKondisiDetail' => fn($q) => $q->select(['id', 'laporan_kondisi_id', 'luas_lahan', 'estimasi_panen', 'jenis_bibit', 'foto_bibit', 'lokasi_lahan', 'path_foto_lokasi']),
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
     * @inheritDoc
     * @param array $data
     * @return Model|null
     * @throws DataAccessException
     */
    public function create(array $data): ?Model
    {
        try {
            return LaporanKondisi::create($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, $data);
            throw new DataAccessException('Unexpected repository error during create.', 0, $e);
        }
    }

    /**
     * @inheritDoc
     * @param string|int $id
     * @param array $data
     * @return bool|int
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function update(string|int $id, array $data): bool|int
    {
        try {
            $model = LaporanKondisi::findOrFail($id);
            $result = $model->update($data);

            if (!$result) {
                $this->LogGeneralException(new \Exception("LaporanKondisi update returned false."), ['id' => $id, 'data' => $data]);
            }

            return $result;
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
     * @inheritDoc
     * @param string|int $id
     * @return bool|int
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function delete(string|int $id): bool|int
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

    /**
     * @inheritDoc
     * @param array $conditions
     * @param array $relations
     * @return Collection|array
     * @throws DataAccessException
     */
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

    /**
     * @inheritDoc
     * @return int
     * @throws DataAccessException
     */
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
     * @inheritDoc
     * @param int|null $penyuluhId
     * @return array
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

    /**
     * @param LaporanKondisi $laporan
     * @param array $data
     * @inheritDoc
     * @throws DataAccessException
     */
    public function insertDetailLaporan(array $data): ?Model
    {
        try {
            return LaporanKondisiDetail::create([
                'laporan_kondisi_id' => $data['laporan_id'],
                'luas_lahan' => $data['luas_lahan'],
                'estimasi_panen' => $data['estimasi_panen'],
                'jenis_bibit' => $data['jenis_bibit'],
                'foto_bibit' => $data['path_bibit'],
                'lokasi_lahan' => $data['lokasi_lahan'],
                'path_foto_lokasi' => $data['path_lokasi'],
            ]);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            throw $e;
        } catch (Throwable $e) {
            $this->LogGeneralException($e, $data );
            throw new DataAccessException('Terjadi kesalahan tak terduga saat menyimpan detail laporan.', 0, $e);
        }
    }
}

