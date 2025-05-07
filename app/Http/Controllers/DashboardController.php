<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected DashboardService $service;
    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $stats = $this->service->getStats();
        $totalBibit = $stats['total_bibit'];
        $totalKomoditas = $stats['total_komoditas'];
        $totalPenyuluhTerdaftar = $stats['total_penyuluh_terdaftar'];
        $totalKelompokTani = $stats['total_kelompok_tani'];
        $totalLapBibit = $stats['total_lap_bibit'];
        $percBelumPakaiApp = $stats['percent_penyuluh_belum_pakai_app'];
        $percPakaiApp = $stats['percent_penyuluh_pakai_app'];
        $statsBibit = $stats['stats_bibit'];


        return view('pages.dashboard', compact('totalBibit', 'totalKomoditas', 'totalPenyuluhTerdaftar', 'totalKelompokTani', 'totalLapBibit', 'percBelumPakaiApp', 'percPakaiApp', 'statsBibit'));
    }
}
