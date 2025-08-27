<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->comment('ユーザid');
            $table->foreignId('category_id')->constrained()->comment('支出カテゴリ');
            $table->integer('amount')->comment('金額');
            $table->string('content', 50)->comment('支出内訳');
            $table->string('memo', 255)->nullable()->comment('メモ');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
