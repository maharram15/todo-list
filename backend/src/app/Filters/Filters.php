<?php

namespace App\Filters;

use App\Contracts\FilterInterface;
use App\Contracts\FiltersInterface;
use App\Enums\FilterGroupConditionEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Filters implements FiltersInterface
{
    private const BASE_FILTER_GROUP = 'base';

    protected array $filters = [];

    public function addFilter(FilterInterface $filter, FilterGroupConditionEnum $groupCondition = FilterGroupConditionEnum::AND, ?string $filterGroup = null): FiltersInterface
    {
        $this->filters[$filterGroup ?? self::BASE_FILTER_GROUP][] = [
            'filter' => $filter,
            'boolean' => $groupCondition->value,
        ];

        return $this;
    }

    public function apply(Builder $builder): void
    {
        /**
         * @var string $filterGroup
         * @var array<int, array<string, FilterInterface|string>> $filters
         */
        foreach ($this->filters as $filters) {
            foreach ($filters as $filter) {
                $builder->where(
                    static function (Builder $filterBuilder) use ($filter) {
                        return $filterBuilder->where(
                            $filter['filter']->getField(),
                            $filter['filter']->getCondition(),
                            $filter['filter']->getValue(),
                            $filter['boolean']
                        );
                    }
                );
            }
        }
    }
}
