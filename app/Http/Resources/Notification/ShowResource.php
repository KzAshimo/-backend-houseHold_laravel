<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
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
            'user' => $this->whenLoaded('user', fn() => $this->user->name),
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];
    }
}
