<?php

namespace App\Providers;

use App\Repositories\DesaRepository;
use App\Repositories\Interfaces\DesaRepositoryInterface;
use App\Repositories\Interfaces\KecamatanRepositoryInterfaces;
use App\Repositories\KecamatanRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
