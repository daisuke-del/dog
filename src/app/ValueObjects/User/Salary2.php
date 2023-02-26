<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class Salary2
{
    private $salary2;

    public function __construct(int $salary2)
    {
        if ($this->isSalary2($salary2) === false) {
            throw new MARIGOLDException('validation.salary2', 422);
        }
        $this->salary2 = $salary2;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->salary2;
    }

    /**
     * salary2のValidationチェック
     *
     * @param int $salary2
     * @return bool
     */
    private function isSalary2(int $salary2): bool
    {
        return Validator::make([$salary2], ['required|integer'])->passes();
    }
}
