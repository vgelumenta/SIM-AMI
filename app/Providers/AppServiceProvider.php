<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton('user_role', function () {
            return Auth::check() ? Cache::get('user_role_' . Auth::id()) : null;
        });
        
        View::composer('*', function ($view) {
            $userRole = Cache::get('user_role_' . Auth::id());

            $view->with(compact('userRole'));
        });
    }
}
