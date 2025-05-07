<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyuluh extends Model
{
    protected $fillable = [
        'user_id',
        'penyuluh_terdaftar_id'
    ];

    /**
     * Relasi one to many dengan model laporan kondisi
     *
     * @return HasMany<LaporanKondisi, Penyuluh>
     */
    public function laporanKondisi()
    {
        return $this->hasMany(LaporanKondisi::class);
    }

    /**
     * Relasi one to one dengan model penyuluh terdaftar
     *
     * @return BelongsTo<PenyuluhTerdaftar, Penyuluh>
     */
    public function penyuluhTerdaftar()
    {
        return $this->belongsTo(PenyuluhTerdaftar::class);
    }

    /**
     * Relasi one to one dengan model user
     *
     * @return BelongsTo<User, Penyuluh>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
