<?php
namespace App\Services;

use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use Illuminate\Support\Facades\Log;

class KomoditasService {

    protected KomoditasRepositoryInterface $komoditasRepository;

    public function __construct(KomoditasRepositoryInterface $komoditasRepository)
    {
        $this->komoditasRepository = $komoditasRepository;
    }

    public function getAll()
    {
        try {
            return $this->komoditasRepository->getAll();
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data komoditas: ' . $th->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            return $this->komoditasRepository->create($data);
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan data komoditas: ' . $th->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            return $this->komoditasRepository->find($id);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data komoditas berdasarkan id: ' . $th->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            return $this->komoditasRepository->update($id, $data);
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data komoditas: ' . $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->komoditasRepository->delete($id);
        } catch (\Throwable $th) {
            Log::error('Gagal menghapus data komoditas: ' . $th->getMessage());
        }
    }
}
