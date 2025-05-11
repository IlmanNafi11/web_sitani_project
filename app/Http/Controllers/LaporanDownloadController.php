<?php
namespace App\Http\Controllers;

use ZipStream\ZipStream;
use ZipStream\Option\Archive;
use Illuminate\Support\Facades\Response;
use App\Models\LaporanBantuanAlat;
use Illuminate\Support\Facades\Storage;

class LaporanDownloadController extends Controller {

    public function downloadZip($id)
    {
        $laporan = LaporanBantuanAlat::findOrFail($id);
        $detail = $laporan->LaporanBantuanAlatDetail;

        $tanggal = $laporan->created_at->format('Y-m-d');

        $files = [
            'Badan Hukum' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_badan_hukum,
            'Piagam Pengesahan' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_piagam,
            'Surat Domisili' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_surat_domisili,
            'Foto Lokasi' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_lokasi,
            'KTP Anggota 1' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_ktp_anggota1,
            'KTP Anggota 2' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_ktp_anggota2,
            'KTP Ketua' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_ktp_ketua,
            'KTP Ketua UPKK' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_ktp_ketua_upkk,
            'KTP Sekretaris' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_ktp_sekertaris,
            'Proposal' => 'laporan_bantuan_alat/' . $tanggal . '/' . $detail->path_proposal,
        ];

        $files = array_filter($files);

        if (empty($files)) {
            return back()->with('error', 'Tidak ada file yang bisa diunduh.');
        }

        // Opsi arsip ZIP (nama file dan streaming langsung)
        $options = new Archive();
        $options->setSendHttpHeaders(true);

        // Nama file zip yang akan didownload
        $zipFileName = 'laporan_' . now()->format('Ymd_His') . '.zip';

        // Set headers responsenya
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=\"$zipFileName\"");

        // Membuat instance ZipStream
        $zip = new ZipStream(null, $options);

        foreach ($files as $label => $relativePath) {
            $fullPath = storage_path('app/public/' . $relativePath);

            // Cek apakah file ada sebelum menambahkannya ke dalam ZIP
            if (file_exists($fullPath)) {
                // Tambahkan file ke dalam ZIP dengan nama label
                $zip->addFileFromPath($label . '.' . pathinfo($fullPath, PATHINFO_EXTENSION), $fullPath);
            } else {
                \Log::error("File tidak ditemukan: " . $fullPath); // Log error jika file tidak ditemukan
            }
        }

        $zip->finish(); // Penting: Tutup zip stream
        exit;
    }
}
