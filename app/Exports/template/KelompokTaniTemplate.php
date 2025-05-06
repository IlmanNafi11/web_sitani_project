<?php

namespace App\Exports\template;

use Maatwebsite\Excel\Concerns\FromArray;

class KelompokTaniTemplate implements FromArray
{
    /**
     * Mengatur struktur template
     *
     * @return array[] struktur template
     */
    public function array(): array
    {
        return [
            ['Nama Kelompok Tani', 'Desa', 'Kecamatan', 'No Hp Penyuluh'],
        ];
    }
}
