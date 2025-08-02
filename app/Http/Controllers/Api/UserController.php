<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\User\ShowResource;
use App\Services\User\StoreService as UserStoreService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // ユーザ新規登録
    public function store(StoreRequest $request, UserStoreService $service)
    {
        DB::beginTransaction();
        try {
            // ユーザデータを一時保存：serviceクラス使用
            $user = $service($request->validated());

            DB::commit();

            return response()->json([
                'result' => true,
                'user' => $user,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error();
            throw $e;
        }
    }

    // ユーザ情報取得
    public function show()
    {
        $user = Auth::user();
        return new ShowResource($user);
    }
}
