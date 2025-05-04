<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface PenyuluhTerdaftarApiServiceInterface
{
    public function getByPhone(string $phone): Model;
}
