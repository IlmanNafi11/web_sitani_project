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

    public function getAll()
    {
        try {
            return $this->kelompokTaniRepository->getAll();
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data kelompok tani: ' . $th->getMessage());
        }
    }

    public function getAllWithRelations()
    {
        try {
            return $this->kelompokTaniRepository->getAll(true);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data kelompok tani beserta relasi: ' . $th->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            return $this->kelompokTaniRepository->find($id);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data kelompok tani berdasarkan id: ' . $th->getMessage());
        }
    }

    public function getByIdWithPivot($id)
    {
        try {
            $kelompokTani = $this->kelompokTaniRepository->find($id);
            return $kelompokTani->load('penyuluhTerdaftars', 'kecamatan', 'desa');
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data kelompok tani berdasarkan id: ' . $th->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            $kelompokTani = $this->kelompokTaniRepository->create($data);

            $this->relationManager->attach($kelompokTani, $data['penyuluh_terdaftar_id']);

            return true;
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan data kelompok tani: ' . $th->getMessage());
        }

        return false;
    }

    public function update($id, $data)
    {
        try {
            $kelompokTani = $this->kelompokTaniRepository->update($id, [
                "nama" => $data["nama"],
                "desa_id" => $data["desa_id"],
                "kecamatan_id" => $data["kecamatan_id"],
            ]);

            $this->relationManager->sync($kelompokTani, $data['penyuluh_terdaftar_id']);
            return true;
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data kelompok tani: ' . $th->getMessage());
        }

        return false;
    }

    public function delete($id)
    {
        try {
            $kelompokTani = $this->kelompokTaniRepository->delete($id);

            $this->relationManager->detach($kelompokTani);
        } catch (\Throwable $th) {
            Log::error('Gagal menghapus data kelompok tani: ' . $th->getMessage());
        }
    }
}
