<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class Age2
{
    private $age2;

    public function __construct(string $age2)
    {
        if ($this->isAge2($age2) === false) {
            throw new MARIGOLDException('validation.age2', 422);
        }
        $this->age2 = $age2;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->age2;
    }

    /**
     * age2のValidationチェック
     *
     * @param string $age2
     * @return bool
     */
    private function isAge2(string $age2): bool
    {
        return Validator::make([$age2], ['required|integer'])->passes();
    }
}
