<?php

namespace App\ValueObjects\User;

use App\Exceptions\MUCHException;
use Illuminate\Support\Facades\Validator;

class Salary
{
    private $salary;

    public function __construct(string $salary)
    {
        if ($this->isSalary($salary) === false) {
            throw new MUCHException('validation.salary', 422);
        }
        $this->salary = $salary;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->salary;
    }

    /**
     * salaryのValidationチェック
     *
     * @param string $salary
     * @return bool
     */
    private function isSalary(string $salary): bool
    {
        return Validator::make([$salary], ['required|integer'])->passes();
    }
}
