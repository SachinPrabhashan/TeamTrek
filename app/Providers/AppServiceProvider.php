<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
    public function boot()
    {
        Blade::if('isRootOrAdmin', function(){
            $userRoleID = auth()->user()->role_id;
            return $userRoleID === 1 || $userRoleID === 2;
        });

        Blade::if('isAdmin', function(){
            $userRoleID = auth()->user()->role_id;
            return $userRoleID === 2;
        });
    }
}
