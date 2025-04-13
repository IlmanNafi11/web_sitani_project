<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LaporanBibitRequest;
use App\Services\LaporanBibitService;

class LaporanBibitController extends Controller
{
    protected LaporanBibitService $laporanService;
    public function __construct(LaporanBibitService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function sendReport(LaporanBibitRequest $request)
    {
        $validated = $request->validated();

        $laporan = $this->laporanService->create($validated);

        if ($laporan) {
            return response()->json([
                'message' => 'Report sent successfully',
                'data' => $laporan,
            ], 201);
        }

        return response()->json([
            'message' => 'Laporan gagal disimpan'
        ], 400);
    }
}
