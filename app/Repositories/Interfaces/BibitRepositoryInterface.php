<?php

namespace App\Repositories\Interfaces;

interface BibitRepositoryInterface
{
    /**
     * Menghitung total Bibit Berkualitas yang terdaftar di aplikasi
     *
     * @return int Total Data Bibit
     */
    public function calculateTotal(): int;
}
