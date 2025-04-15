<?php

namespace App\Observers;

use App\Models\LaporanKondisi;
use App\Models\LaporanKondisiDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
                $now = date('Y-m-d');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto_bibit/' . $data['kelompok_tani_id'] . '/' . $now, $filename, 'public');
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
        $laporanDetail = LaporanKondisiDetail::where('laporan_kondisi_id', $laporanKondisi->id)->select(['id', 'foto_bibit'])->first();

        if ($laporanDetail) {
            if ($laporanDetail->foto_bibit) {
                try {
                    Storage::disk('public')->delete($laporanDetail->foto_bibit);
                } catch (\Throwable $th) {
                    Log::error('Gagal menghapus foto bibit: ' . $th->getMessage());
                }
            }
            $laporanDetail->delete();
        }

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
