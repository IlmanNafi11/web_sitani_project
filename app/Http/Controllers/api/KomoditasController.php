<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\KomoditasService;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KomoditasController extends Controller
{
    use ApiResponse;
    protected KomoditasService $service;

    public function __construct(KomoditasService $service)
    {
        $this->service = $service;
    }

    /**
     * Mengambil seluruh data komoditas
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $komoditas = $this->service->getAll();

        if ($komoditas['success']) {
            return $this->successResponse($komoditas['data'], $komoditas['message']);
        }

        return $this->errorResponse($komoditas['message'], 404);
    }

    /**
     * Mengambil data komoditas berdasarkan id
     *
     * @param string|int $id Id komoditas
     * @return JsonResponse
     */
    public function getById(string|int $id): JsonResponse
    {
        $komoditas = $this->service->getById($id);

        if ($komoditas['success']) {
            return $this->successResponse($komoditas['data'], $komoditas['message']);
        }

        return $this->errorResponse($komoditas['message'], 404);
    }

    /**
     * Mengambil total musim tiap komoditas
     *
     * @return JsonResponse
     */
    public function getTotalMusim(): JsonResponse
    {
        try {
            $komoditas = $this->service->getMusim();
            return $this->successResponse($komoditas, 'Data musim tiap komoditas berhasil diambil');
        } catch (\Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan di server');
        }
    }
}
