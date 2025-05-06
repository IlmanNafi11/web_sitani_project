<?php

namespace App\Services;

use App\Repositories\Interfaces\Base\BaseRepositoryInterface;
use Illuminate\Support\Facades\Log;

class LaporanBantuanAlatService
{
    protected BaseRepositoryInterface $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        try {
            return $this->repository->getAll(true);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data laporan bantuan alat: ' . $th->getMessage());
        }

        return collect([]);
    }

    public function getById(int|string $id)
    {
        try {
            return $this->repository->getById($id);
        } catch (\Throwable $th) {
            Log::error("Gagal mengambil laporan bantuan alat ID $id: " . $th->getMessage());
        }

        return null;
    }

    public function create(array $data)
    {
        try {
            return $this->repository->create([
                'kelompok_tani_id' => $data['kelompok_tani_id'],
                'penyuluh_id' => $data['penyuluh_id'],
                'status' => '2',
                'alat_diminta' => $data['alat_diminta'],
                'path_proposal' => $data['path_proposal'],
            ]);
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan laporan bantuan alat: ' . $th->getMessage());
        }

        return null;
    }

    public function update(int|string $id, array $data)
    {
        try {
            return $this->repository->update($id, $data);
        } catch (\Throwable $th) {
            Log::error("Gagal memperbarui laporan bantuan alat ID $id: " . $th->getMessage());
        }

        return false;
    }

    public function delete(int|string $id)
    {
        try {
            return $this->repository->delete($id);
        } catch (\Throwable $th) {
            Log::error("Gagal menghapus laporan bantuan alat ID $id: " . $th->getMessage());
        }

        return false;
    }
}
