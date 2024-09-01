<?php

namespace App\Casts;

use App\Exceptions\BadUUIDException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UUIDCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     * @throws BadUUIDException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!Str::isUuid($value)) {
            throw new BadUUIDException($value);
        }
        return $value;
    }
}
