<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class AuthCode
{
    private $authCode;

    public function __construct(?int $authCode)
    {
        if ($this->isAuthCode($authCode) === false) {
            throw new MATCHException('validation.auth_code', 422);
        }
        $this->authCode = $authCode;
    }

    /**r
     * auth_codeを取得する
     *
     * @return int|null
     */
    public function get(): ?int
    {
        return $this->authCode;
    }

    /**
     * auth_codeのValidationチェック
     *
     * @param int $authCode
     * @return bool
     */
    private function isAuthCode(?int $authCode): bool
    {
        return Validator::make([$authCode], ['nullable|digits:6'])->passes();
    }
}
