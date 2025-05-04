<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface BibitApiServiceInterface
{
    public function getAllApi(): Collection;
    public function calculateTotal(): int;
}
