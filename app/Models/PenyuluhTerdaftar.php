<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyuluhTerdaftar extends Model
{
    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'kecamatan_id'
    ];

    /**
     * Relasi one to one dengan model kecamatan
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Kecamatan, PenyuluhTerdaftar>
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
