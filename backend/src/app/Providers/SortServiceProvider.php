<?php

namespace App\Providers;

use App\Contracts\SortsInterface;
use App\Normalizers\SortRequestNormalizer;
use App\Sorts\Sorts;
use Illuminate\Support\ServiceProvider;

class SortServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SortsInterface::class, function ($app) {
            return $app->make(SortRequestNormalizer::class)->normalize();
        });
    }

    public function provides(): array
    {
        return [SortsInterface::class];
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
