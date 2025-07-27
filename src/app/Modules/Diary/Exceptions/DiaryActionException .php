<?php

declare(strict_types=1);

namespace App\Modules\Diary\Exceptions;

use Exception;

/**
 * 日記アクションに関するカスタム例外
 */
class DiaryActionException extends Exception
{
    /**
     * @param string $message エラーメッセージ
     * @param int $code エラーコード (任意)
     */
    public function __construct(string $message = "", int $code = 0)
    {
        parent::__construct($message, $code);
    }
}