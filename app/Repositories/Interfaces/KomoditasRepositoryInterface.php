<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface KomoditasRepositoryInterface
{
    /**
     * Menghitung total Komoditas yang terdaftar di aplikasi
     *
     * @return int Total Data Komoditas
     */
    public function calculateTotal(): int;

    /**
     * Mengambil data musim tiap komoditas
     *
     * @return Collection data
     */
    public function GetMusim(): Collection;
}
