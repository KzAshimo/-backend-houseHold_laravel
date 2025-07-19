<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user->name,
            'category' => $this->category->name,
            'amount' => $this->amount,
            'memo' => $this->memo,
            'created_at' => $this->created_at,
            'update_at' => $this->updated_at,
        ];
    }
}
