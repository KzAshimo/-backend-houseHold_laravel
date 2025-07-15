<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->comment('ユーザid');
            $table->string('type')->comment('出力対象 収入 / 支出 / 両方'); // Enum修正予定
            $table->date('period_from')->comment('開始日(集計対象)');
            $table->date('period_to')->comment('終了日(集計対象)');
            $table->string('file_name', 50)->nullable()->comment('ファイル名(任意)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exports');
    }
};
