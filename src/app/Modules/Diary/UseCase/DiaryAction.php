<?php

declare(strict_types=1);

namespace App\Modules\Diary\UseCase;

use App\Models\Diary\Diary;
use App\Modules\Diary\Exceptions\DiaryActionException;
use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DiaryAction
{
    /**
     * 日記を新規作成する
     * @param array<string, mixed> $validatedData バリデーション済みのデータ
     * @param int $userId ユーザーID
     * @throws DiaryActionException 日記の作成に失敗した場合
     */
    public function create(array $validatedData, int $userId): void
    {
        try {
            $entryDatetime = Carbon::parse($validatedData['entry_datetime']);

            Diary::create([
                'user_id' => $userId,
                'entryDatetime' => $entryDatetime,
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
            ]);

        } catch (QueryException $e) {
            Log::error('日記の作成中にDBエラーが発生: ' . $e->getMessage(), ['user_id' => $userId, 'data' => $validatedData]);
            throw new DiaryActionException('日記の作成に失敗しました。（データベースエラー）', 500, $e);
        } catch (Throwable $e) {
            // Carbon::parse() が例外をスローした場合など、その他のエラー
            Log::error('日記の作成中に予期せぬエラーが発生: ' . $e->getMessage(), ['user_id' => $userId, 'data' => $validatedData]);
            throw new DiaryActionException('日記の作成に失敗しました。（予期せぬエラー）', 500, $e);
        }
    }

    /**
     * 日記の更新を実行する
     * @param array<string, mixed> $validatedData バリデーション済みのデータ
     * @param Diary $diary 更新対象の日記モデル
     * @throws DiaryActionException 日記の更新に失敗した場合
     */
    public function update(array $validatedData, Diary $diary): void
    {
        try {
            $diary->title = $validatedData['title'];
            $diary->content = $validatedData['content'];
            $diary->save();

        } catch (QueryException $e) {
            Log::error('日記の更新中にDBエラーが発生: ' . $e->getMessage(), ['diary_id' => $diary->id, 'data' => $validatedData]);
            throw new DiaryActionException('日記の更新に失敗しました。（データベースエラー）', 500, $e);
        } catch (Throwable $e) {
            Log::error('日記の更新中に予期せぬエラーが発生: ' . $e->getMessage(), ['diary_id' => $diary->id, 'data' => $validatedData]);
            throw new DiaryActionException('日記の更新に失敗しました。（予期せぬエラー）', 500, $e);
        }
    }

    /**
     * 特定の日付にユーザーが書いた日記を取得する
     * @param Carbon $date 日付
     * @param int $userId ユーザーID
     * @return Diary|null 日記モデル、存在しない場合はnull
     */
    public function findDiaryByDateForUser(Carbon $date, int $userId): ?Diary
    {
        return Diary::where('user_id', $userId)
            ->whereDate('entryDatetime', $date)
            ->first();
    }
}