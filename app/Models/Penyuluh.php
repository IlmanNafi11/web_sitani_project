<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyuluh extends Model
{
    protected $fillable = [
        'user_id',
        'penyuluh_terdaftar_id'
    ];

    /**
     * Relasi one to many dengan model laporan kondisi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<LaporanKondisi, Penyuluh>
     */
    public function laporanKondisi()
    {
        return $this->hasMany(LaporanKondisi::class);
    }

    /**
     * Relasi one to one dengan model penyuluh terdaftar
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<PenyuluhTerdaftar, Penyuluh>
     */
    public function penyuluhTerdaftar()
    {
        return $this->belongsTo(PenyuluhTerdaftar::class);
    }
}
