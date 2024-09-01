<?php

namespace App\Contracts;

use Illuminate\Contracts\Database\Eloquent\Builder;

interface SortsInterface
{
    public function put(SortInterface $sort): self;

    public function apply(Builder $builder): void;
}
