<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class Sex
{
    private string $sex;

    public function __construct(string $sex)
    {
        if ($this->isSex($sex) === false) {
            throw new DOGException('validation.sex', 422);
        }
        $this->sex = $sex;
    }

    /**
     * @return int
     */
    public function get(): string
    {
        return $this->sex;
    }

    /**
     * sexのValidationチェック
     *
     * @param string $sex
     * @return bool
     */
    private function isSex(string $sex): bool
    {
        return Validator::make([$sex], ['required|string'])->passes();
    }
}
