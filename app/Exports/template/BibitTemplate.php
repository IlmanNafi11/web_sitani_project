<?php

namespace App\Exports\template;

use Maatwebsite\Excel\Concerns\FromArray;

class BibitTemplate implements FromArray
{

    public function array(): array
    {
        return [
            ['Nama Bibit', 'Komoditas', 'Deskripsi']
        ];
    }
}
