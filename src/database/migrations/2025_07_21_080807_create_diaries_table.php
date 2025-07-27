<?php

declare(strict_types=1);

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
        Schema::create('diaries', function (Blueprint $table) {
            // テーブルのコメントを設定
            $table->comment('日記テーブル');

            // カラムの定義
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->dateTime('entryDatetime')->comment('日記の日時');
            $table->string('title')->nullable()->comment('日記のタイトル');
            $table->text('content')->nullable()->comment('日記の内容');
            $table->timestamps(); // created_at と updated_at カラム

            // 外部キー制約を設定
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diaries');
    }
};