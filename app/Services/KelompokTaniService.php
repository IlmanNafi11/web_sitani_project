<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\ManyRelationshipManagement;
use Illuminate\Support\Facades\Log;

class KelompokTaniService
{
    protected CrudInterface $kelompokTaniRepository;
    protected ManyRelationshipManagement $relationManager;

    public function __construct(CrudInterface $kelompokTaniRepository, ManyRelationshipManagement $relationManager)
    {
        $this->kelompokTaniRepository = $kelompokTaniRepository;
        $this->relationManager = $relationManager;
    }

    /**
     * Mengambil seluruh data kelompok tani
     *
     * @param bool $withRelations Default false, set true untuk mengambil seluruh data beserta dengan relasi
     * @return array
     */
    public function getAll(bool $withRelations = false): array
    {
        try {
            $kelompokTanis = $this->kelompokTaniRepository->getAll($withRelations);

            if ($kelompokTanis->isNotEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Seluruh data kelompok tani berhasil diambil',
                    'data' => $kelompokTanis,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kelompok tani kosong',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil seluruh data kelompok tani',
                'data' => [],
            ];
        }
    }

    /**
     * Mengambil data kelompok tani beserta relasi
     *
     * @deprecated ganti dengan getAll, dan set param true.
     * @return array|\Illuminate\Database\Eloquent\Collection|void
     */
    public function getAllWithRelations()
    {
        try {
            return $this->kelompokTaniRepository->getAll(true);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data kelompok tani beserta relasi: ' . $th->getMessage());
        }
    }

    /**
     * Mengambil data kelompok tani berdasarkan id
     *
     * @param string|int $id
     * @return array
     */
    public function getById(string|int $id): array
    {
        try {
            $kelompokTani = $this->kelompokTaniRepository->getById($id);

            if (!empty($kelompokTani)) {
                return [
                    'success' => true,
                    'message' => 'Data kelompok tani berhasil diambil',
                    'data' => $kelompokTani,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kelompok tani tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data kelompok tani berdasarkan id.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data kelompok tani berdasarkan id.',
                'data' => [],
            ];
        }
    }

    /**
     * Mengambil data kelompok tani beserta data pivot
     *
     * @deprecated ganti dengan getById()
     * @param string|int $id Id kelompok tani
     * @return array
     */
    public function getByIdWithPivot(string|int $id): array
    {
        try {
            $kelompokTani = $this->kelompokTaniRepository->getById($id);
            if (!empty($kelompokTani)) {
                return [
                    'success' => true,
                    'message' => 'Data kelompok tani berhasil diambil',
                    'data' => $kelompokTani,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kelompok tani tidak ditemukan',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data kelompok tani beserta pivot table.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil data kelompok tani beserta pivot table.',
                'data' => [],
            ];
        }
    }

    /**
     * Membuat data kelompok tani
     *
     * @param array $data Data kelompok tani
     * @return array
     */
    public function create(array $data):array
    {
        try {
            $kelompokTani = $this->kelompokTaniRepository->create($data);

            if (!empty($kelompokTani)) {
                $this->relationManager->attach($kelompokTani, $data['penyuluh_terdaftar_id']);

                return [
                    'success' => true,
                    'message' => 'Data kelompok tani berhasil disimpan',
                    'data' => $kelompokTani,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kelompok tani gagal disimpan',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data kelompok tani.',
                'data' => [],
            ];
        }
    }

    /**
     * Memperbarui data kelompok tani
     *
     * @param string|int $id Id kelompok tani
     * @param array $data Data kelompok tani yang baru
     * @return array
     */
    public function update(string|int $id, array $data): array
    {
        try {
            $kelompokTani = $this->kelompokTaniRepository->update($id, [
                "nama" => $data["nama"],
                "desa_id" => $data["desa_id"],
                "kecamatan_id" => $data["kecamatan_id"],
            ]);

            if (!empty($kelompokTani)) {
                $this->relationManager->sync($kelompokTani, $data['penyuluh_terdaftar_id']);
                return [
                    'success' => true,
                    'message' => 'Data kelompok tani berhasil diperbarui',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kelompok tani gagal diperbarui',
                'data' => [],
            ];
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal memperbarui data kelompok tani.',
                'data' => [],
            ];
        }
    }

    /**
     * Menghapus data kelompok tani
     *
     * @param string|int $id Id kelompok tani
     * @return array
     */
    public function delete(string|int $id): array
    {
        try {
            $kelompokTani = $this->kelompokTaniRepository->delete($id);
            if (!empty($kelompokTani)) {
                $this->relationManager->detach($kelompokTani);

                return [
                    'success' => true,
                    'message' => 'Data kelompok tani berhasil dihapus',
                    'data' => $kelompokTani,
                ];
            }

            return [
                'success' => false,
                'message' => 'Data kelompok tani gagal dihapus',
                'data' => [],
            ];

        } catch (\Throwable $th) {
            Log::error('Gagal menghapus data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghapus data kelompok tani.',
                'data' => [],
            ];
        }
    }
}
