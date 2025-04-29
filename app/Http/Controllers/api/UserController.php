<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Mengambil data pengguna berdasarkan id
     *
     * @param string|int $id Id pengguna
     * @return JsonResponse
     */
    public function getProfile(string|int $id)
    {
        $result = $this->service->findUser(['id' => $id], [
            'penyuluh' => [
                'id', 'user_id', 'penyuluh_terdaftar_id'
            ],
            'penyuluh.penyuluhTerdaftar' => [
                'id', 'nama', 'no_hp', 'alamat', 'kecamatan_id',
            ],
            'penyuluh.penyuluhTerdaftar.kecamatan' => [
                'id', 'nama',
            ]
        ]);

        if ($result['success']) {
            return $this->successResponse(new UserResource($result['data']), $result['message']);
        }

        return $this->errorResponse($result['message'], $result['code'], ['user_id' => $id]);
    }

}
