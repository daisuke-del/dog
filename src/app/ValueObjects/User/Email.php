<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class Email
{
    private $email;

    public function __construct(?string $email)
    {
        if ($this->isEmail($email) === false) {
            throw new DOGException('validation.pc_email', 422);
        }
        $this->email = $email;
    }

    /**
     * pc_emailを取得する
     *
     * @return string|null
     */
    public function get(): ?string
    {
        return $this->email;
    }

    /**
     * pc_emailのValidationチェック
     *
     * @param string $email
     * @return bool
     */
    private function isEmail(?string $email): bool
    {
        return Validator::make(
            [$email],
            [
                [
                    'nullable',
                    'regex:' . config('const.REGEX_PASSWORD')
                ]
            ]
        )->passes();
    }
}
