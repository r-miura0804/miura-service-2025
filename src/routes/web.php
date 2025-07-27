<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;

// Webルートの設定(一旦Laravelのデフォルトページを表示するままにしておく)
Route::get('/', function () {
    return view('welcome');
});

// 日記のルート設定
Route::get('/diary', function () {
    return view('diary.calendar');
})->name('diary.calendar');
Route::get('/diary/{date}/manage', [DiaryController::class, 'manage'])
    ->name('diary.manage');
Route::post('/diary/createDiary', [DiaryController::class, 'createDiary'])
    ->name('diary.create');
Route::put('/diary/updateDiary/{diaryId}', [DiaryController::class, 'updateDiary'])
    ->name('diary.update');