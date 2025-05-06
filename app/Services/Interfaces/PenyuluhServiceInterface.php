<?php

namespace App\Services\Interfaces;

use App\Exceptions\DataAccessException;
use App\Services\Interfaces\Base\BaseServiceInterface;

interface PenyuluhServiceInterface extends BaseServiceInterface
{
    /**
     * Mengambil total penyuluh yang terdaftar di Sitani
     *
     * @return int Total
     * @throws DataAccessException
     */
    public function calculateTotal(): int;
}
