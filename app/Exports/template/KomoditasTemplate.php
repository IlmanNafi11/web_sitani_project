<?php

namespace App\Exports\template;

use App\Models\Komoditas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class KomoditasTemplate implements FromArray
{

    public function array(): array
    {
        return [
            ['Nama' , 'musim', 'deskripsi'],
        ];
    }
}
