<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        \View::composer('components.partials.navbar', function ($view) {
            $user = \Auth::user();

            if ($user) {
                $user->load('admin:id,user_id,nama');
                $role = $user->getRoleNames();
            }

            $view->with([
                'user' => $user,
                'role' => $role ?? collect(),
            ]);
        });
    }
}
