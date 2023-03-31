<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class DogImage2
{
    private $dogImage2;

    public function __construct(string $dogImage2)
    {
        if ($this->isDogImage2($dogImage2) === false) {
            throw new DOGException('validation.dog_image', 422);
        }
        $this->dogImage2 = $dogImage2;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->dogImage2;
    }

    /**
     * dog_image2のValidationチェック
     *
     * @param string $dogImage
     * @return bool
     */
    private function isDogImage2(string $dogImage2): bool
    {
        return Validator::make([$dogImage2], ['string'])->passes();
    }
}
