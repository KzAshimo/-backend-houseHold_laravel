<?php

namespace App\Http\Resources\Income;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'category' => $this->whenLoaded('category', fn() => $this->category->name),
        ];
    }
}
