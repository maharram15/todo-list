<?php

namespace App\Http\Resources\Api\V1;

use App\Contracts\Entities\TaskEntityInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TaskEntityInterface $resource
 * @mixin TaskEntityInterface
 */
class TaskListResource extends JsonResource
{
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
            'status' => $this->getStatus(),
        ];
    }
}
