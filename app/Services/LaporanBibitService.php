<?php
namespace App\Services;

use App\Models\LaporanKondisi;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Log;

class LaporanBibitService {

    protected CrudInterface $repository;

    public function __construct(CrudInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Mengambil seluruh data laporan bibit
     *
     * @return array|\Illuminate\Support\Collection<int, LaporanKondisi, LaporanKondisi>
     */
    public function getAll()
    {
        try {
            return $this->repository->getAll();
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data laporan bibit: ' . $th->getMessage());
        }
        return collect([]);
    }

    public function getById(string|int $id)
    {
        try {
            return $this->repository->find($id);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil laporan berdasarkan id: ' . $th->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            return $this->repository->create([
                'kelompok_tani_id' => $data['kelompok_tani_id'],
                'komoditas_id' => $data['komoditas_id'],
                'penyuluh_id' => $data['penyuluh_id'],
                'status' => 'pending',
            ]);
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan laporan bibit: ' . $th->getMessage());
        }
    }

    public function update(string|int $id, array $data)
    {
        try {
            return $this->repository->update($id, $data);
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data laporan bibit: ' . $th->getMessage());
        }
    }

    public function delete(string|int $id)
    {
        try {
            return $this->repository->delete($id);
        } catch (\Throwable $th) {
            Log::error('Gagal menghapus data laporan bibit: ' . $th->getMessage());
        }
    }
}
