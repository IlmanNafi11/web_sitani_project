<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Log;

class KecamatanService
{
    protected CrudInterface $kecamatanRepository;

    public function __construct(CrudInterface $kecamatanRepository)
    {
        $this->kecamatanRepository = $kecamatanRepository;
    }

    /**
     * Mengambil seluruh data kecamatan
     *
     * @return array
     */
    public function getAll(): array
    {
        try {
            $kecamatans = $this->kecamatanRepository->getAll();

            if ($kecamatans->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Data kecamatan berhasil diambil.',
                    'data' => $kecamatans,
                ];
            }

            return [
                'success' => false,
                'message' => 'Tidak ada data kecamatan yang ditemukan.',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil seluruh data kecamatan.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data kecamatan.',
                'data' => [],
            ];
        }
    }

    /**
     * Mengambil data kecamatan berdasarkan ID
     *
     * @param string|int $id
     * @return array
     */
    public function getById(string|int $id): array
    {
        try {
            $kecamatan = $this->kecamatanRepository->getById($id);

            if (!empty($kecamatan)) {
                return [
                    'success' => true,
                    'message' => 'Data kecamatan berhasil ditemukan.',
                    'data' => $kecamatan,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kecamatan tidak ditemukan.',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data kecamatan berdasarkan ID.', [
                'source' => __METHOD__,
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data kecamatan.',
                'data' => [],
            ];
        }
    }

    /**
     * Menyimpan data kecamatan baru
     *
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $kecamatan = $this->kecamatanRepository->create($data);

            if (!empty($kecamatan)) {
                return [
                    'success' => true,
                    'message' => 'Data kecamatan berhasil disimpan.',
                    'data' => $kecamatan,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kecamatan gagal disimpan.',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan data kecamatan.', [
                'source' => __METHOD__,
                'data' => $data,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data kecamatan.',
                'data' => [],
            ];
        }
    }

    /**
     * Memperbarui data kecamatan berdasarkan ID
     *
     * @param string|int $id
     * @param array $data
     * @return array
     */
    public function update(string|int $id, array $data): array
    {
        try {
            $result = $this->kecamatanRepository->update($id, $data);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Data kecamatan berhasil diperbarui.',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kecamatan gagal diperbarui.',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui data kecamatan.', [
                'source' => __METHOD__,
                'id' => $id,
                'data' => $data,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data kecamatan.',
                'data' => [],
            ];
        }
    }

    /**
     * Menghapus data kecamatan berdasarkan ID
     *
     * @param string|int $id
     * @return array
     */
    public function delete(string|int $id): array
    {
        try {
            $result = $this->kecamatanRepository->delete($id);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Data kecamatan berhasil dihapus.',
                    'data' => ['id' => $id],
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kecamatan gagal dihapus.',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus data kecamatan.', [
                'source' => __METHOD__,
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data kecamatan.',
                'data' => [],
            ];
        }
    }
}
