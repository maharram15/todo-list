<?php

namespace App\Services;

use App\Contracts\Entities\UserEntityInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Jobs\Api\V1\UserCreateJob;

class UserService implements UserServiceInterface
{

    public function create(UserEntityInterface $entity): UserEntityInterface
    {
        $entity->setCreatedAt(now());
        $entity->setUpdatedAt(now());

        UserCreateJob::dispatch($entity);

        return $entity;
    }
}
