<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'musim',
    ];

    /**
     * Relasi one to one dengan model bibit berkualitas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<BibitBerkualitas, Komoditas>
     */
    public function bibitBerkualitas()
    {
        return $this->hasOne(BibitBerkualitas::class);
    }

    /**
     * Relasi one to many dengan model laporan kondisi
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<LaporanKondisi, Komoditas>
     */
    public function laporanKondisi()
    {
        return $this->hasMany(LaporanKondisi::class);
    }
}
