<?php

namespace App\Http\Resources\Api\V1;

use App\Contracts\Entities\TaskEntityInterface;
use App\Traits\ChangeResourceStatusesTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TaskEntityInterface $resource
 * @mixin TaskEntityInterface
 */
class TaskShowResource extends JsonResource
{
    use ChangeResourceStatusesTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getID(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'status' => $this->getStatus(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];
    }
}
