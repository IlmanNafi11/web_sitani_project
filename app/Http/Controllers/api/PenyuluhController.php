<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePenyuluhTerdaftarApiRequest;
use App\Services\PenyuluhService;
use App\Services\PenyuluhTerdaftarService;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;

class PenyuluhController extends Controller
{
    use ApiResponse;

    protected PenyuluhService $service;
    protected PenyuluhTerdaftarService $penyuluhTerdaftarService;

    public function __construct(PenyuluhService $service, PenyuluhTerdaftarService $penyuluhTerdaftarService)
    {
        $this->service = $service;
        $this->penyuluhTerdaftarService = $penyuluhTerdaftarService;
    }

    /**
     * Memperbarui data penyuluh terdaftar, digunakan oleh api pada proses pendafataran penyuluh
     *
     * @param UpdatePenyuluhTerdaftarApiRequest $request form request
     * @param string|int $id ID Penyuluh terdaftar
     * @return JsonResponse
     */
    public function update(UpdatePenyuluhTerdaftarApiRequest $request, string|int $id): JsonResponse
    {
        $validated = $request->validated();
        $result = $this->penyuluhTerdaftarService->update($id, [
            'nama' => $validated['nama_penyuluh'],
            'alamat' => $validated['alamat_penyuluh'],
        ]);

        if ($result['success']) {
            return $this->successResponse([
                'data' => $request->validated(),
            ], 'Data penyuluh berhasil diperbarui');
        }

        return $this->errorResponse('Data penyuluh gagal diperbarui', 500);
    }
}
