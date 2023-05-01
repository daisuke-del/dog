<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class DogImage3
{
    private $dogImage3;

    public function __construct(?string $dogImage3)
    {
        if ($this->isDogImage3($dogImage3) === false) {
            throw new DOGException('validation.dog_image', 422);
        }
        $this->dogImage3 = $dogImage3;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->dogImage3;
    }

    /**
     * dog_image3のValidationチェック
     *
     * @param string $dogImage3
     * @return bool
     */
    private function isDogImage3(string $dogImage3): bool
    {
        return Validator::make([$dogImage3], ['string'])->passes();
    }
}
