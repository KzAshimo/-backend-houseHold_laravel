<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Services\User\StoreService as UserStoreService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function store(StoreRequest $request, UserStoreService $service)
    {
        DB::beginTransaction();
        try {
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
}
