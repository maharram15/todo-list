<?php

namespace App\Models;

use App\Casts\UUIDCast;
use App\Contracts\Entities\TaskEntityInterface;
use App\Enums\TaskStatusEnum;
use App\Traits\HasUUIDID;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $title
 * @property string|null $description
 * @property TaskStatusEnum $status
 * @property string $user_id
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 *
 */
class Task extends Model implements TaskEntityInterface
{
    use HasFactory;
    use HasUUIDID;

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => TaskStatusEnum::class,
        'user_id' => UUIDCast::class,
    ];


    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): TaskEntityInterface
    {
        return $this->fill(['title' => $title]);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): TaskEntityInterface
    {
        return $this->fill(['description' => $description]);
    }

    public function getStatus(): TaskStatusEnum
    {
        return $this->status;
    }

    public function setStatus(TaskStatusEnum|string|null $status): TaskEntityInterface
    {
        $status = match (true) {
            default => TaskStatusEnum::DRAFT,
            (bool) TaskStatusEnum::tryFrom($status) => TaskStatusEnum::from($status),
        };
        return $this->fill(['status' => $status ?? TaskStatusEnum::DRAFT]);
    }

    public function getCreatedAt(): ?CarbonInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?CarbonInterface
    {
        return $this->updated_at;
    }

    public function setUserId(string $id): TaskEntityInterface
    {
        return $this->fill(['user_id' => $id]);
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }


}
