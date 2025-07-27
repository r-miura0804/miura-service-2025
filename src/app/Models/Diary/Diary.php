<?php

declare(strict_types=1);

namespace App\Models\Diary;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * 日記モデル
 *
 * @property int $id
 * @property int $user_id ユーザーID
 * @property \Carbon\Carbon $entryDatetime 日記の日時
 * @property string|null $title 日記のタイトル
 * @property string|null $content 日記の内容
 * @property \Carbon\Carbon|null $created_at 作成日時
 * @property \Carbon\Carbon|null $updated_at 更新日時
 */
class Diary extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'diaries';

    protected $fillable = [
        'user_id',
        'entryDatetime',
        'title',
        'content',
    ];

    protected $casts = [
        'entryDatetime' => 'datetime',
    ];

    /**
     * ユーザーとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}