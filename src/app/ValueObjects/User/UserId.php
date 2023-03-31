<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class UserId
{
    private $userId;

    public function __construct(string $userId)
    {
        if ($this->isUserId($userId) === false) {
            throw new DOGException('validation.user_id', 422);
        }
        $this->userId = $userId;
    }

    /**
     * user_idを取得する
     *
     * @return string
     */
    public function get(): string
    {
        return $this->userId;
    }

    /**
     * user_idのValidationチェック
     *
     * @param string $userId
     * @return bool
     */
    private function isUserId(string $userId): bool
    {
        return Validator::make([$userId], ['required|uuid'])->passes();
    }
}
