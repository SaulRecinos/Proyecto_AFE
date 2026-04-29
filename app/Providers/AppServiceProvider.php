<?php

namespace App\Providers;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Support\Facades\Route;
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
        Route::bind('role', fn (string $value) => Roles::whereKey($value)->firstOrFail());
        Route::bind('permission', fn (string $value) => Permissions::whereKey($value)->firstOrFail());
    }
}
