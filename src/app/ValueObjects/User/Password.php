<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Password
{
    private $password;

    public function __construct(string $password)
    {
        if ($this->isPassword($password) === false) {
            throw new MATCHException('validation.password', 422);
        }
        $this->password = Hash::make($password);
    }

    /**
     * passwordを取得する
     *
     * @return string
     */
    public function get(): string
    {
        return $this->password;
    }

    /**
     * passwordのValidationチェック
     *
     * @param string $password
     * @return bool
     */
    private function isPassword(string $password): bool
    {
        return Validator::make(
            [$password],
            ['required|between:4,32|regex:' . config('const.REGEX_PASSWORD')]
        )->passes();
    }
}
