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
}
