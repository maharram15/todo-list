<?php

namespace App\Providers;

use App\Contracts\Services\AuthServiceInterface;
use App\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AuthServiceInterface::class => AuthService::class,
    ];

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
        //
    }
}
