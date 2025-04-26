<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Log;
use Throwable;

class PenyuluhService
{
    protected CrudInterface $repository;

    /**
     * @param CrudInterface $repository
     */
    public function __construct(CrudInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Mengambil semua data penyuluh.
     *
     * @return array Data penyuluh
     */
    public function getAll(): array
    {
        try {
            $penyuluhs = $this->repository->getAll();

            if ($penyuluhs->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Data penyuluh berhasil diambil',
                    'data' => $penyuluhs,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data penyuluh gagal diambil',
                'data' => []
            ];

        } catch (Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data penyuluh.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data penyuluh.',
                'data' => []
            ];
        }
    }

    /**
     * Mengambil data penyuluh berdasarkan ID.
     *
     * @param string|int $id ID Penyuluh
     * @return array
     */
    public function find(string|int $id): array
    {
        try {
            $penyuluh = $this->repository->getById($id);

            if (!empty($penyuluh)) {
                return [
                    'success' => true,
                    'message' => 'Data penyuluh berhasil diambil',
                    'data' => $penyuluh,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data penyuluh dengan id ' . $id . ' tidak ditemukan.',
                'data' => [],
            ];
        } catch (Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data penyuluh berdasarkan ID.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'id_penyuluh' => $id,
                ],
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data penyuluh.',
                'data' => [],
            ];
        }
    }

    /**
     * Membuat data penyuluh baru.
     *
     * @param array $data Data penyuluh
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $penyuluh = $this->repository->create($data);

            if (!empty($penyuluh)) {
                $penyuluh->makeHidden(['created_at', 'updated_at', 'user_id', 'penyuluh_terdaftar_id']);
                return [
                    'success' => true,
                    'message' => 'Data penyuluh berhasil disimpan',
                    'data' => $penyuluh,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data penyuluh gagal disimpan',
                'data' => [],
            ];

        } catch (Throwable $e) {
            Log::error('Terjadi kesalahan saat membuat data penyuluh.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat registrasi.',
                'data' => [],
            ];
        }
    }

    /**
     * Memperbarui data penyuluh berdasarkan ID.
     *
     * @param string|int $id ID Penyuluh
     * @param array $data Data Penyuluh
     * @return array
     */
    public function update(string|int $id, array $data): array
    {
        try {
            $updated = $this->repository->update($id, $data);

            if ($updated) {
                return [
                    'success' => true,
                    'message' => 'Data penyuluh berhasil diperbarui.',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal mengupdate data penyuluh.',
                'data' => [],
            ];
        } catch (Throwable $e) {
            Log::error('Terjadi kesalahan saat memperbarui data penyuluh.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'penyuluh_id' => $id,
                    'penyuluh' => $data,
                ],
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate data penyuluh.',
                'data' => [],
            ];
        }
    }

    /**
     * Menghapus data penyuluh berdasarkan ID.
     *
     * @param int $id
     * @return array
     */
    public function delete(int $id): array
    {
        try {
            $deleted = $this->repository->delete($id);

            if ($deleted) {
                return [
                    'success' => true,
                    'message' => 'Data penyuluh berhasil dihapus.',
                    'data' => [
                        'penyuluh_id' => $id,
                    ]
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal menghapus data penyuluh.',
                'data' => [],
            ];
        } catch (Throwable $e) {
            Log::error('Terjadi kesalahan saat menghapus data penyuluh.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'penyuluh_id' => $id,
                ]
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data penyuluh.',
                'data' => [],
            ];
        }
    }
}
