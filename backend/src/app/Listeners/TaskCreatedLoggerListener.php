<?php

namespace App\Listeners;

use App\Contracts\Tasks\TasksLoggingInterface;
use App\Events\TaskCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class TaskCreatedLoggerListener implements TasksLoggingInterface
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected LoggerInterface $logger
    ){}

    /**
     * Handle the event.
     */
    public function handle(TaskCreatedEvent $event): void
    {
        $this->logger->notice('User create task', [
            'user_id' => $event->user->getId(),
            'task_id' => $event->task->getId(),
        ]);
    }
}
