<?php

namespace Tests\Feature\Export;

use App\Models\Export;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_export_成功(): void
    {
        // ユーザデータ取得 ログイン処理
        $user = User::first();
        $this->actingAs($user);

        // ストレージのモック
        Storage::fake('local');

        $export = Export::create([
            'user_id'     => $user->id,
            'type'        => 'income',
            'period_from' => '2025-01-01',
            'period_to'   => '2025-12-31',
            'file_name'   => 'test_export_file',
            'status'      => 'pending',
        ]);

        $response = $this->postJson("api/v1/export/$export->id");

        $response->assertStatus(200);
        // DB更新を確認
        $this->assertDatabaseHas('exports', [
            'id'      => $export->id,
            'status'  => 'complete',
        ]);

        // ファイルの保存を確認
        Storage::disk('local')->exists('exports/test_export_file.csv');
    }
}
