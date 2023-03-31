<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class DogPoint
{
    private $dogPoint;

    public function __construct(int $dogPoint)
    {
        if ($this->isDogPoint($dogPoint) === false) {
            throw new DOGException('validation.dog_point', 422);
        }
        $this->dogPoint = $dogPoint;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->dogPoint;
    }

    /**
     * dogPointのValidationチェック
     *
     * @param int $dogPoint
     * @return bool
     */
    private function isDogPoint(int $dogPoint): bool
    {
        return Validator::make([$dogPoint], ['required|integer'])->passes();
    }
}
