<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class Salary
{
    private $salary;

    public function __construct(int $salary)
    {
        if ($this->isSalary($salary) === false) {
            throw new MARIGOLDException('validation.salary', 422);
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
     * @param int $salary
     * @return bool
     */
    private function isSalary(int $salary): bool
    {
        return Validator::make([$salary], ['required|integer'])->passes();
    }
}
