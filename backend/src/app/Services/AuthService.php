<?php

namespace App\Services;

use App\Contracts\Entities\UserEntityInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Exceptions\LoginException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService implements AuthServiceInterface
{

    public function login(string $login, string $password): UserEntityInterface
    {

        /** @var User|null $user */
        $user = User::where('phone', $login)->orWhere('email', $login)->first();

        if (!$user || !Hash::check($password, $user->getPassword())) {
            throw new LoginException();
        }

        $token = $user->createToken('auth')->plainTextToken;

        $user->setToken($token);

        return $user;
    }

    public function logout(string $token): void
    {
        PersonalAccessToken::findToken($token)?->delete();
    }
}
