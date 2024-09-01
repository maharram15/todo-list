<?php

namespace App\Contracts\Entities;

use Carbon\CarbonInterface;

interface UserEntityInterface
{
    public function getID(): string;

    public function setID(string $id): self;

    public function getName(): string;

    public function setName(string $name): self;

    public function getPhone(): string;

    public function setPhone(string $phone): self;

    public function getEmail(): string;

    public function setEmail(string $email): self;

    public function getPassword(): string;

    public function setPassword(string $password): self;

    public function getToken(): string;

    public function setToken(string $token): self;

    public function getCreatedAt(): ?CarbonInterface;

    public function getUpdatedAt(): ?CarbonInterface;

    /*
     * setters for created and updated with laravel style @see HasTimstamps
     */
    public function setCreatedAt($value);

    public function setUpdatedAt($value);
}
