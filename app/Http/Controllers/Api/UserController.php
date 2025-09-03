<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\User\ShowResource;
use App\Services\User\StoreService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
// ユーザ新規登録 (デバッグモード)
    public function store(StoreRequest $request, StoreService $service)
    {
        // STEP 1: バリデーション済みのデータを取得できているかログに出力
        $validatedData = $request->validated();
        Log::info('--- User Store Debug Start ---');
        Log::info('[Step 1] Validation passed. Data:', $validatedData);

        DB::beginTransaction();
        Log::info('[Step 2] Database transaction started.');

        try {
            // STEP 2: サービスが呼び出され、ユーザーオブジェクトが返ってくるかログに出力
            $user = $service($validatedData);
            Log::info('[Step 3] Service executed. User object created in memory:', $user->toArray());

            // ★★★ 非常に重要 ★★★
            // Eloquentのイベントがキャンセルしていないかを確認するために、保存の成否をチェック
            if (!$user->exists) {
                Log::error('[CRITICAL] User::create was called, but the model was NOT saved to the database. This is likely due to a model event (creating/saving) returning false.');
            }

            DB::commit();
            Log::info('[Step 4] Database transaction committed.');

            Log::info('--- User Store Debug End ---');
            return response()->json([
                'result' => true,
                'user' => $user,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            // STEP 3: エラーが発生した場合、その内容を詳細にログに出力
            Log::error('[FATAL] An exception occurred during the user store process.', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
    // ユーザ情報取得
    public function show()
    {
        $user = Auth::user();

        // データ返却：resourceクラス使用
        return new ShowResource($user);
    }
}
