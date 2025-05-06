<?php

namespace App\Exports\template;

use Maatwebsite\Excel\Concerns\FromArray;

class AdminTemplate implements FromArray
{

    public function array(): array
    {
        return [
            ['Nama Lengkap', 'No Hp', 'Email', 'Role', 'Alamat Lengkap'],
        ];
    }
}
