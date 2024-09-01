<?php

namespace App\Contracts\Services;

use App\Contracts\Entities\UserEntityInterface;

interface UserServiceInterface
{
    public function create(UserEntityInterface $entity): UserEntityInterface;
}
