<?php

namespace App\Http\Controllers\api;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\KomoditasApiServiceInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;

class KomoditasController extends Controller
{
    use ApiResponse;

    protected KomoditasApiServiceInterface $service;

    public function __construct(KomoditasApiServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        try {
            $datas = $this->service->getAllApi();
            return $this->successResponse($datas->toArray(), 'Data komoditas berhasil diambil');
        } catch (DataAccessException $e) {
            return $this->errorResponse('Gagal fetch data komoditas.', 500);
        } catch (\Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan di server.', 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $komoditas = $this->service->getById($id);
            return $this->successResponse($komoditas->toArray(), 'Data komoditas berhasil diambil');
        } catch (ResourceNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        } catch (DataAccessException $e) {
            return $this->errorResponse('Gagal fetch data komoditas.', 500);
        } catch (\Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan di server.', 500);
        }
    }


    public function getMusim(): JsonResponse
    {
        try {
            $musimData = $this->service->GetMusim();
            return $this->successResponse($musimData->toArray(), 'Data musim komoditas berhasil diambil');
        } catch (DataAccessException $e) {
            return $this->errorResponse('Gagal fetch data musim tiap komoditas.', 500);
        } catch (\Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan di server', 500);
        }
    }

    public function calculateTotal(): JsonResponse
    {
        try {
            $total = $this->service->calculateTotal();
            return $this->successResponse(['total' => $total], 'Total komoditas berhasil diambil');
        } catch (DataAccessException $e) {
            return $this->errorResponse('Gagal menghitung total komoditas.', 500);
        } catch (\Throwable $e) {
            return $this->errorResponse('Terjadi kesalahan di server.', 500);
        }
    }
}
