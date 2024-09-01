<?php

namespace App\Repositories;

use App\Contracts\Entities\TaskEntityInterface;
use App\Contracts\Entities\UserEntityInterface;
use App\Contracts\FiltersInterface;
use App\Contracts\Repository\TaskRepositoryInterface;
use App\Contracts\SortsInterface;
use App\Models\Task;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class TaskEloquentRepository implements TaskRepositoryInterface
{
    public function all(UserEntityInterface $user, ?FiltersInterface $filters = null, ?SortsInterface $sorts = null): iterable|Collection
    {
        return $this->baseQuery($user, $filters, $sorts)
            ->get();
    }

    public function paginate(UserEntityInterface $user, int $per_page, int $page = 1, ?FiltersInterface $filters = null, ?SortsInterface $sorts = null): Paginator
    {
        return $this->baseQuery($user, $filters, $sorts)
            ->paginate(perPage: $per_page, page: $page);
    }

    public function find(UserEntityInterface $user, string $id): ?TaskEntityInterface
    {
        try {
            return $this->findOrFail($user, $id);
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }

    public function findOrFail(UserEntityInterface $user, string $id): TaskEntityInterface
    {
        return $this->baseQuery($user)
            ->findOrFail($id);
    }

    private function baseQuery(UserEntityInterface $user, ?FiltersInterface $filters = null, ?SortsInterface $sorts = null): Builder
    {
        return Task::where('user_id', $user->getID())
            ->when($filters, function ($query, FiltersInterface $filters) {
                $filters->apply($query);
            })
            ->when($sorts, function ($query, SortsInterface $sorts) {
                $sorts->apply($query);
            });
    }
}
