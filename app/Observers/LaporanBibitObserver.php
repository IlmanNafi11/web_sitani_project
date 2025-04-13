<?php

namespace App\Observers;

use App\Models\LaporanKondisi;
use App\Models\LaporanKondisiDetail;
use Illuminate\Support\Facades\Log;

class LaporanBibitObserver
{
    /**
     * Handle the LaporanKondisi "created" event.
     */
    public function created(LaporanKondisi $laporanKondisi): void
    {
        try {
            if (request()->hasFile('foto_bibit')) {
                $data = request()->all();
                $file = $data['foto_bibit'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto_bibit/' . $data['kelompok_tani_id'], $filename, 'public');
                LaporanKondisiDetail::create([
                    'laporan_kondisi_id' => $laporanKondisi->id,
                            'luas_lahan' => $data['luas_lahan'],
                            'estimasi_panen' => $data['estimasi_panen'],
                            'jenis_bibit' => $data['jenis_bibit'],
                            'foto_bibit' => $path,
                            'lokasi_lahan' => $data['lokasi_lahan'],
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Foto bibit tidak dikirimkan: ' . $th->getMessage());
        }
    }

    /**
     * Handle the LaporanKondisi "updated" event.
     */
    public function updated(LaporanKondisi $laporanKondisi): void
    {
        //
    }

    /**
     * Handle the LaporanKondisi "deleted" event.
     */
    public function deleted(LaporanKondisi $laporanKondisi): void
    {
        //
    }

    /**
     * Handle the LaporanKondisi "restored" event.
     */
    public function restored(LaporanKondisi $laporanKondisi): void
    {
        //
    }

    /**
     * Handle the LaporanKondisi "force deleted" event.
     */
    public function forceDeleted(LaporanKondisi $laporanKondisi): void
    {
        //
    }
}
