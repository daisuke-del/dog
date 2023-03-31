<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class DogImage
{
    private $dogImage;

    public function __construct(string $dogImage)
    {
        if ($this->isDogImage($dogImage) === false) {
            throw new DOGException('validation.dog_image', 422);
        }
        $this->dogImage = $dogImage;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->dogImage;
    }

    /**
     * dog_imageのValidationチェック
     *
     * @param string $dogImage
     * @return bool
     */
    private function isDogImage(string $dogImage): bool
    {
        return Validator::make([$dogImage], ['required|string'])->passes();
    }
}
