<?php

namespace App\Exports;

use App\Models\PenyuluhTerdaftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenyuluhTerdaftarExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PenyuluhTerdaftar::with('kecamatan:id,nama')
            ->get()
            ->map(fn($item) => [
                'nama_penyuluh' => $item->nama,
                'no_hp' => $item->no_hp,
                'alamat' => $item->alamat,
                'kecamatan' => $item->kecamatan->nama,
            ]);
    }

    public function headings(): array
    {
        return ['Nama Penyuluh', 'No Hp', 'Alamat Lengkap', 'Kecamatan'];
    }
}
