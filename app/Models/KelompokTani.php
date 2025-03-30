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
}
