<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokTani extends Model
{
    protected $fillable = [
        'nama',
        'desa_id',
        'kecamatan_id',
    ];

    /**
     * Relasi many to many dengan model penyuluh terdaftar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<PenyuluhTerdaftar, KelompokTani>
     */
    public function penyuluhTerdaftars()
    {
        return $this->belongsToMany(PenyuluhTerdaftar::class, 'penyuluh_kelompok_tanis', 'kelompok_tani_id', 'penyuluh_terdaftar_id');
    }

    /**
     * Relasi one to one dengan model desa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Desa, KelompokTani>
     */
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Relasi one to one dengan model kecamatan
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Kecamatan, KelompokTani>
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
