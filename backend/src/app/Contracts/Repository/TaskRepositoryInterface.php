<?php

namespace App\Contracts\Repository;

use App\Contracts\Entities\TaskEntityInterface;
use App\Contracts\Entities\UserEntityInterface;
use App\Contracts\FiltersInterface;
use App\Contracts\SortsInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function all(UserEntityInterface $user, ?FiltersInterface $filters = null, ?SortsInterface $sorts = null): iterable|Collection;

    public function paginate(UserEntityInterface $user, int $per_page, int $page = 1, ?FiltersInterface $filters = null, ?SortsInterface $sorts = null): Paginator;

    public function find(UserEntityInterface $user, string $id): ?TaskEntityInterface;

    public function findOrFail(UserEntityInterface $user, string $id): TaskEntityInterface;
}
