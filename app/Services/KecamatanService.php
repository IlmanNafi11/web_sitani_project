<?php
namespace App\Services;

use App\Repositories\Interfaces\KecamatanRepositoryInterfaces;
use Illuminate\Support\Facades\Log;

class KecamatanService {
    protected KecamatanRepositoryInterfaces $kecamatanRepository;

    public function __construct(KecamatanRepositoryInterfaces $kecamatanRepository)
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

    public function create(array $data)
    {
        try {
            return $this->kecamatanRepository->create($data);
        } catch (\Throwable $th) {
            Log::error('Gagal Menyimpan kecamatan: ' . $th->getMessage());
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
