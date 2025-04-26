<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\BibitService;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BibitController extends Controller
{
    use ApiResponse;
    protected BibitService $service;

    public function __construct(BibitService $service)
    {
        $this->service = $service;
    }

    /**
     * Mengambil seluruh data bibit berkualitas yang terdaftar
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $result = $this->service->getAll(false);
        if ($result['success']) {
            return $this->successResponse($result['data'], $result['message']);
        }
        return $this->errorResponse($result['message'], 404);
    }
}
