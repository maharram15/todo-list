<?php

namespace App\Jobs\Api\V1;

use App\Contracts\Entities\TaskEntityInterface;
use App\Contracts\Entities\UserEntityInterface;
use App\Contracts\Repository\TaskRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TaskDeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected UserEntityInterface $user,
        protected string $taskID
    ){}

    /**
     * Execute the job.
     */
    public function handle(TaskRepositoryInterface $repository): void
    {
        $task = $repository->find($this->user, $this->taskID);

        if (!$task) {
            return;
        }
        $task->delete();
        TaskDeleteJob::dispatch($this->user, $task);
    }
}
