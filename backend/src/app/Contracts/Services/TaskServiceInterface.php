<?php

namespace App\Contracts\Services;

use App\Contracts\Entities\TaskEntityInterface;
use App\Contracts\Entities\UserEntityInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface TaskServiceInterface
{
    public function create(UserEntityInterface $user, TaskEntityInterface $entity): TaskEntityInterface;

    public function update(UserEntityInterface $user, TaskEntityInterface $entity): TaskEntityInterface;

    public function delete(UserEntityInterface $user, string $entity): void;
}
