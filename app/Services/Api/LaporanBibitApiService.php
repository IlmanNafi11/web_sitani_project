<?php

namespace App\Services\Api;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\LaporanKondisiDetail;
use App\Repositories\Interfaces\LaporanBibitRepositoryInterface;
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

    protected LaporanBibitRepositoryInterface $repository;

    public function __construct(LaporanBibitRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     * @param array $data
     * @return Model
     * @throws DataAccessException
     * @throws Throwable
     */
    public function create(array $data): Model
    {
        DB::beginTransaction();
        try {
            $laporan = $this->repository->create([
                'kelompok_tani_id' => $data['kelompok_tani_id'],
                'komoditas_id' => $data['komoditas_id'],
                'penyuluh_id' => $data['penyuluh_id'],
                'status' => $data['status'] ?? '2',
            ]);

            if ($laporan === null) {
                throw new DataAccessException('Gagal menyimpan laporan bibit di repository.');
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
                    throw new DataAccessException('Gagal menyimpan detail laporan bibit.', 0, $fileError);
                }
            }
            DB::commit();

            $laporan->load('laporanKondisiDetail');


            return $laporan;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new DataAccessException('Database error saat menyimpan data laporan bibit.', 0, $e);
        } catch (DataAccessException $e) {
            DB::rollBack();
            throw $e;
        } catch (Throwable $e) {
            DB::rollBack();
            throw new DataAccessException('Terjadi kesalahan tidak terduga saat menyimpan data laporan bibit.', 0, $e);
        }
    }

    /**
     * @inheritDoc
     * @param string|int $penyuluhId
     * @return Collection
     * @throws DataAccessException
     * @throws ResourceNotFoundException
     */
    public function getByPenyuluhId(string|int $penyuluhId): Collection
    {
        try {
            $conditions = ['penyuluh_id' => $penyuluhId];
            $relations = ['penyuluh.penyuluhTerdaftar', 'komoditas', 'laporanKondisiDetail', 'kelompokTani.desa.kecamatan'];
            $laporan = $this->repository->getByPenyuluhId($conditions, $relations);
            if ($laporan->isEmpty()) {
                throw new ResourceNotFoundException('Laporan Bibit tidak ditemukan');
            }
            return $laporan;
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat fetch data laporan bibit berdasarkan penyuluh id.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tidak terduga saat fetch data laporan bibit berdasarkan penyuluh id.', 0, $e);
        }
    }

    /**
     * @inheritDoc
     * @param string|int|null $penyuluhId
     * @return array
     * @throws DataAccessException
     */
    public function getLaporanStatusCounts(string|int|null $penyuluhId): array
    {
        try {
            return $this->repository->getLaporanStatusCounts($penyuluhId);
        } catch (QueryException $e) {
            throw new DataAccessException('Database error saat menghitung total laporan bibit berdasarkan statusnya.', 0, $e);
        } catch (Throwable $e) {
            throw new DataAccessException('Terjadi kesalahan tidak terduga saat menghitung total laporan bibit berdasarkan statusnya.', 0, $e);
        }
    }
}
