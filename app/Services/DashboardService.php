<?php

namespace App\Services;

class DashboardService
{
    protected BibitService $bibitService;
    protected KomoditasService $komoditasService;
    protected PenyuluhTerdaftarService $penyuluhTerdaftarService;
    protected KelompokTaniService $kelompokTaniService;
    protected LaporanBibitService $laporanBibitService;
    protected PenyuluhService $penyuluhService;

    public function __construct(BibitService $bibitService, KomoditasService $komoditasService, PenyuluhTerdaftarService $penyuluhTerdaftarService, KelompokTaniService $kelompokTaniService, LaporanBibitService $laporanBibitService, PenyuluhService $penyuluhService)
    {
        $this->bibitService = $bibitService;
        $this->komoditasService = $komoditasService;
        $this->penyuluhTerdaftarService = $penyuluhTerdaftarService;
        $this->kelompokTaniService = $kelompokTaniService;
        $this->laporanBibitService = $laporanBibitService;
        $this->penyuluhService = $penyuluhService;
    }

    public function getStats()
    {
        try {
            $totalBibit = $this->bibitService->calculateTotal();
            $totalKomoditas = $this->komoditasService->calculateTotal();
            $totalPenyuluhTerdaftar = $this->penyuluhTerdaftarService->calculateTotal();
            $totalKelompokTani = $this->kelompokTaniService->calculateTotal();
            $totalLapBibit = $this->laporanBibitService->calculateTotal();
            $totalPenyuluh = $this->penyuluhService->calculateTotal();
            $penggunaanBibits = $this->laporanBibitService->getLaporanStatusCounts();

            $percentPenyuluhPakaiApp = 0;
            $percentPenyuluhBelumPakaiApp = 0;

            if ($totalPenyuluhTerdaftar > 0) {
                $percentPenyuluhPakaiApp = round(($totalPenyuluh / $totalPenyuluhTerdaftar) * 100, 2);
                $percentPenyuluhBelumPakaiApp = round(100 - $percentPenyuluhPakaiApp, 2);
            }
        } catch (\Throwable $e) {
            \Log::error('Terjadi kesalahan saat mengambil data statistik', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [

            ];
        }
        return [
            'total_bibit' => $totalBibit,
            'total_komoditas' => $totalKomoditas,
            'total_kelompok_tani' => $totalKelompokTani,
            'total_lap_bibit' => $totalLapBibit,
            'total_penyuluh_terdaftar' => $totalPenyuluhTerdaftar,

            'stats_bibit' => $penggunaanBibits,
            'percent_penyuluh_pakai_app' => $percentPenyuluhPakaiApp,
            'percent_penyuluh_belum_pakai_app' => $percentPenyuluhBelumPakaiApp,
        ];
    }
}
