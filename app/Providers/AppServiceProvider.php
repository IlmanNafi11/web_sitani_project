<?php

namespace App\Providers;

use App\Models\LaporanKondisi;
use App\Observers\LaporanBibitObserver;
use App\Repositories\AdminRepository;
use App\Repositories\BibitRepository;
use App\Repositories\DesaRepository;
use App\Repositories\Interfaces\AuthInterface;
use App\Repositories\Interfaces\BibitRepositoryInterface;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\DesaRepositoryInterface;
use App\Repositories\Interfaces\KelompokTaniRepositoryInterface;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Repositories\Interfaces\LaporanRepositoryInterface;
use App\Repositories\Interfaces\ManyRelationshipManagement;
use App\Repositories\Interfaces\NotificationInterface;
use App\Repositories\Interfaces\PenyuluhRepositoryInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\KecamatanRepository;
use App\Repositories\KelompokTaniRepository;
use App\Repositories\KomoditasRepository;
use App\Repositories\LaporanBibitRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\PenyuluhRepository;
use App\Repositories\PenyuluhTerdaftarRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Services\AdminService;
use App\Services\BibitService;
use App\Services\DesaService;
use App\Services\KecamatanService;
use App\Services\KelompokTaniService;
use App\Services\KomoditasService;
use App\Services\LaporanBibitService;
use App\Services\NotificationService;
use App\Services\PenyuluhService;
use App\Services\PenyuluhTerdaftarService;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(KecamatanService::class)->needs(CrudInterface::class)->give(KecamatanRepository::class);
        $this->app->when(DesaService::class)->needs(CrudInterface::class)->give(DesaRepository::class);
        $this->app->when(KomoditasService::class)->needs(CrudInterface::class)->give(KomoditasRepository::class);
        $this->app->when(BibitService::class)->needs(CrudInterface::class)->give(BibitRepository::class);
        $this->app->when(PenyuluhTerdaftarService::class)->needs(CrudInterface::class)->give(PenyuluhTerdaftarRepository::class);
        $this->app->when(KelompokTaniService::class)->needs(CrudInterface::class)->give(KelompokTaniRepository::class);
        $this->app->when(KelompokTaniService::class)->needs(ManyRelationshipManagement::class)->give(KelompokTaniRepository::class);
        $this->app->when(DesaService::class)->needs(DesaRepositoryInterface::class)->give(DesaRepository::class);
        $this->app->when(PenyuluhTerdaftarService::class)->needs(PenyuluhTerdaftarRepositoryInterface::class)->give(PenyuluhTerdaftarRepository::class);
        $this->app->when(LaporanBibitService::class)->needs(CrudInterface::class)->give(LaporanBibitRepository::class);
        $this->app->when(AdminService::class)->needs(CrudInterface::class)->give(AdminRepository::class);
        $this->app->when(UserService::class)->needs(AuthInterface::class)->give(UserRepository::class);
        $this->app->when(RoleService::class)->needs(CrudInterface::class)->give(RoleRepository::class);
        $this->app->when(RoleService::class)->needs(RoleRepositoryInterface::class)->give(RoleRepository::class);
        $this->app->when(PenyuluhService::class)->needs(CrudInterface::class)->give(PenyuluhRepository::class);
        $this->app->when(KelompokTaniService::class)->needs(KelompokTaniRepositoryInterface::class)->give(KelompokTaniRepository::class);
        $this->app->when(LaporanBibitService::class)->needs(LaporanRepositoryInterface::class)->give(LaporanBibitRepository::class);
        $this->app->when(BibitService::class)->needs(BibitRepositoryInterface::class)->give(BibitRepository::class);
        $this->app->when(KomoditasService::class)->needs(KomoditasRepositoryInterface::class)->give(KomoditasRepository::class);
        $this->app->when(PenyuluhService::class)->needs(PenyuluhRepositoryInterface::class)->give(PenyuluhRepository::class);
        $this->app->when(NotificationService::class)->needs(NotificationInterface::class)->give(NotificationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LaporanKondisi::observe(LaporanBibitObserver::class);
        if (\App::environment('production')){
            \URL::forceScheme('https');
        }
    }
}
