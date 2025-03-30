<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKondisiDetail extends Model
{
    protected $fillable = [
        'laporan_kondisi_id',
        'luas_lahan',
        'estimasi_panen',
        'jenis_bibit',
        'foto_bibit',
        'lokasi_lahan',
    ];
}
