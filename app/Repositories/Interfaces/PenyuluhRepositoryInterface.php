<?php

namespace App\Repositories\Interfaces;

interface PenyuluhRepositoryInterface
{
    /**
     * Menghitung total Penyuluh yang sudah menggunakan aplikasi mobile sitani
     *
     * @return int Total Data Penyuluh
     */
    public function calculateTotal(): int;
}
