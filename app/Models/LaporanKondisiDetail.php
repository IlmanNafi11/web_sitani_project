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


    /**
     * Relasi one to one dengan model Laporan kondisi
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<LaporanKondisi, LaporanKondisiDetail>
     */
    public function laporanKondisi()
    {
        return $this->belongsTo(LaporanKondisi::class);
    }
}
