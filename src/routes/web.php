<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;

// Webルートの設定(一旦Laravelのデフォルトページを表示するままにしておく)
Route::get('/', function () {
    return view('welcome');
});

// 日記のルート設定
Route::get('/calendar', function () {
    return view('diary.calendar');
})->name('diary.calendar');
Route::get('/diary/{date}', [DiaryController::class, 'manage'])
    ->name('diary.manage');
Route::post('/diary', [DiaryController::class, 'create'])
    ->name('diary.create');
Route::put('/diary/{diaryId}', [DiaryController::class, 'update'])
    ->name('diary.update');