<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarRepositoryInterface;
use Illuminate\Support\Facades\Log;

class PenyuluhTerdaftarService
{
    protected CrudInterface $crudRepository;
    protected PenyuluhTerdaftarRepositoryInterface $repository;

    public function __construct(CrudInterface $crudRepository, PenyuluhTerdaftarRepositoryInterface $repository)
    {
        $this->crudRepository = $crudRepository;
        $this->repository = $repository;
    }

    /**
     * Mengambil seluruh data penyuluh terdaftar
     *
     * @param bool $withRelations Default false, set true untuk mengambil data beserta relasi
     * @return array
     */
    public function getAll(bool $withRelations = false): array
    {
        try {
            $penyuluhs = $this->crudRepository->getAll($withRelations);

            if ($penyuluhs->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Berhasil mengambil seluruh data penyuluh terdaftar',
                    'data' => $penyuluhs,
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal mengambil seluruh data penyuluh terdaftar',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data penyuluh terdaftar.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil seluruh data penyuluh terdaftar',
                'data' => [],
            ];
        }
    }

    /**
     * Mengambil seluruh data penyuluh terdaftar beserta kecamatan
     * @deprecated Ganti dengan getAll() dan set param true untuk mengambil data beserta relasi
     * @return array
     */
    public function getAllWithKecamatan(): array
    {
        try {
            $penyuluhs = $this->crudRepository->getAll(true);

            if ($penyuluhs->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Berhasil mengambil seluruh data penyuluh terdaftar beserta kecamatan',
                    'data' => $penyuluhs,
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal mengambil seluruh data penyuluh terdaftar beserta kecamatan',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data penyuluh terdaftar beserta kecamatan.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil seluruh data penyuluh terdaftar beserta kecamatan',
                'data' => [],
            ];
        }
    }

    /**
     * Mengambil data penyuluh terdaftar berdasarkan id
     *
     * @param string|int $id Id penyuluh terdaftar
     * @return array
     */
    public function getById(string|int $id): array
    {
        try {
            $penyuluh = $this->crudRepository->getById($id);

            if (!empty($penyuluh)) {
                return [
                    'success' => true,
                    'message' => 'Berhasil mengambil data penyuluh terdaftar',
                    'data' => $penyuluh
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal mengambil data penyuluh terdaftar',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data penyuluh terdaftar berdasarkan id', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'data' => [
                    'penyuluh_terdaftar_id' => $id,
                ],
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data penyuluh terdaftar berdasarkan id',
                'data' => [],
            ];
        }
    }

    /**
     * Membuat data penyuluh terdaftar
     *
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $peyuluh = $this->crudRepository->create($data);

            if (!empty($peyuluh)) {
                return [
                    'success' => true,
                    'message' => 'Berhasil menyimpan data penyuluh terdaftar',
                    'data' => $peyuluh
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data penyuluh terdaftar',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan data penyuluh terdaftar', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'data' => $data,
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data penyuluh terdaftar',
                'data' => [],
            ];
        }
    }

    /**
     * Memperbarui data penyuluh terdaftar berdasarkan id
     *
     * @param string|int $id Id penyuluh terdaftar
     * @param array $data Data penyuluh terdaftar yang baru
     * @return array
     */
    public function update(string|int $id, array $data): array
    {
        try {
            $result = $this->crudRepository->update($id, $data);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Data penyuluh terdaftar berhasil diperbarui',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data penyuluh terdaftar gagal diperbarui',
                'data' => $data,
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data penyuluh terdaftar', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'data' => [
                    'penyuluh_terdaftar_id' => $id,
                    'data' => $data,
                ],
            ]);

            return [
                'success' => false,
                'message' => 'Data penyuluh terdaftar gagal diperbarui',
                'data' => $data,
            ];
        }
    }

    /**
     * Menghapus data penyuluh terdaftar berdasarkan id
     *
     * @param string|int $id Id penyuluh terdaftar
     * @return array
     */
    public function delete(string|int $id): array
    {
        try {
            $result = $this->crudRepository->delete($id);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Data penyuluh terdaftar berhasil dihapus',
                    'data' => ['id' => $id],
                ];
            }

            return [
                'success' => false,
                'message' => 'Data penyuluh terdaftar gagal dihapus',
                'data' => ['id' => $id],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data penyuluh terdaftar', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'data' => [
                    'id' => $id,
                ],
            ]);

            return [
                'success' => false,
                'message' => 'Data penyuluh gagal diperbarui',
                'data' => ['id' => $id],
            ];
        }
    }

    /**
     * Mengambil data penyuluh terdaftar berdasarkan kecamatan id
     *
     * @param string|int $id Id kecamatan
     * @return array
     */
    public function getByKecamatanId(string|int $id): array
    {
        try {
            $penyuluhs = $this->repository->getByKecamatanId($id);

            if ($penyuluhs->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Data penyuluh terdaftar berdasarkan kecamatan id berhasil diambil',
                    'data' => $penyuluhs,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data penyuluh terdaftar tidak ditemukan pada kecamatan id: ' . $id,
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data penyuluh terdaftar berdasarkan kecamatan id', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'data' => [
                    'kecamatan_id' => $id,
                ],
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data penyuluh terdaftar berdasarkan kecamatan id: ' . $id,
                'data' => ['kecamatan_id' => $id],
            ];
        }
    }

    /**
     * Mengambil data penyuluh terdaftar di dinas berdasarkan no hp
     *
     * @param string $phone No Hp penyuluh terdaftar di dinas
     * @return array
     */
    public function getByPhone(string $phone): array
    {
        try {
            $penyuluh = $this->repository->getByPhone($phone);

            if (!empty($penyuluh)) {
                $penyuluh->makeHidden('kecamatan_id');
                return [
                    'success' => true,
                    'message' => 'Nomor telepon terverifikasi',
                    'data' => $penyuluh,
                ];

            }

            return [
                'success' => false,
                'message' => 'Gagal mengambil data penyuluh terdaftar',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data penyuluh terdaftar dengan no hp ' . $phone, [
                'source' => __METHOD__,
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'data' => ['no_hp' => $phone],
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data penyuluh terdaftar',
                'data' => [],
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
