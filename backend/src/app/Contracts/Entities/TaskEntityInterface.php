<?php

namespace App\Contracts\Entities;

use App\Enums\TaskStatusEnum;
use Carbon\CarbonInterface;

interface TaskEntityInterface
{
    public function getID(): string;

    public function setID(string $id): self;

    public function getTitle(): string;

    public function setTitle(string $title): self;

    public function getDescription(): ?string;

    public function setDescription(?string $description): self;

    public function getStatus(): TaskStatusEnum;

    public function setStatus(TaskStatusEnum|string|null $status): self;

    public function getCreatedAt(): ?CarbonInterface;

    public function getUpdatedAt(): ?CarbonInterface;

    /*
     * setters for created and updated with laravel style @see HasTimstamps
     */
    public function setCreatedAt($value);

    public function setUpdatedAt($value);

    public function setUserId(string $id): self;

    public function getUserId(): string;
}
