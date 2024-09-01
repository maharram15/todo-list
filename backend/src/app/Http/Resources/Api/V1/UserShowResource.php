<?php

namespace App\Http\Resources\Api\V1;

use App\Traits\ChangeResourceStatusesTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserShowResource extends JsonResource
{
    use ChangeResourceStatusesTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
