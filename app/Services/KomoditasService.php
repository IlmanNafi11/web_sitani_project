<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Log;

class KomoditasService
{

    protected CrudInterface $komoditasRepository;

    public function __construct(CrudInterface $komoditasRepository)
    {
        $this->komoditasRepository = $komoditasRepository;
    }

    /**
     * Mengambil semua data komoditas
     *
     * @return array
     */
    public function getAll(): array
    {
        try {
            $komoditas = $this->komoditasRepository->getAll();

            if ($komoditas->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Semua data komoditas berhasil diambil',
                    'data' => $komoditas
                ];
            }

            return [
                'success' => false,
                'message' => 'Data komoditas tidak ditemukan',
                'data' => []
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data komoditas.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data komoditas.',
                'data' => []
            ];
        }
    }

    /**
     * Mengambil data komoditas berdasarkan ID
     *
     * @param string|int $id Id komoditas
     * @return array
     */
    public function getById(string|int $id): array
    {
        try {
            $komoditas = $this->komoditasRepository->getById($id);

            if (!empty($komoditas)) {
                return [
                    'success' => true,
                    'message' => 'Data komoditas ditemukan',
                    'data' => $komoditas
                ];
            }

            return [
                'success' => false,
                'message' => 'Data komoditas tidak ditemukan',
                'data' => []
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data komoditas berdasarkan ID.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data komoditas.',
                'data' => []
            ];
        }
    }

    /**
     * Membuat data komoditas
     *
     * @param array $data Data komoditas
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $komoditas = $this->komoditasRepository->create($data);

            if (!empty($komoditas)) {
                return [
                    'success' => true,
                    'message' => 'Data komoditas berhasil disimpan',
                    'data' => $komoditas
                ];
            }

            return [
                'success' => false,
                'message' => 'Data komoditas gagal disimpan',
                'data' => []
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menyimpan data komoditas.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data komoditas.',
                'data' => []
            ];
        }
    }

    /**
     * Memperbarui data komoditas
     *
     * @param string|int $id Id komoditas
     * @param array $data Data komoditas baru
     * @return array
     */
    public function update(string|int $id, array $data): array
    {
        try {
            $result = $this->komoditasRepository->update($id, $data);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Data komoditas berhasil diperbarui',
                    'data' => $data
                ];
            }

            return [
                'success' => false,
                'message' => 'Data komoditas gagal diperbarui',
                'data' => []
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat memperbarui data komoditas.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal memperbarui data komoditas.',
                'data' => []
            ];
        }
    }

    /**
     * Menghapus data komoditas
     *
     * @param string|int $id Id komoditas
     * @return array
     */
    public function delete(string|int $id): array
    {
        try {
            $result = $this->komoditasRepository->delete($id);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Data komoditas berhasil dihapus',
                    'data' => ['id' => $id]
                ];
            }

            return [
                'success' => false,
                'message' => 'Data komoditas gagal dihapus',
                'data' => []
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menghapus data komoditas.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghapus data komoditas.',
                'data' => []
            ];
        }
    }
}
