<?php

namespace App\Repositories\Interfaces;

interface KomoditasRepositoryInterface
{
    /**
     * Menghitung total Komoditas yang terdaftar di aplikasi
     *
     * @return int Total Data Komoditas
     */
    public function calculateTotal(): int;
}
