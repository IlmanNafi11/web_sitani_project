<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
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

       // Tambahan logika untuk permintaan hibah alat
        $selectedYear = $request->input('year', now()->year);

        // Ambil tahun unik dari tabel permintaan_bantuan_alat
        $years = DB::table('permintaan_bantuan_alat')
            ->selectRaw('YEAR(updated_at) as year')
            ->whereYear('updated_at', '<=', now()->year)
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Hitung total permintaan hibah alat untuk tahun terpilih dan status 1
        $totalPermintaanHibah = DB::table('permintaan_bantuan_alat')
            ->where('status', 1)
            ->whereYear('updated_at', $selectedYear)
            ->count();

        // chart data
        $totalDiterima = DB::table('permintaan_bantuan_alat')
            ->whereYear('updated_at', $selectedYear)
            ->where('status', 1)
            ->count();

        $totalDitolak = DB::table('permintaan_bantuan_alat')
            ->whereYear('updated_at', $selectedYear)
            ->where('status', 0)
            ->count();


        return view('pages.dashboard', compact(
            'totalBibit', 'totalKomoditas', 'totalPenyuluhTerdaftar', 'totalKelompokTani',
            'totalLapBibit', 'percBelumPakaiApp', 'percPakaiApp', 'statsBibit',
            'totalPermintaanHibah', 'totalDiterima', 'totalDitolak', 'selectedYear', 'years'
        ));
    }
}
