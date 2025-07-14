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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 50)->comment('タイトル');
            $table->string('content', 255)->comment('本文');
            $table->string('type')->comment('表示形式(1回 / 毎回)'); //Enumに修正予定
            $table->date('start_date')->comment('表示開始日');
            $table->date('end_date')->comment('表示終了日');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
