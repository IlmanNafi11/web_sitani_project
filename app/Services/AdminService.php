<?php

namespace App\Services;

use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Log;

class AdminService
{
    protected CrudInterface $repository;
    public function __construct(CrudInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        try {
            return $this->repository->getAll(true);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil seluruh data admin', [
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return $this->repository->find($id);
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil data admin berdasarkan id', [
                'id'    => $id,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }

    public function create(array $data)
    {
        try {
            $dt = [
                'email' => $data['email'],
                'nama' => $data['nama'],
                'no_hp' => $data['no_hp'],
                'alamat' => $data['alamat'],
                'password' => 'sitani',
                'role' => $data['role'],
                'is_password_set' => false,
            ];

            return $this->repository->create($dt);
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan data admin: ' . $th->getMessage());
            return null;
        }
    }

    public function update($id, array $data)
    {
        try {
            return $this->repository->update($id, $data);
        } catch (\Throwable $th) {
            Log::error('Gagal memperbarui data admin', [
                'id'    => $id,
                'data'  => $data,
                'error' => $th->getMessage(),
            ]);

            return null;
        }
    }

    public function delete($id)
    {
        try {
            return $this->repository->delete($id);
        } catch (\Throwable $th) {
            Log::error('Gagal menghapus data admin', [
                'id'    => $id,
                'error' => $th->getMessage(),
            ]);

            return null;
        }
    }
}
