<?php

namespace App\Exports\template;

use Maatwebsite\Excel\Concerns\FromArray;

class DesaTemplate implements FromArray
{

    public function array(): array
    {
        return [
          ['Nama Desa', 'Nama Kecamatan'],
        ];
    }
}
