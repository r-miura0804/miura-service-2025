<?php

namespace App\Http\Controllers;

use App\Models\Diary\Diary;
use App\Http\Requests\DiaryRequest;
use App\Modules\Diary\UseCase\DiaryAction;
use App\Modules\Diary\Exceptions\DiaryActionException;
use Throwable;
use Carbon\Carbon;

class DiaryController extends Controller
{
    private function getCurrentUserId(): int
    {
        // 認証機能が未実装の間は仮のユーザーIDを返す
        return 1;
    }

    // API
    /**
     * 日記の新規登録
     */
    public function createDiary(DiaryRequest $request, DiaryAction $action)
    {
        try {
            $action->create($request->validated(), $this->getCurrentUserId());
            return redirect()->route('diary.calendar')->with('success', '日記が作成されました！');
        } catch (DiaryActionException  $e) {
            // アクションからスローされたカスタム例外を捕捉
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        } catch (Throwable $e) {
            // 予期せぬその他の例外を捕捉 (最終的なフォールバック)
            return redirect()->back()->withInput()->withErrors(['error' => '予期せぬエラーが発生しました。時間をおいて再度お試しください。']);
        }
    }

    /**
     * 日記の更新する
     */
    public function updateDiary(DiaryRequest $request, DiaryAction $action, int $diaryId)
    {
        $diary = Diary::findOrFail($diaryId);
        
    try {
            $action->update($request->validated(), $diary);
            return redirect()->route('diary.calendar')->with('success', '日記が更新されました！');
        } catch (DiaryActionException $e) {
            // アクションからスローされたカスタム例外を捕捉
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        } catch (Throwable $e) {
            // 予期せぬその他の例外を捕捉 (最終的なフォールバック)
            return redirect()->back()->withInput()->withErrors(['error' => '予期せぬエラーが発生しました。時間をおいて再度お試しください。']);
        }
    }

    // 表示制御
    /**
     * 特定の日付の日記の表示制御を管理する
     */
    public function manage(string $date, DiaryAction $action)
    {
        // URLから渡された日付文字列をCarbonオブジェクトに変換（時刻は00:00:00にする）
        $targetDate = Carbon::parse($date)->startOfDay();

        if (!$targetDate) {
            return redirect()->route('diary.calendar')->withErrors(['date' => '無効な日付です。']);
        }

        // 特定の日付にユーザーが書いた日記を取得
        $diary = $action->findDiaryByDateForUser($targetDate, $this->getCurrentUserId());

        if ($diary) {
            return $this->showEditDiaryForm($diary);
        } else {
            return $this->showCreateDiaryForm($targetDate);
        }
    }

    /**
     * 日記の作成フォームを表示する
     */
    public function showCreateDiaryForm(Carbon $entryDatetime)
    {
        return view('diary.createDiary', ['entry_datetime_default' => $entryDatetime]);
    }

    /**
     * 日記の編集フォームを表示する
     */
    public function showEditDiaryForm(Diary $diary)
    {
        return view('diary.editDiary', compact('diary'));
    }
}