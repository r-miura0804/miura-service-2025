<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diaries', function (Blueprint $table) {
            // テーブルのコメントを設定
            $table->comment('日記テーブル');

            // カラム定義
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('postedBy')->comment('投稿者のユーザーID');
            $table->date('entryDate')->comment('日記投稿日');
            $table->string('title')->nullable()->comment('日記のタイトル');
            $table->text('content')->nullable()->comment('日記の内容');
            $table->dateTime('createdAt')->comment('作成日時');
            $table->dateTime('updatedAt')->comment('更新日時');

            $table->foreign('postedBy')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diaries');
    }
};
