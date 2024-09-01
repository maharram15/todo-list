<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Entities\TaskEntityInterface;
use App\Contracts\Entities\UserEntityInterface;
use App\Contracts\FiltersInterface;
use App\Contracts\Repository\TaskRepositoryInterface;
use App\Contracts\Services\TaskServiceInterface;
use App\Contracts\SortsInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TaskStoreRequest;
use App\Http\Requests\Api\V1\TaskUpdateRequest;
use App\Http\Resources\Api\V1\TaskListResource;
use App\Http\Resources\Api\V1\TaskShowResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository,
        protected TaskServiceInterface $taskService,
    ){}

    public function index(UserEntityInterface $user, Request $request, FiltersInterface $filters, SortsInterface $sorts): JsonResource
    {
        $perPage = $request->query('per_page', 20);
        $page = $request->query('page', 1);

        $tasks = $this->taskRepository->paginate($user, $perPage, $page, $filters, $sorts);

        return TaskListResource::collection($tasks);
    }

    public function show(UserEntityInterface $user, string $id): TaskShowResource
    {
        $task = $this->taskRepository->findOrFail($user, $id);

        return new TaskShowResource($task);
    }

    public function store(UserEntityInterface $user, TaskStoreRequest $request, TaskEntityInterface $entity): TaskShowResource
    {
        $validated = $request->validated();

        $entity->setID($validated['id'])
            ->setTitle($validated['title'])
            ->setDescription($validated['description'] ?? null)
            ->setStatus($validated['status'] ?? null);

        $this->taskService->create($user, $entity);

        return TaskShowResource::create($entity, 201);
    }

    public function update(string $task_id, UserEntityInterface $user, TaskUpdateRequest $request): TaskShowResource
    {
        $validated = $request->validated();
        $entity = $this->taskRepository->findOrFail($user, $task_id);

        if (!empty($validated['title'])) {
            $entity->setTitle($validated['title']);
        }
        $entity->setDescription($validated['description'] ?? null);
        if (!empty($validated['status'])) {
            $entity->setStatus($validated['status']);
        }

        $this->taskService->update($user, $entity);

        return TaskShowResource::create($entity, 202);
    }

    public function destroy(UserEntityInterface $user, string $task_id): Response
    {
        $this->taskService->delete($user, $task_id);

        return \response()->noContent();
    }
}
