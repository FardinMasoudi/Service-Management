<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'user' => $this->when($this->user()->isNot(auth()->user()), $this->user->name),
            'description' => $this->description,
            'service' => $this->service->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
