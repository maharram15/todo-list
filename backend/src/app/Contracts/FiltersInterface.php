<?php

namespace App\Contracts;

use App\Enums\FilterGroupConditionEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface FiltersInterface
{
    public function addFilter(FilterInterface $filter, FilterGroupConditionEnum $groupCondition = FilterGroupConditionEnum::AND, ?string $filterGroup = null): self;

    public function apply(Builder $builder): void;
}
