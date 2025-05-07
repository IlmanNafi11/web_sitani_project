<?php

namespace App\Exports;

use App\Models\BibitBerkualitas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BibitExport implements FromCollection, WithHeadings
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return BibitBerkualitas::with('komoditas:id,nama')
            ->get()
            ->map(fn($item) => [
                'nama_bibit'=> $item->nama,
                'nama_komoditas'=> $item->komoditas->nama,
                'deskripsi'=> $item->deskripsi,
            ]);
    }

    public function headings(): array
    {
        return ['Nama Bibit', 'Komoditas', 'Deskripsi'];
    }
}
