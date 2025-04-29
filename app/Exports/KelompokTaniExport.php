<?php

namespace App\Exports;

use App\Models\KelompokTani;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KelompokTaniExport implements FromCollection, WithHeadings
{
    /**
     * Export data dari model Kelompok Tani
     *
     * @return Collection Data
     */
    public function collection(): Collection
    {
        return KelompokTani::with(['kecamatan:id,nama', 'desa:id,nama', 'penyuluhTerdaftars:id,nama'])
            ->get()
            ->map(fn($item) => [
                'nama_kelompok_tani' => $item->nama,
                'desa' => $item->desa->nama,
                'kecamatan' => $item->kecamatan->nama,
                'penyuluh' => $item->penyuluhTerdaftars->pluck('nama')->implode(', '),
            ]);
    }

    /**
     * Mengatur heading dari data yang akan diexport
     *
     * @return string[] Heading
     */
    public function headings(): array
    {
        return ['Nama Kelompok Tani', 'Desa', 'Kecamatan', 'Penyuluh'];
    }
}
