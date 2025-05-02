<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KelompokTaniResource;
use App\Services\KelompokTaniService;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KelompokTaniController extends Controller
{
    use ApiResponse;

    protected KelompokTaniService $service;

    public function __construct(KelompokTaniService $service)
    {
        $this->service = $service;
    }

    /**
     * Mengambil seluruh data kelompok tani berdasarkan penyuluh id.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllByPenyuluhId(Request $request): JsonResponse
    {
        $penyuluhIds = $request->query('penyuluhIds');
        if (is_null($penyuluhIds)) {
            return $this->errorResponse('penyuluhIds tidak boleh kosong', 400);
        }

        $ids = is_array($penyuluhIds) ? $penyuluhIds : explode(',', $penyuluhIds);
        $result = $this->service->getByPenyuluhId($ids);


        if ($result['success']) {
            return $this->successResponse($result['data'], $result['message']);
        }

        return $this->errorResponse($result['message'], 404);
    }

    /**
     * Mengambil data kelompok tani berdasarkan id
     *
     * @param string|int $id Id kelompok Tani
     * @return JsonResponse
     */
    public function getById(string|int $id): JsonResponse
    {
        $result = $this->service->getById($id);

        if ($result['success']) {
            return $this->successResponse(new KelompokTaniResource($result['data']), $result['message']);
        }
        return $this->errorResponse($result['message'], 404);
    }

    /**
     * Mengambil total Kelompok tani yang terdaftar di dinas
     *
     * @return JsonResponse
     */
    public function calculateTotal(): JsonResponse
    {
        try {
            $total = $this->service->calculateTotal();
            return $this->successResponse($total, 'Total Kelompok Tani Berhasil diambil');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function countByKecamatanId(string|int $id): JsonResponse
    {
        try {
            $total = $this->service->countByKecamatanId($id);
            return $this->successResponse(['total' => $total], 'Total Kelompok Tani berhasil diambil');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
