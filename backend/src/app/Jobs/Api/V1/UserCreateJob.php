<?php

namespace App\Jobs\Api\V1;

use App\Contracts\Entities\UserEntityInterface;
use App\Events\UserCreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected UserEntityInterface $user
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->save();

        UserCreateEvent::dispatch($this->user);
    }
}
