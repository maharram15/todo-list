<?php

namespace App\Filters;

use App\Contracts\FilterInterface;
use App\Enums\FilterConditionEnum;

class Filter implements FilterInterface
{
    protected ?FilterConditionEnum $condition = null;
    protected string $column;
    public function __construct(
        string $column,
        protected mixed $value
    ) {
        $this->load($column);

        if (is_array($value)) {
            $this->condition = FilterConditionEnum::IN_ARRAY;
        }
    }

    private function load(string $column): void
    {
        $this->condition = FilterConditionEnum::tryFrom(mb_substr($column, 0, 1));
        if (!empty($this->condition)) {
            $this->column = mb_substr($column, 1);
            return;
        }
        $this->condition ??= FilterConditionEnum::tryFrom(mb_substr($column, 0, 2));
        if (!empty($this->condition)) {
            $this->column = mb_substr($column, 1);
            return;
        }
        $this->condition ??= FilterConditionEnum::EQUAL;
    }

    public function getCondition(): string
    {
        return $this->condition->toSqlCondition();
    }

    public function getField(): string
    {
        return $this->column;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

}
