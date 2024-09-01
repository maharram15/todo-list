<?php

namespace App\Listeners;

use App\Events\UserCreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UserCreateLoggerListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {}

    /**
     * Handle the event.
     */
    public function handle(UserCreateEvent $event): void
    {
        Log::notice('User was created', [
            'user_id' => $event->user->id,
        ]);
    }
}
