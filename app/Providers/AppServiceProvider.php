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
        Blade::if('Root', function(){
            $userRoleID = auth()->user()->role_id;
            return $userRoleID === 1;
        });

        Blade::if('Admin', function(){
            $userRoleID = auth()->user()->role_id;
            return $userRoleID === 2 || $userRoleID === 1;
        });

        Blade::if('Employee', function(){
            $userRoleID = auth()->user()->role_id;
            return $userRoleID === 3 || $userRoleID === 1;
        });

        Blade::if('Client', function(){
            $userRoleID = auth()->user()->role_id;
            return $userRoleID === 4 || $userRoleID === 1;
        });

        Blade::if('RootOrAdmin', function(){
            $userRoleID = auth()->user()->role_id;
            return $userRoleID === 1 || $userRoleID === 2;
        });

        Blade::if('AdminOrEmployee', function(){
            $userRoleID = auth()->user()->role_id;
            return $userRoleID === 2 || $userRoleID === 3 || $userRoleID === 1;
        });

        Blade::if('AdminOrClient', function(){
            $userRoleID = auth()->user()->role_id;
            return $userRoleID === 2 || $userRoleID === 4 || $userRoleID === 1;
        });
    }
}
