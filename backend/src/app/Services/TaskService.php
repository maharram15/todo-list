<?php

namespace App\Services;

use App\Contracts\Entities\TaskEntityInterface;
use App\Contracts\Entities\UserEntityInterface;
use App\Contracts\Services\TaskServiceInterface;
use App\Jobs\Api\V1\TaskCreateJob;
use App\Jobs\Api\V1\TaskDeleteJob;
use App\Jobs\Api\V1\TaskUpdateJob;

class TaskService implements TaskServiceInterface
{

    public function create(UserEntityInterface $user, TaskEntityInterface $entity): TaskEntityInterface
    {
        $entity->setCreatedAt(now());
        $entity->setUpdatedAt(now());
        $entity->setUserId($user->getId());

        TaskCreateJob::dispatch($user, $entity);

        return $entity;
    }

    public function update(UserEntityInterface $user, TaskEntityInterface $entity): TaskEntityInterface
    {
        $entity->setUpdatedAt(now());

        TaskUpdateJob::dispatch($user, $entity);

        return $entity;
    }

    public function delete(UserEntityInterface $user, string $entity): void
    {
        TaskDeleteJob::dispatch($user, $entity);
    }
}
