<?php

namespace App\Contracts;

use App\Enums\SortDirectionEnum;

interface SortInterface
{
    public function setColumn(string $column): self;

    public function getColumn(): string;

    public function setDirection(SortDirectionEnum $direction): self;

    public function getDirection(): SortDirectionEnum;
}
