<?php

namespace App\Http\Controllers\api;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanBibitRequest;
use App\Http\Resources\LaporanKondisiResource;
use App\Services\Interfaces\LaporanBibitApiServiceInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LaporanBibitController extends Controller
{
    use ApiResponse;

    protected LaporanBibitApiServiceInterface $service;

    public function __construct(LaporanBibitApiServiceInterface $service)
    {
        $this->service = $service;
    }

    public function saveReport(LaporanBibitRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if ($request->hasFile('foto_bibit') && request()->file('foto_lokasi')) {
            $validated['foto_bibit'] = $request->file('foto_bibit');
            $validated['foto_lokasi'] = $request->file('foto_lokasi');
        }

        try {
            $laporan = $this->service->create($validated);
            return $this->successResponse(new LaporanKondisiResource($laporan), 'Laporan berhasil disimpan', Response::HTTP_CREATED);
        } catch (DataAccessException $e) {
            return $this->errorResponse('Laporan Gagal disimpan',Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan tak terduga saat menyimpan laporan.',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getByPenyuluhId(string|int $id): JsonResponse
    {
        try {
            $laporans = $this->service->getByPenyuluhId($id);
            return $this->successResponse(LaporanKondisiResource::collection($laporans), 'Laporan bibit ditemukan');
        } catch (ResourceNotFoundException) {
            return $this->errorResponse('Laporan Bibit tidak ditemukan', 404);
        } catch (DataAccessException $e) {
            return $this->errorResponse('Failed to fetch Laporan Bibit data.', 500);
        } catch (Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan diserver.', 500);
        }
    }

    public function getLaporanStatusCounts(string|int $id): JsonResponse
    {
        try {
            $stats = $this->service->getLaporanStatusCounts($id);

            if (array_sum($stats) === 0) {
                return $this->errorResponse('Laporan Tidak ditemukan', 404, ['penyuluh_id' => $id]);
            }
            return $this->successResponse($stats, 'Total laporan bibit berhasil diambil');
        } catch (DataAccessException $e) {
            return $this->errorResponse('Failed to calculate report status counts.', 500);
        } catch (Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan diserver.', 500);
        }
    }
}
