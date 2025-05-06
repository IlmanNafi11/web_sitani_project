<?php

namespace App\Http\Controllers\api;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\KelompokTaniResource;
use App\Services\Interfaces\KelompokTaniApiServiceInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class KelompokTaniController extends Controller
{
    use ApiResponse;

    protected KelompokTaniApiServiceInterface $service;

    public function __construct(KelompokTaniApiServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getAllByPenyuluhId(Request $request): JsonResponse
    {
        $penyuluhIds = $request->query('penyuluhIds');

        if (is_null($penyuluhIds)) {
            return $this->errorResponse('penyuluhIds tidak boleh kosong', 400);
        }

        $ids = is_array($penyuluhIds) ? $penyuluhIds : explode(',', $penyuluhIds);
        $ids = array_filter($ids, static fn($id) => !empty($id));

        if (empty($ids)) {
            return $this->successResponse([], 'Tidak ada penyuluh ID yang valid diberikan.');
        }

        try {
            $kelompokTanis = $this->service->getAllByPenyuluhId($ids);
            $formattedData = $kelompokTanis->map(function($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'desa' => [
                        'id' => $item->desa->id ?? null,
                        'nama' => $item->desa->nama ?? null,
                    ],
                    'kecamatan' => [
                        'id' => $item->desa->kecamatan->id ?? null,
                        'nama' => $item->desa->kecamatan->nama ?? null,
                    ],
                    'penyuluhs' => $item->penyuluhTerdaftars->map(function($penyuluh) {
                        return [
                            'id' => $penyuluh->id,
                            'nama' => $penyuluh->nama,
                            'no_hp' => $penyuluh->no_hp,
                            'alamat' => $penyuluh->alamat,
                        ];
                    })
                ];
            });
            return $this->successResponse($formattedData, 'Data kelompok tani ditemukan');
        } catch (DataAccessException $e) {
            return $this->errorResponse('Failed to fetch Kelompok Tani data.', 500);
        } catch (Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan diserver.', 500);
        }
    }

    public function getById(string|int $id): JsonResponse
    {
        try {
            $kelompokTani = $this->service->getById($id);
            return $this->successResponse(new KelompokTaniResource($kelompokTani), 'Data kelompok tani ditemukan');
        } catch (ResourceNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        } catch (DataAccessException $e) {
            return $this->errorResponse('Failed to fetch Kelompok Tani data.', 500);
        } catch (Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan diserver.', 500);
        }
    }

    public function calculateTotal(): JsonResponse
    {
        try {
            $total = $this->service->getTotal();

            return $this->successResponse($total, 'Total Kelompok Tani berhasil diambil');
        } catch (DataAccessException $e) {
            return $this->errorResponse('Failed to calculate total Kelompok Tani.', 500);
        } catch (Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan diserver.', 500);
        }
    }

    public function countByKecamatanId(string|int $id): JsonResponse
    {
        try {
            $total = $this->service->countByKecamatanId($id);

            return $this->successResponse(['total' => $total], 'Total Kelompok Tani berhasil diambil');
        } catch (DataAccessException $e) {
            return $this->errorResponse('Failed to count Kelompok Tani by Kecamatan ID.', 500);
        } catch (Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan diserver.', 500);
        }
    }
}
