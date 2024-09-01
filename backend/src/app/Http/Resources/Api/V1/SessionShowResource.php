<?php

namespace App\Http\Resources\Api\V1;

use App\Contracts\Entities\UserEntityInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserEntityInterface
 */
class SessionShowResource extends JsonResource
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
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'token' => $this->getToken(),
        ];
    }
}
