<?php

namespace App\Traits;

use App\Casts\UUIDCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin Model
 */
trait HasUUIDID
{
    protected static function bootHasUUIDID(): void
    {
        static::saving(function (Model $model) {
            $model->{$model->getKeyName()} ??= Str::uuid()->toString();
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    public function initializeHasUUIDID(): void
    {
        if (!in_array($this->getKeyName(), $this->fillable, true)) {
            $this->fillable[] = $this->getKeyName();
        }

        if (!isset($this->casts[$this->getKeyName()])) {
            $this->casts[$this->getKeyName()] = UUIDCast::class;
        }
    }

    public function setID(string $id): self
    {
        return $this->fill([$this->getKeyName()=> $id]);
    }

    public function getID(): string
    {
        return $this->{$this->getKeyName()};
    }
}
