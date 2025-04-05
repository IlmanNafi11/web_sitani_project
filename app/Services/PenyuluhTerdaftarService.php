<?php
namespace App\Services;

use App\Repositories\Interfaces\PenyuluhRepositoryInterface;
use Illuminate\Support\Facades\Log;

class PenyuluhTerdaftarService {
    protected PenyuluhRepositoryInterface $penyuluhRepository;

    public function __construct(PenyuluhRepositoryInterface $penyuluhRepository)
    {
        $this->penyuluhRepository = $penyuluhRepository;
    }

    public function getAll()
    {
        try {
            return $this->penyuluhRepository->getAll();
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data penyuluh terdaftar: ' . $th->getMessage());
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
            return $this->penyuluhRepository->update($id, $data);
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data penyuluh terdaftar: ' . $th->getMessage());
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
}
