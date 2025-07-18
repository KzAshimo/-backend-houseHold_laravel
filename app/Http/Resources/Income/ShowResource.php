<?php

namespace App\Http\Resources\Income;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user->name,
            'category' => $this->category->name,
            'amount' => $this->amount,
            'content' => $this->content,
            'memo' => $this->memo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
