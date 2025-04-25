<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Log;

class AdminService
{
    protected CrudInterface $repository;

    public function __construct(CrudInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Mengambil seluruh data admin
     *
     * @return array
     */
    public function getAll(): array
    {
        try {
            $admins = $this->repository->getAll(true);
            if ($admins->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Data admin berhasil diambil',
                    'data' => $admins,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data admin gagal diambil',
                'data' => $admins,
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data admin.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data admin.',
                'data' => []
            ];
        }
    }

    /**
     * Mengambil data admin berdasarkan id
     *
     * @param string|int $id Id admin
     * @return array
     */
    public function getById(string|int $id): array
    {
        try {
            $admin = $this->repository->getById($id);
            if (!empty($admin)) {
                return [
                    'success' => true,
                    'message' => 'Data admin berhasil diambil',
                    'data' => $admin,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data admin gagal diambil',
                'data' => $admin,
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat mengambil data admin berdasarkan id.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data admin.',
                'data' => []
            ];
        }
    }

    /**
     * Membuat data admin baru
     *
     * @param array $data Data baru
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $dt = [
                'email' => $data['email'],
                'nama' => $data['nama'],
                'no_hp' => $data['no_hp'],
                'alamat' => $data['alamat'],
                'password' => 'sitani',
                'role' => $data['role'],
                'is_password_set' => false,
            ];

            $admin = $this->repository->create($dt);

            if (!empty($admin)) {
                return [
                    'success' => true,
                    'message' => 'Data admin berhasil disimpan',
                    'data' => $admin,
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data admin.',
                'data' => []
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menyimpan data admin.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data admin.',
                'data' => []
            ];
        }
    }

    /**
     * Memperbarui data admin berdasarkan id
     *
     * @param string|int $id Id admin
     * @param array $data Data baru
     * @return array
     */
    public function update(string|int $id, array $data): array
    {
        try {
            $admin = $this->repository->update($id, $data);

            if ($admin) {
                return [
                    'success' => true,
                    'message' => 'Data admin berhasil diperbarui',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal memperbarui data admin.',
                'data' => []
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat memperbarui data admin.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal memperbarui data admin.',
                'data' => []
            ];
        }
    }

    /**
     * Menghapus data admin berdasarkan id
     *
     * @param string|int $id Id admin
     * @return array
     */
    public function delete(string|int $id): array
    {
        try {
            $admin = $this->repository->delete($id);

            if ($admin) {
                return [
                    'success' => true,
                    'message' => 'Data admin berhasil dihapus',
                    'id' => $id,
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal menghapus data admin.',
                'data' => []
            ];
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan saat menghapus data admin.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghapus data admin.',
                'data' => []
            ];
        }
    }
}
