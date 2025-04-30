<?php

namespace App\Http\Controllers;
use App\Services\LaporanBantuanAlatService;

use Illuminate\Http\Request;

class LaporanBantuanAlatController extends Controller
{
    protected LaporanBantuanAlatService $laporanService;
    public function __construct(LaporanBantuanAlatService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index()
    {
        $laporans = $this->laporanService->getAll();
        return view('pages.laporan_alat.index', compact('laporans'));
    }
}
