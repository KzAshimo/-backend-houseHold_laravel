<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\IndexResource;
use App\Services\Category\IndexService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    // --- カテゴリ一覧取得 ---
    public function index(IndexService $service): JsonResource
    {
        // カテゴリ一覧データ取得：serviceクラス使用
        $categories = $service();

        // データを整形し返却：resourceクラス使用
        return IndexResource::collection($categories);
    }
}
