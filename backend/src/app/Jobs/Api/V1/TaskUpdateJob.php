<?php

namespace App\Jobs\Api\V1;

use App\Contracts\Entities\TaskEntityInterface;
use App\Contracts\Entities\UserEntityInterface;
use App\Events\TaskUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TaskUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected UserEntityInterface $user,
        protected TaskEntityInterface $task
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->task->save();

        TaskUpdateEvent::dispatch($this->user, $this->task);
    }
}
