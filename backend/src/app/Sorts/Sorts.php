<?php

namespace App\Sorts;

use App\Contracts\SortInterface;
use App\Contracts\SortsInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Sorts implements SortsInterface
{
    protected array $sorts = [];

    public function put(SortInterface $sort): SortsInterface
    {
        $this->sorts[$sort->getColumn()] = $sort;

        return $this;
    }

    public function apply(Builder $builder): void
    {
        foreach ($this->sorts as $sort) {
            $builder->orderBy($sort->getColumn(), $sort->getDirection()->value);
        }
    }
}
