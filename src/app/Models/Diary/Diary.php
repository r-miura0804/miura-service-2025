<?php

declare(strict_types=1);

namespace App\Models\Diary;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

/**
 * 日記モデル
 *
 * @property int $id
 * @property int $postedBy 投稿者のユーザーID
 * @property Carbon $entryDate 日記投稿日
 * @property string|null $title 日記のタイトル
 * @property string|null $content 日記の内容
 * @property Carbon|null $createdAt 作成日時
 * @property Carbon|null $updatedAt 更新日時
 */
class Diary extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'diaries';

    // タイムスタンプのカラム名をカスタマイズ
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'postedBy',
        'entryDate',
        'title',
        'content',
    ];

    protected $casts = [
        'entryDate' => 'date',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
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