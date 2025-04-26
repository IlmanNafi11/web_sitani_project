<?php

namespace App\Services;

use App\Models\LaporanKondisi;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\LaporanCustomQueryInterface;
use Illuminate\Support\Facades\Log;

class LaporanBibitService
{

    protected CrudInterface $repository;
    protected LaporanCustomQueryInterface $query;

    public function __construct(CrudInterface $repository, LaporanCustomQueryInterface $query)
    {
        $this->repository = $repository;
        $this->query = $query;
    }

    /**
     * Mengambil seluruh data laporan bibit
     *
     * @return array
     */
    public function getAll(bool $withRelations = false): array
    {
        try {
            $laporans = $this->repository->getAll($withRelations);

            if ($laporans->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Berhasil mengambil semua data laporan bibit',
                    'data' => $laporans
                ];

            }

            return [
                'success' => false,
                'message' => 'Gagal mengambil semua data laporan bibit',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data laporan bibit.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil seluruh data laporan bibit',
                'data' => [],
            ];
        }
    }

    /**
     * Mengambil data laporan bibit berdasarkan id
     *
     * @param string|int $id Id laporan bibit
     * @return array
     */
    public function getById(string|int $id): array
    {
        try {
            $laporan = $this->repository->getById($id);
            if (!empty($laporan)) {
                return [
                    'success' => true,
                    'message' => 'Berhasil mengambil data laporan bibit',
                    'data' => $laporan
                ];
            }

            return [
                'success' => false,
                'message' => 'Laporan bibit tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data laporan bibit.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data laporan bibit',
                'data' => [],
            ];
        }
    }

    /**
     * Membuat laporan bibit
     *
     * @param array $data data laporan bibit
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $laporan = $this->repository->create([
                'kelompok_tani_id' => $data['kelompok_tani_id'],
                'komoditas_id' => $data['komoditas_id'],
                'penyuluh_id' => $data['penyuluh_id'],
                'status' => '2',
            ]);

            if (!empty($laporan)) {
                return [
                    'success' => true,
                    'message' => 'Berhasil menyimpan data laporan bibit',
                    'data' => $laporan
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data laporan bibit',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan data laporan bibit.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data laporan bibit',
                'data' => [],
            ];
        }
    }

    /**
     * Memperbarui data laporan bibit
     *
     * @param string|int $id Id laporan bibit
     * @param array $data Data laporan bibit yang baru
     * @return array
     */
    public function update(string|int $id, array $data): array
    {
        try {
            $result = $this->repository->update($id, $data);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Berhasil memperbarui data laporan bibit',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal memperbarui data laporan bibit',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data laporan bibit.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal memperbarui data laporan bibit',
                'data' => [],
            ];
        }
    }

    /**
     * Menghapus data laporan bibit
     *
     * @param string|int $id Id laporan bibit
     * @return array
     */
    public function delete(string|int $id): array
    {
        try {
            $result = $this->repository->delete($id);
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Berhasil menghapus data laporan bibit',
                    'data' => ['id' => $id],
                ];
            }
            return [
                'success' => false,
                'message' => 'Gagal menghapus data laporan bibit',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal menghapus data laporan bibit.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghapus data laporan bibit',
                'data' => [],
            ];
        }
    }

    public function getByPenyuluhId(string|int $id): array
    {
        try {
            $conditions = ['penyuluh_id' => $id];
            $relations = ['penyuluh', 'penyuluh.penyuluhTerdaftar', 'komoditas', 'laporanKondisiDetail',];
            $result = $this->query->getByPenyuluhId($conditions, $relations);
            if ($result->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Laporan bibit ditemukan',
                    'data' => $result,
                ];
            }
            return [
                'success' => false,
                'message' => 'Laporan bibit tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Terjadi kesalahan saat mengambil data laporan bibit.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data laporan bibit',
                'data' => [],
            ];
        }
    }
}
