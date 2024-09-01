<?php

namespace App\Contracts\Services;

use App\Contracts\Entities\UserEntityInterface;

interface AuthServiceInterface
{
    public function login(string $login, string $password): UserEntityInterface;

    public function logout(string $token): void;
}
