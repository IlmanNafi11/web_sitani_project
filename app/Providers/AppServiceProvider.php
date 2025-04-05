<?php

namespace App\Providers;

use App\Repositories\BibitRepository;
use App\Repositories\DesaRepository;
use App\Repositories\Interfaces\BibitRepositoryInterface;
use App\Repositories\Interfaces\DesaRepositoryInterface;
use App\Repositories\Interfaces\KecamatanRepositoryInterfaces;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Repositories\KecamatanRepository;
use App\Repositories\KomoditasRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(KecamatanRepositoryInterfaces::class, KecamatanRepository::class);
        $this->app->bind(DesaRepositoryInterface::class, DesaRepository::class);
        $this->app->bind(KomoditasRepositoryInterface::class, KomoditasRepository::class);
        $this->app->bind(BibitRepositoryInterface::class, BibitRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
