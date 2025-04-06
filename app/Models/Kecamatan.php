<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable = [
        'nama',
    ];

    /**
     * Relasi one to one dengan model desa
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Desa, Kecamatan>
     */
    public function desa()
    {
        return $this->hasOne(Desa::class);
    }

    /**
     * Relasi one to one dengan model penyuluh terdaftar
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<PenyuluhTerdaftar, Kecamatan>
     */
    public function penyuluhTerdaftar()
    {
        return $this->hasOne(PenyuluhTerdaftar::class);
    }

    /**
     * Relasi one to one dengan model kelompok tani
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<KelompokTani, Kecamatan>
     */
    public function kelompokTani()
    {
        return $this->hasOne(KelompokTani::class);
    }
}
