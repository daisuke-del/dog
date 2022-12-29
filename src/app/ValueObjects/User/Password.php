<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class Password
{
    private $password;

    public function __construct(
        string $password,
        ?string $email
    ) {
        if ($this->isPassword($password) === false || is_null($email)) {
            throw new MATCHException('validation.password', 422);
        }
        //ハッシュ化する値を作成
        $passText = $password . "\t" . $email;
        //パスワードをハッシュ化して設定
        $this->password =
            (string) strtolower(str_replace('-', '', mb_convert_encoding(md5($passText), 'ASCII')));
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
