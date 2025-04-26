<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanBibitRequest;
use App\Http\Resources\LaporanKondisiResource;
use App\Services\LaporanBibitService;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;

class LaporanBibitController extends Controller
{
    use ApiResponse;

    protected LaporanBibitService $service;

    public function __construct(LaporanBibitService $service)
    {
        $this->service = $service;
    }

    /**
     * Menyimpan laporan bibit yang dikirim oleh penyuluh
     *
     * @param LaporanBibitRequest $request Form request
     * @return JsonResponse
     */
    public function saveReport(LaporanBibitRequest $request):JsonResponse
    {
        $result = $this->service->create($request->validated());

        if ($result['success']) {
            return $this->successResponse($result['data'], $result['message'], 201);
        }

        return $this->errorResponse($result['message'], 500, $request->validated());
    }

    /**
     * Mengambil laporan berdasarkan id penyuluh
     *
     * @param string|int $id Id penyuluh
     * @return JsonResponse
     */
    public function getByPenyuluhId(string|int $id): JsonResponse
    {
        $result = $this->service->getByPenyuluhId($id);
        if ($result['success']) {
            return $this->successResponse(LaporanKondisiResource::collection($result['data']), $result['message'], 200);
        }

        return $this->errorResponse($result['message'], 500, ['id' => $id]);
    }
}
