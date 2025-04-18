<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'no_hp',
        'alamat',
    ];

    /**
     * Relasi one to one dengan model user
     *
     * @return BelongsTo<User, Admin>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
