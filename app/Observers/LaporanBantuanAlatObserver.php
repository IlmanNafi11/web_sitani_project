<?php

namespace App\Observers;

use App\Events\NotifGenerated;
use App\Models\LaporanBantuanAlat;
use App\Models\LaporanBantuanAlatDetail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LaporanBantuanAlatObserver
{
    public function created(LaporanBantuanAlat $laporan): void
    {
        //
    }

    /**
     * Handle the LaporanBantuanAlat "deleted" event.
     */
    public function deleted(LaporanBantuanAlat $laporan): void
    {
        $laporanDetail = LaporanBantuanAlatDetail::where('permintaan_bantuan_alat_id', $laporan->id)
            ->select([
                'id',
                'path_ktp_ketua',
                'path_ktp_sekretaris',
                'path_ktp_ketua_upkk',
                'path_ktp_anggota1',
                'path_ktp_anggota2',
                'path_badan_hukum',
                'path_piagam',
                'path_surat_domisili',
                'path_foto_lokasi',
            ])
            ->first();

        if ($laporanDetail) {
            $fileFields = [
                'path_ktp_ketua',
                'path_ktp_sekretaris',
                'path_ktp_ketua_upkk',
                'path_ktp_anggota1',
                'path_ktp_anggota2',
                'path_badan_hukum',
                'path_piagam',
                'path_surat_domisili',
                'path_foto_lokasi',
            ];

            foreach ($fileFields as $field) {
                if (!empty($laporanDetail->$field)) {
                    try {
                        Storage::disk('public')->delete($laporanDetail->$field);
                    } catch (\Throwable $th) {
                        Log::error("Gagal menghapus file {$field}: " . $th->getMessage());
                    }
                }
            }

            $laporanDetail->delete();
        }
    }

    /**
     * Handle the LaporanBantuanAlat "updated" event.
     */
    public function updated(LaporanBantuanAlat $laporan): void
    {
        $penyuluh = $laporan->penyuluh()->first();
        if (!$penyuluh) {
            return;
        }

        $user = User::find($penyuluh->user_id);
        if (!$user) {
            return;
        }

        $judulNotifikasi = '';
        $pesanNotifikasi = '';

        $status = $laporan->status;
        switch ($status) {
            case 1:
                $judulNotifikasi = 'Pengajuan Disetujui';
                $pesanNotifikasi = 'Pengajuan bantuan alat untuk kelompok tani ' . $laporan->kelompokTani->nama .  ' telah disetujui.';
                break;
            case 0:
                $judulNotifikasi = 'Pengajuan Ditolak';
                $pesanNotifikasi = 'Pengajuan bantuan alat untuk kelompok tani ' . $laporan->kelompokTani->nama . ' ditolak.';
                break;
            default:
                $judulNotifikasi = 'Pengajuan masih diproses';
                $pesanNotifikasi = 'Pengajuan bantuan alat untuk kelompok tani ' . $laporan->kelompokTani->nama . ' masih diproses.';
        }

        event(new NotifGenerated(
            $user,
            $judulNotifikasi,
            $pesanNotifikasi,
            'laporan_bantuan_alat_status'
        ));
    }

    /**
     * Handle the LaporanBantuanAlat "restored" event.
     */
    public function restored(LaporanBantuanAlat $laporan): void
    {
        //
    }

    /**
     * Handle the LaporanBantuanAlat "force deleted" event.
     */
    public function forceDeleted(LaporanBantuanAlat $laporan): void
    {
        //
    }
}
