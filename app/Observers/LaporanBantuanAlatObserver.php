<?php

namespace App\Observers;

use App\Models\LaporanBantuanAlat;
use App\Models\LaporanBantuanAlatDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LaporanBantuanAlatObserver
{
    public function created(LaporanBantuanAlat $laporan): void
    {
        try {
            $data = request()->all();
            $now = date('Y-m-d');
            $kelompokTaniId = $data['kelompok_tani_id'];
            $fileFields = [
                'ktp_ketua',
                'ktp_sekretaris',
                'ktp_ketua_upkk',
                'ktp_anggota1',
                'ktp_anggota2',
                'badan_hukum',
                'piagam',
                'surat_domisili',
                'foto_lokasi',
            ];

            $paths = [];

            foreach ($fileFields as $field) {
                if (request()->hasFile($field)) {
                    $file = request()->file($field);
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $paths[$field] = $file->storeAs("laporan_bantuan_alat/$kelompokTaniId/$now/$field", $filename, 'public');
                } else {
                    $paths[$field] = null;
                }
            }

            LaporanBantuanAlatDetail::create([
                'laporan_bantuan_alat_id' => $laporan->id,
                'path_ktp_ketua' => $paths['ktp_ketua'],
                'path_ktp_sekretaris' => $paths['ktp_sekretaris'],
                'path_ktp_ketua_upkk' => $paths['ktp_ketua_upkk'],
                'path_ktp_anggota1' => $paths['ktp_anggota1'],
                'path_ktp_anggota2' => $paths['ktp_anggota2'],
                'path_badan_hukum' => $paths['badan_hukum'],
                'path_piagam' => $paths['piagam'],
                'path_surat_domisili' => $paths['surat_domisili'],
                'path_foto_lokasi' => $paths['foto_lokasi'],
            ]);
        } catch (\Throwable $th) {
            Log::error('Gagal menyimpan laporan bantuan alat: ' . $th->getMessage());
        }
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
                'ktp_ketua',
                'ktp_sekretaris',
                'ktp_ketua_upkk',
                'ktp_anggota1',
                'ktp_anggota2',
                'badan_hukum',
                'piagam',
                'surat_domisili',
                'foto_lokasi',
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
        //
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
