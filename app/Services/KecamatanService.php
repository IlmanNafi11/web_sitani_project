<?php
namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Log;

class KecamatanService {
    protected CrudInterface $kecamatanRepository;

    public function __construct(CrudInterface $kecamatanRepository)
    {
        $this->kecamatanRepository = $kecamatanRepository;
    }

    public function getAll()
    {
        try {
            return $this->kecamatanRepository->getAll();
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data kecamatan: ' . $th->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            return $this->kecamatanRepository->find($id);
        } catch (\Throwable $th) {
            Log::error('Gagal dalam mencari data kecamatan: ' . $th->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            return $this->kecamatanRepository->create($data);
        } catch (\Throwable $th) {
            Log::error('Gagal Menyimpan kecamatan: ' . $th->getMessage());
        }

    }

    public function update($id, $data)
    {
        try {
            return $this->kecamatanRepository->update($id, $data);
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui kecamatan' . $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->kecamatanRepository->delete($id);
        } catch (\Throwable $th) {
            Log::error('Gagal menghapus kecamatan: ' . $th->getMessage());
        }
    }
}
