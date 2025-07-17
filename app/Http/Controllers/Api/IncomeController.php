<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Income\IndexResource;
use App\Services\Income\IndexService;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeController extends Controller
{
    // 収入一覧
    public function index(IndexService $service): JsonResource
    {
        $incomes = $service();

        return new IndexResource($incomes);
    }
}
