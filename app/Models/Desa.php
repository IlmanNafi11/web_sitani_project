<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $fillable = [
        'nama',
        'kecamatan_id',
    ];

    /**
     * Relasi one to one dengan model kecamatan
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Kecamatan, Desa>
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
