<?php

namespace App\Sorts;

use App\Contracts\SortInterface;
use App\Enums\SortDirectionEnum;

class Sort implements SortInterface
{
    protected SortDirectionEnum $direction;
    protected string $column;
    public function __construct(string $sort)
    {
        if (str_starts_with($sort, '-')) {
            $column = substr($sort, 1);
            $direction = SortDirectionEnum::ASC;
        } else {
            $column = $sort;
            $direction = SortDirectionEnum::DESC;
        }
        $this->setDirection($direction);
        $this->setColumn($column);
    }

    public function setColumn(string $column): SortInterface
    {
        $this->column = $column;

        return $this;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function setDirection(SortDirectionEnum $direction): SortInterface
    {
        $this->direction = $direction;

        return $this;
    }

    public function getDirection(): SortDirectionEnum
    {
        return $this->direction;
    }
}
