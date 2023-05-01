<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class DogImage1
{
    private $dogImage1;

    public function __construct(string $dogImage1)
    {
        if ($this->isDogImage1($dogImage1) === false) {
            throw new DOGException('validation.dog_image1', 422);
        }
        $this->dogImage1 = $dogImage1;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->dogImage1;
    }

    /**
     * dog_imageのValidationチェック
     *
     * @param string $dogImage1
     * @return bool
     */
    private function isDogImage1(string $dogImage1): bool
    {
        return Validator::make([$dogImage1], ['required|string'])->passes();
    }
}
