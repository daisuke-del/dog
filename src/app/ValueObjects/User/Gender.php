<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class Gender
{
    private string $gender;

    public function __construct(string $gender)
    {
        if ($this->isGender($gender) === false) {
            throw new MATCHException('validation.gender', 422);
        }
        $this->gender = $gender;
    }

    /**
     * @return int
     */
    public function get(): string
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
