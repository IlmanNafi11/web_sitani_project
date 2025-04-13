<?php

namespace App\Providers;

use App\Models\LaporanKondisi;
use App\Observers\LaporanBibitObserver;
use App\Repositories\BibitRepository;
use App\Repositories\DesaRepository;
use App\Repositories\Interfaces\BibitRepositoryInterface;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\DesaCustomQueryInterface;
use App\Repositories\Interfaces\DesaRepositoryInterface;
use App\Repositories\Interfaces\KecamatanRepositoryInterfaces;
use App\Repositories\Interfaces\KelompokTaniRepositoryInterface;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Repositories\Interfaces\ManyRelationshipManagement;
use App\Repositories\Interfaces\PenyuluhRepositoryInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarCustomQueryInterface;
use App\Repositories\KecamatanRepository;
use App\Repositories\KelompokTaniRepository;
use App\Repositories\KomoditasRepository;
use App\Repositories\LaporanBibitRepository;
use App\Repositories\PenyuluhTerdaftarRepository;
use App\Services\DesaService;
use App\Services\KelompokTaniService;
use App\Services\LaporanBibitService;
use App\Services\PenyuluhTerdaftarService;
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
        $this->app->bind(PenyuluhRepositoryInterface::class, PenyuluhTerdaftarRepository::class);
        $this->app->bind(KelompokTaniRepositoryInterface::class, KelompokTaniRepository::class);
        $this->app->when(KelompokTaniService::class)->needs(ManyRelationshipManagement::class)->give(KelompokTaniRepository::class);
        $this->app->when(DesaService::class)->needs(DesaCustomQueryInterface::class)->give(DesaRepository::class);
        $this->app->when(PenyuluhTerdaftarService::class)->needs(PenyuluhTerdaftarCustomQueryInterface::class)->give(PenyuluhTerdaftarRepository::class);
        $this->app->when(LaporanBibitService::class)->needs(CrudInterface::class)->give(LaporanBibitRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LaporanKondisi::observe(LaporanBibitObserver::class);
    }
}
