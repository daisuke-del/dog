<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class Birthday
{
    private $birthday;

    public function __construct(string $birthday)
    {
        if ($this->isBirthday($birthday) === false) {
            throw new DOGException('validation.create_date', 422);
        }
        $this->birthday = $birthday;
    }

    /**
     * create_dateを取得する
     *
     * @return string
     */
    public function get(): string
    {
        return $this->birthday;
    }

    /**
     * birthdayのValidationチェック
     *
     * @param string $birthday
     * @return bool
     */
    private function isBirthday(string $birthday): bool
    {
        return Validator::make([$birthday], ['date_format:Y-m-d'])->passes();
    }
}
