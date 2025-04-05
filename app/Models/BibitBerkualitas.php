<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BibitBerkualitas extends Model
{
    protected $fillable = [
        'nama',
        'komoditas_id',
        'deskripsi',
    ];

    /**
     * Relasin one to one dengan model komoditas
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Komoditas, BibitBerkualitas>
     */
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class);
    }
}
