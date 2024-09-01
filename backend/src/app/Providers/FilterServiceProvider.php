<?php

namespace App\Providers;

use App\Contracts\FiltersInterface;
use App\Normalizers\FilterRequestNormalizer;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(FiltersInterface::class, static function ($app): FiltersInterface {
            return $app->make(FilterRequestNormalizer::class)->normalize();
        });

        /*
         * when need other filters creator for controller can use this construction
         * $this->app->when(NeededController::class)
         *   ->needs(FiltersInterface::class)
         *   ->give(static function () {
         *       return $app->make(OtherFilterNormalizer::class)->normalize();
         *   });
         */
    }

    public function provides(): array
    {
        return [
            FiltersInterface::class
        ];
    }
}
