<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKondisi extends Model
{
    protected $fillable = [
        'kelompok_tani_id',
        'komoditas_id',
        'status',
        'penyuluh_id',
    ];
}
