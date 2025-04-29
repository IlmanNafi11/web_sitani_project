<?php

namespace App\Providers;

use App\Events\OtpGenerated;
use App\Listeners\SendOtpNotification;
use App\Models\LaporanKondisi;
use App\Observers\LaporanBibitObserver;
use App\Repositories\AdminRepository;
use App\Repositories\BibitRepository;
use App\Repositories\DesaRepository;
use App\Repositories\Interfaces\AuthInterface;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\DesaCustomQueryInterface;
use App\Repositories\Interfaces\KelompokTaniCustomQueryInterface;
use App\Repositories\Interfaces\LaporanCustomQueryInterface;
use App\Repositories\Interfaces\ManyRelationshipManagement;
use App\Repositories\Interfaces\PenyuluhTerdaftarCustomQueryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\KecamatanRepository;
use App\Repositories\KelompokTaniRepository;
use App\Repositories\KomoditasRepository;
use App\Repositories\LaporanBibitRepository;
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
        $this->app->when(DesaService::class)->needs(DesaCustomQueryInterface::class)->give(DesaRepository::class);
        $this->app->when(PenyuluhTerdaftarService::class)->needs(PenyuluhTerdaftarCustomQueryInterface::class)->give(PenyuluhTerdaftarRepository::class);
        $this->app->when(LaporanBibitService::class)->needs(CrudInterface::class)->give(LaporanBibitRepository::class);
        $this->app->when(AdminService::class)->needs(CrudInterface::class)->give(AdminRepository::class);
        $this->app->when(UserService::class)->needs(AuthInterface::class)->give(UserRepository::class);
        $this->app->when(RoleService::class)->needs(CrudInterface::class)->give(RoleRepository::class);
        $this->app->when(RoleService::class)->needs(RoleRepositoryInterface::class)->give(RoleRepository::class);
        $this->app->when(PenyuluhService::class)->needs(CrudInterface::class)->give(PenyuluhRepository::class);
        $this->app->when(KelompokTaniService::class)->needs(KelompokTaniCustomQueryInterface::class)->give(KelompokTaniRepository::class);
        $this->app->when(LaporanBibitService::class)->needs(LaporanCustomQueryInterface::class)->give(LaporanBibitRepository::class);
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
