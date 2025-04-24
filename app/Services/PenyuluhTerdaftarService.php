<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarCustomQueryInterface;
use Illuminate\Support\Facades\Log;

class PenyuluhTerdaftarService
{
    protected CrudInterface $penyuluhRepository;
    protected PenyuluhTerdaftarCustomQueryInterface $penyuluhTerdaftarCustomQuery;

    public function __construct(CrudInterface $penyuluhRepository, PenyuluhTerdaftarCustomQueryInterface $penyuluhTerdaftarCustomQuery)
    {
        $this->penyuluhRepository = $penyuluhRepository;
        $this->penyuluhTerdaftarCustomQuery = $penyuluhTerdaftarCustomQuery;
    }

    public function getAll()
    {
        try {
            return $this->penyuluhRepository->getAll();
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data penyuluh terdaftar', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return null;
        }
    }

    public function getAllWithKecamatan()
    {
        try {
            $penyuluh = $this->penyuluhRepository->getAll();
            return $penyuluh->load('kecamatan');
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data penyuluh terdaftar beserta kecamatan: ' . $th->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            return $this->penyuluhRepository->find($id);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data penyuluh terdaftar berdasarkan id: ' . $th->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            return $this->penyuluhRepository->create($data);
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan data penyuluh terdaftar: ' . $th->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $result = $this->penyuluhRepository->update($id, $data);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Data penyuluh berhasil diperbarui',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data penyuluh gagal diperbarui',
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
                'message' => 'Data penyuluh gagal diperbarui',
                'data' => $data,
            ];
        }
    }

    public function delete($id)
    {
        try {
            return $this->penyuluhRepository->delete($id);
        } catch (\Throwable $th) {
            Log::error('Gagal menghapus data penyuluh terdaftar: ' . $th->getMessage());
        }
    }

    public function getByKecamatanId($id)
    {
        try {
            return $this->penyuluhTerdaftarCustomQuery->getByKecamatanId($id);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data penyuluh terdaftar berdasarkan id kecamatan: ' . $th->getMessage());
        }
    }

    /**
     * Mengambil data penyuluh terdaftar di dinas berdasarkan no hp
     *
     * @param string $phone No Hp penyuluh terdaftar di dinas
     * @return array
     */
    public function getByPhone(string $phone)
    {
        try {
            $penyuluh = $this->penyuluhTerdaftarCustomQuery->getByPhone($phone);

            if (!empty($penyuluh)) {
                return [
                    'success' => true,
                    'message' => 'Berhasil mengambil data penyuluh terdaftar',
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
}
