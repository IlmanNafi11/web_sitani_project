<?php
namespace App\Services;

use App\Repositories\Interfaces\BibitRepositoryInterface;
use Illuminate\Support\Facades\Log;

class BibitService {
    protected BibitRepositoryInterface $bibitRepository;

    public function __construct(BibitRepositoryInterface $bibitRepository)
    {
        $this->bibitRepository = $bibitRepository;
    }

    public function getAll()
    {
        try {
            return $this->bibitRepository->getAll();
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data bibit: ' . $th->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            return $this->bibitRepository->find($id);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data bibit berdasarkan id: ' . $th->getMessage());
        }
    }

    public function getAllWithKomoditas()
    {
        try {
            $bibit = $this->bibitRepository->getAll();
            return $bibit->load('komoditas');
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data bibit dengan komoditas: ' . $th->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            return $this->bibitRepository->create($data);
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan data bibit: ' . $th->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            return $this->bibitRepository->update($id, $data);
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data bibit: ' . $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->bibitRepository->delete($id);
        } catch (\Throwable $th) {
            Log::error('Gagal menghapus data bibit: ' . $th->getMessage());
        }
    }
}
