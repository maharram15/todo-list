<?php

namespace App\Providers;

use App\Contracts\Entities\UserEntityInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserServiceInterface::class => UserService::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserEntityInterface::class, function ($app) {
            return $app->make('request')->user() ?? new User();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
