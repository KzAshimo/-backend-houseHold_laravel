<?php

namespace Tests\Feature\Export;

use App\Models\Export;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_indexExport_成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        //ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/export/index');

        $exports = Export::with(['user'])->get();

        $response->assertStatus(200);

        foreach ($exports as $export) {
            $response->assertJsonFragment([
                'id' => $export->id,
                'user' => $export->user->name,
                'type' => $export->type,
                'status' => $export->status,
                'period_from' => $export->period_from,
                'period_to' => $export->period_to,
                'file_name' => $export->file_name,
                'file_path' => $export->file_path,
                'created_at' => $export->created_at,
                'updated_at' => $export->updated_at,
            ]);
        }
    }
}
