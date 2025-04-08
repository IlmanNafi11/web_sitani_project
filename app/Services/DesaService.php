<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\DesaRepositoryInterface;
use App\Repositories\Interfaces\DesaCustomQueryInterface;

class DesaService
{

    protected DesaRepositoryInterface $desaRepository;
    protected DesaCustomQueryInterface $desaCustomQuery;

    public function __construct(DesaRepositoryInterface $desaRepository, DesaCustomQueryInterface $desaCustomQuery)
    {
        $this->desaRepository = $desaRepository;
        $this->desaCustomQuery = $desaCustomQuery;
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

    public function getByKecamatanId($id)
    {
        try {
            return $this->desaCustomQuery->getByKecamatanId($id);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data desa berdasarkan kecamatan id: ' . $th->getMessage());
        }
    }
}
