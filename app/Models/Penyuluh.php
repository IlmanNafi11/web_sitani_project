<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyuluh extends Model
{
    protected $fillable = [
        'user_id',
        'penyuluh_terdaftar_id'
    ];
}
