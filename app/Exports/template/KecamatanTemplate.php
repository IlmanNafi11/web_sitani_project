<?php

namespace App\Exports\template;

use Maatwebsite\Excel\Concerns\FromArray;

class KecamatanTemplate implements FromArray
{

    public function array(): array
    {
        return [
            ['nama']
        ];
    }
}
