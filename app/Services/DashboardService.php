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
        $totalBibit = $this->getTotalBibit();
        $totalKomoditas = $this->getTotalKomoditas();
        $totalPenyuluhTerdaftar = $this->getTotalPenyuluhTerdaftar();
        $totalKelompokTani = $this->getTotalKelompokTani();
        $totalLapBibit = $this->getTotalLapBibit();
        $penggunaanBibits = $this->getStatsPenggunaanBibit();
        $statsAppMobile = $this->getPercentUsedApps();
        return [
            'total_bibit' => $totalBibit,
            'total_komoditas' => $totalKomoditas,
            'total_kelompok_tani' => $totalKelompokTani,
            'total_lap_bibit' => $totalLapBibit,
            'total_penyuluh_terdaftar' => $totalPenyuluhTerdaftar,

            'stats_bibit' => $penggunaanBibits,
            'percent_penyuluh_pakai_app' => $statsAppMobile['pakai_app'],
            'percent_penyuluh_belum_pakai_app' => $statsAppMobile['tidak_pakai_app'],
        ];
    }

    /**
     * Getter total bibit
     *
     * @return int total
     */
    protected function getTotalBibit(): int
    {
        try {
            return $this->bibitService->calculateTotal();
        } catch (\Throwable $e) {
            \Log::error('Terjadi kesalahan saat menghitung total bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious(),
            ]);
            return 0;
        }
    }

    /**
     * Getter total komoditas
     *
     * @return int total
     */
    protected function getTotalKomoditas(): int
    {
        try {
            return $this->komoditasService->calculateTotal();
        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan saat menghitung total bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious(),
            ]);
            return 0;
        }
    }

    /**
     * Getter Total kelompok tani
     *
     * @return int total
     */
    protected function getTotalKelompokTani(): int
    {
        try {
            return $this->kelompokTaniService->calculateTotal();
        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan saat menghitung total bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious(),
            ]);
            return 0;
        }
    }

    /**
     * Getter total penyuluh terdaftar
     *
     * @return int total
     */
    protected function getTotalPenyuluhTerdaftar(): int
    {
        try {
            return $this->penyuluhTerdaftarService->calculateTotal();
        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan saat menghitung total bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious(),
            ]);
            return 0;
        }
    }

    /**
     * Getter total laporan bibit secara keseluruhan
     *
     * @return int total
     */
    protected function getTotalLapBibit(): int
    {
        try {
            return $this->laporanBibitService->calculateTotal();
        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan saat menghitung total bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious(),
            ]);
            return 0;
        }
    }

    /**
     * Getter total penyuluh(sudah terdaftar di sitani mobile)
     *
     * @return int total
     */
    public function getTotalPenyuluh(): int
    {
        try {
            return $this->penyuluhService->calculateTotal();
        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan saat menghitung total bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious(),
            ]);
            return 0;
        }
    }

    /**
     * Getter Statistik total penggunaan bibit berdasarkan statusnya(berkualitas, tidak berkualitas, pending/blm ditinjau)
     *
     * @return int[] total
     */
    public function getStatsPenggunaanBibit(): array
    {
        try {
            return $this->laporanBibitService->getLaporanStatusCounts(null);
        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan saat menghitung total bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious(),
            ]);
            return [
                'approved' => 0,
                'rejected' => 0,
                'pending' => 0,
            ];
        }
    }

    /**
     * Getter total persentase perbandingan penyuluh yang sudah menggunakan sitani mobile dan belum menggunakan sitani mobile
     *
     * @return int[] total
     */
    public function getPercentUsedApps(): array
    {
        try {
            $percentPenyuluhPakaiApp = 0;
            $percentPenyuluhBelumPakaiApp = 0;

            $penyuluhTerdaftar = $this->getTotalPenyuluhTerdaftar();
            $penyuluh = $this->getTotalPenyuluh();

            if ($penyuluhTerdaftar > 0) {
                $percentPenyuluhPakaiApp = round(($penyuluh / $penyuluhTerdaftar) * 100, 2);
                $percentPenyuluhBelumPakaiApp = round(100 - $percentPenyuluhPakaiApp, 2);
            }

            return [
                'pakai_app' => $percentPenyuluhPakaiApp,
                'tidak_pakai_app' => $percentPenyuluhBelumPakaiApp,
            ];
        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan saat menghitung total bibit', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious(),
            ]);
            return [
                'pakai_app' => 0,
                'tidak_pakai_app' => 0,
            ];
        }
    }
}
