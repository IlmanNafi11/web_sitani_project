<?php

namespace App\Services;

use App\Repositories\Interfaces\DesaRepositoryInterface;
use Illuminate\Support\Facades\Log;

class DesaService
{

    protected DesaRepositoryInterface $desaRepository;

    public function __construct(DesaRepositoryInterface $desaRepository)
    {
        $this->desaRepository = $desaRepository;
    }

    public function getAll()
    {
        try {
            return $this->desaRepository->getAll();
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data desa: ' . $th->getMessage());
        }
    }

    public function getAllWithKecamatan()
    {
        try {
            $desas = $this->desaRepository->getAll();

            return $desas->load('kecamatan');
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data desa dengan kecamatan: ' . $th->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            return $this->desaRepository->create($data);
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan data desa: ' . $th->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            return $this->desaRepository->find($id);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data desa berdasarkan id: ' . $th->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            return $this->desaRepository->update($id, $data);
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data desa: ' . $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->desaRepository->delete($id);
        } catch (\Throwable $th) {
            Log::error('Gagal menghapus data desa: ' . $th->getMessage());
        }
    }
}
