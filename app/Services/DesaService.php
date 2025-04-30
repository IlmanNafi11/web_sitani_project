<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\DesaRepositoryInterface;

class DesaService
{
    protected CrudInterface $desaRepository;
    protected DesaRepositoryInterface $desaCustomQuery;

    public function __construct(CrudInterface $desaRepository, DesaRepositoryInterface $desaCustomQuery)
    {
        $this->desaRepository = $desaRepository;
        $this->desaCustomQuery = $desaCustomQuery;
    }

    /**
     * Mengambil seluruh data desa
     *
     * @param bool $withRelations Default false, set true untuk mengambil data beserta relasinya
     * @return array
     */
    public function getAll(bool $withRelations = false): array
    {
        try {
            $desas = $this->desaRepository->getAll($withRelations);

            if ($desas->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Semua data desa berhasil diambil',
                    'data' => $desas,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data desa tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil seluruh data desa.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data desa.',
                'data' => [],
            ];
        }
    }

    /**
     * Mengambil seluruh data desa beserta kecamatannya
     *
     * @deprecated Ganti dengan getAll() dan set param true.
     * @return array
     */
    public function getAllWithKecamatan(): array
    {
        try {
            $desa = $this->desaRepository->getAll(true);

            if ($desa->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Data desa dan kecamatan berhasil diambil',
                    'data' => $desa,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data desa tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data desa dengan kecamatan.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data desa dengan kecamatan.',
                'data' => [],
            ];
        }
    }

    /**
     * Membuat data desa baru
     *
     * @param array $data Data desa baru
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $desa = $this->desaRepository->create($data);

            if (!empty($desa)) {
                return [
                    'success' => true,
                    'message' => 'Data desa berhasil disimpan',
                    'data' => $desa,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data desa gagal disimpan',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan data desa.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data desa.',
                'data' => [],
            ];
        }
    }

    /**
     * Mengambil data desa berdasarkan id
     *
     * @param string|int $id Id desa
     * @return array
     */
    public function getById(string|int $id): array
    {
        try {
            $desa = $this->desaRepository->getById($id);

            if (!empty($desa)) {
                return [
                    'success' => true,
                    'message' => 'Data desa berhasil diambil',
                    'data' => $desa,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data desa tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data desa berdasarkan id.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data desa.',
                'data' => [],
            ];
        }
    }

    /**
     * Memperbarui data desa
     *
     * @param string|int $id Id desa
     * @param array $data
     * @return array
     */
    public function update(string|int $id, array $data): array
    {
        try {
            $updated = $this->desaRepository->update($id, $data);

            if ($updated) {
                return [
                    'success' => true,
                    'message' => 'Data desa berhasil diperbarui',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data desa gagal diperbarui',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui data desa.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data desa.',
                'data' => [],
            ];
        }
    }

    /**
     * Menghapus data desa
     *
     * @param string|int $id Id desa
     * @return array
     */
    public function delete(string|int $id): array
    {
        try {
            $deleted = $this->desaRepository->delete($id);

            if ($deleted) {
                return [
                    'success' => true,
                    'message' => 'Data desa berhasil dihapus',
                    'data' => ['id' => $id],
                ];
            }

            return [
                'success' => false,
                'message' => 'Data desa gagal dihapus',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus data desa.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data desa.',
                'data' => [],
            ];
        }
    }

    /**
     * Mengambil data desa berdasarkan kecamatan id,
     * Gunakan ketika butuh data seluruh data desa pada kecamatan tertentu
     *
     * @param string|int $id Id kecamatan
     * @return array
     */
    public function getByKecamatanId(string|int $id): array
    {
        try {
            $desas = $this->desaCustomQuery->getByKecamatanId($id);

            if ($desas->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Data desa berdasarkan kecamatan berhasil diambil',
                    'data' => $desas,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data desa untuk kecamatan ini tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data desa berdasarkan kecamatan id.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data desa berdasarkan kecamatan.',
                'data' => [],
            ];
        }
    }
}
