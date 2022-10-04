<?php

namespace App\ValueObjects\User;

use App\Exceptions\MUCHException;
use Illuminate\Support\Facades\Validator;

class Gender
{
    private string $gender;

    public function __construct(string $gender)
    {
        if ($this->isGender($gender) === false) {
            throw new MUCHException('validation.gender', 422);
        }
        $this->gender = $gender;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->gender;
    }

    /**
     * genderのValidationチェック
     *
     * @param string $gender
     * @return bool
     */
    private function isGender(string $gender): bool
    {
        return Validator::make([$gender], ['required|string'])->passes();
    }
}
