<?php
namespace App\Services;

use App\Repositories\Interfaces\BibitRepositoryInterface;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Log;

class BibitService {
    protected CrudInterface $crudRepository;
    protected BibitRepositoryInterface $repository;

    public function __construct(CrudInterface $crudRepository, BibitRepositoryInterface $repository)
    {
        $this->crudRepository = $crudRepository;
        $this->repository = $repository;
    }

    /**
     * Mengambil seluruh data bibit
     *
     * @param bool $withRelations Default false, set true untuk mengambil data beserta relasi
     * @return array
     */
    public function getAll(bool $withRelations = false): array
    {
        try {
            $bibits = $this->crudRepository->getAll($withRelations);
            if ($bibits->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Semua data bibit berhasil diambil',
                    'data' => $bibits
                ];
            }

            return [
                'success' => false,
                'message' => 'Data bibit tidak ditemukan',
                'data' => []
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data bibit.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data bibit.',
                'data' => []
            ];
        }
    }

    /**
     * Mengambil data bibit berdasarkan id
     *
     * @param string|int $id Id bibit
     * @return array
     */
    public function getById(string|int $id): array
    {
        try {
            $bibit = $this->crudRepository->getById($id);

            if (!empty($bibit)) {
                return [
                    'success' => true,
                    'message' => 'Data bibit berhasil diambil',
                    'data' => $bibit,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data bibit tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data bibit berdasarkan id.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data bibit dengan id: ' . $id,
                'data' => []
            ];
        }
    }

    /**
     * Mengambil data bibit beserta komoditas
     *
     * @deprecated Gunakan getAll() dan set true
     * @return array
     */
    public function getAllWithKomoditas(): array
    {
        try {
            $bibit = $this->crudRepository->getAll(true);

            if ($bibit->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Semua data bibit dan komoditas berhasil diambil',
                    'data' => $bibit
                ];
            }

            return [
                'success' => false,
                'message' => 'Data bibit tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data bibit beserta komoditas.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data bibit beserta komoditas.',
                'data' => []
            ];
        }
    }

    /**
     * Membuat data bibit baru
     *
     * @param array $data Data bibit baru
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $bibit = $this->crudRepository->create($data);

            if (!empty($bibit)) {
                return [
                    'success' => true,
                    'message' => 'Data bibit berhasil disimpan',
                    'data' => $bibit,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data bibit gagal disimpan',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menyimpan data bibit.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data bibit.',
                'data' => []
            ];
        }
    }

    /**
     * Memperbarui data bibit
     *
     * @param string|int $id Id bibit
     * @param array $data Data bibit yang baru
     * @return array
     */
    public function update(string|int $id, array $data): array
    {
        try {
            $result = $this->crudRepository->update($id, $data);

            if($result) {
                return [
                    'success' => true,
                    'message' => 'Data bibit berhasil diupdate',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data bibit gagal diperbarui',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat memperbarui data bibit.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal memperbarui data bibit.',
                'data' => []
            ];
        }
    }

    /**
     * Menghapus data bibit
     *
     * @param string|int $id Id bibit
     * @return array
     */
    public function delete(string|int $id): array
    {
        try {
            $result = $this->crudRepository->delete($id);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Data bibit berhasil dihapus',
                    'data' => ['id' => $id],
                ];
            }

            return [
                'success' => false,
                'message' => 'Data bibit gagal dihapus',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menghapus data bibit.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghapus data bibit.',
                'data' => []
            ];
        }
    }

    public function calculateTotal(): int
    {
        try {
            return $this->repository->calculateTotal();
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menghitung total record data', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 0;
        }
    }
}
