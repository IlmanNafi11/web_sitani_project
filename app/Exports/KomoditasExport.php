<?php

namespace App\Exports;

use App\Models\Komoditas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KomoditasExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Komoditas::select(['nama', 'musim', 'deskripsi'])->get();
    }

    public function headings(): array
    {
        return ['Nama', 'Musim', 'Deskripsi'];
    }
}
