<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class MUCHException extends Exception
{
    protected $message;
    protected $code;
    protected $param;

    /**
     * Exception constructor.
     *
     * @param string $message エラーメッセージ
     * @param int $code ステータスコード
     * @param array $param 付加情報
     * @param Throwable|null $previous
     */
    public function __construct(string $message, int $code, array $param = [], Throwable $previous = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->param = $param;
        parent::__construct($message, $code, $previous);
    }

    /**
     * paramを取得する
     *
     * @return array
     */
    public function getParam(): array
    {
        return $this->param;
    }
}
