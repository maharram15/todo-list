<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Services\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SessionStoreRequest;
use App\Http\Resources\Api\V1\SessionShowResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SessionController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ){}

    public function store(SessionStoreRequest $request): SessionShowResource
    {
        $validated = $request->validated();

        $entity = $this->authService->login($validated['login'], $validated['password']);

        return new SessionShowResource($entity);
    }

    public function destroy(Request $request): Response
    {
        $this->authService->logout($request->bearerToken());

        return response()->noContent();
    }
}
