<?php

namespace App\ValueObjects\User;

use App\Exceptions\MUCHException;
use Illuminate\Support\Facades\Validator;

class Age
{
    private $age;

    public function __construct(string $age)
    {
        if ($this->isAge($age) === false) {
            throw new MUCHException('validation.age', 422);
        }
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->age;
    }

    /**
     * ageのValidationチェック
     *
     * @param string $age
     * @return bool
     */
    private function isAge(string $age): bool
    {
        return Validator::make([$age], ['required|integer'])->passes();
    }
}
