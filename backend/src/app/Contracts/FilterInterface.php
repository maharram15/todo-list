<?php

namespace App\Contracts;

interface FilterInterface
{
    public function getCondition(): string;

    public function getField(): string;

    public function getValue(): mixed;
}
