<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 日記のリクエストバリデーション
 */
class DiaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストに適用するバリデーションルール
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // StoreとUpdateの両方に共通のルールを記述
        return [
            'entry_datetime' => 'required|date',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }

    /**
     * バリデーションエラーメッセージをカスタマイズする
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'entry_datetime.required' => '日付と時刻は必須です。',
            'entry_datetime.date' => '日付と時刻が有効な形式ではありません。',
            'title.required' => 'タイトルは必須です。',
            'title.string' => 'タイトルは文字列である必要があります。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'content.required' => '内容は必須です。',
            'content.string' => '内容は文字列である必要があります。',
        ];
    }
}