<?php

namespace App\Services\Api;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\LaporanKondisiDetail;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\LaporanRepositoryInterface;
use App\Services\Interfaces\LaporanBibitApiServiceInterface;
use App\Trait\LoggingError;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LaporanBibitApiService implements LaporanBibitApiServiceInterface
{
    use LoggingError;

    protected CrudInterface $crudRepository;
    protected LaporanRepositoryInterface $laporanRepository;

    public function __construct(CrudInterface $crudRepository, LaporanRepositoryInterface $laporanRepository)
    {
        $this->crudRepository = $crudRepository;
        $this->laporanRepository = $laporanRepository;
    }

    /**
     * @throws Throwable
     * @throws DataAccessException
     */
    public function create(array $data): Model
    {
        DB::beginTransaction();
        try {
            $laporan = $this->crudRepository->create([
                'kelompok_tani_id' => $data['kelompok_tani_id'],
                'komoditas_id' => $data['komoditas_id'],
                'penyuluh_id' => $data['penyuluh_id'],
                'status' => $data['status'] ?? '2',
            ]);

            if ($laporan === null) {
                throw new DataAccessException('Failed to create Laporan Bibit data in repository.');
            }
            $file = $data['foto_bibit'] ?? null;

            if ($file && $file->isValid()) {
                try {
                    $now = date('Y-m-d');
                    $waktuPanen = Carbon::parse($data['estimasi_panen'])->format('Y-m-d');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('foto_bibit/' . $data['kelompok_tani_id'] . '/' . $now, $filename, 'public');

                    LaporanKondisiDetail::create([
                        'laporan_kondisi_id' => $laporan->id,
                        'luas_lahan' => $data['luas_lahan'],
                        'estimasi_panen' => $waktuPanen,
                        'jenis_bibit' => $data['jenis_bibit'],
                        'foto_bibit' => $path,
                        'lokasi_lahan' => $data['lokasi_lahan'],
                    ]);

                } catch (Throwable $fileError) {
                    DB::rollBack();
                    if (isset($path) && Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    throw new DataAccessException('Failed to upload file or save report detail.', 0, $fileError);
                }
            }
            DB::commit();

            $laporan->load('laporanKondisiDetail');


            return $laporan;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new DataAccessException('Database error during laporan bibit creation transaction.', 0, $e);
        } catch (DataAccessException $e) {
            DB::rollBack();
            throw $e;
        } catch (Throwable $e) {
            DB::rollBack();
            throw new DataAccessException('Unexpected error during laporan bibit creation transaction.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function getByPenyuluhId(string|int $penyuluhId): Collection
    {
        try {
            $conditions = ['penyuluh_id' => $penyuluhId];
            $relations = ['penyuluh.penyuluhTerdaftar', 'komoditas', 'laporanKondisiDetail', 'kelompokTani.desa.kecamatan'];
            $laporan = $this->laporanRepository->getByPenyuluhId($conditions, $relations);
            if ($laporan->isEmpty()) {
                throw new ResourceNotFoundException('Laporan Bibit tidak ditemukan');
            }
            return $laporan;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while fetching Laporan Bibit by Penyuluh ID.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while fetching Laporan Bibit by Penyuluh ID.', 0, $e);
        }
    }

    /**
     * @throws DataAccessException
     */
    public function getLaporanStatusCounts(string|int $penyuluhId): array
    {
        try {
            return $this->laporanRepository->getLaporanStatusCounts($penyuluhId);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error while calculating report status counts.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Unexpected error while calculating report status counts.', 0, $e);
        }
    }
}
