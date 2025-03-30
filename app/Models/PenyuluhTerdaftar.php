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
}
