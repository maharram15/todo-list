<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Entities\UserEntityInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserStoreRequest;
use App\Http\Resources\Api\V1\UserShowResource;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct(
        protected readonly UserServiceInterface $userService
    ){}

    public function store(UserStoreRequest $request, UserEntityInterface $entity): UserShowResource
    {
        $validated = $request->validated();

        $entity->setID($validated['id'] ?? Str::uuid()->toString())
            ->setName($validated['name'])
            ->setEmail($validated['email'] ?? null)
            ->setPassword($validated['password'])
            ->setPhone($validated['phone']);

        $entity = $this->userService->create($entity);

        return UserShowResource::create($entity);
    }
}
