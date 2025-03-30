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
}
