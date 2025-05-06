<?php

namespace App\Exports\template;

use Maatwebsite\Excel\Concerns\FromArray;

class PenyuluhTerdaftarTemplate implements FromArray
{

    public function array(): array
    {
        return [
            ['Nama Penyuluh', 'No Hp', 'Alamat Lengkap', 'Kecamatan']
        ];
    }
}
