<?php

namespace App\Providers;

use App\Contracts\Repository\TaskRepositoryInterface;
use App\Contracts\Services\TaskServiceInterface;
use App\Contracts\Tasks\TasksLoggingInterface;
use App\Repositories\TaskEloquentRepository;
use App\Services\TaskService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class TaskServiceProvider extends ServiceProvider
{
    public array $bindings = [
        TaskServiceInterface::class => TaskService::class,
        TaskRepositoryInterface::class => TaskEloquentRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app
            ->when(TasksLoggingInterface::class)
            ->needs(LoggerInterface::class)
            ->give(static function () {
                return Log::channel('tasks');
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
