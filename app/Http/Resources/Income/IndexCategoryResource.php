<?php

namespace App\Http\Resources\Income;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->whenLoaded('category', fn() => $this->category->id),
            'name' => $this->whenLoaded('category', fn() => $this->category->name),
        ];
    }
}
