<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class Breed
{
    private $breed;

    public function __construct(?string $breed)
    {
        if ($this->isBreed($breed) === false) {
            throw new DOGException('validation.dog_image', 422);
        }
        $this->breed = $breed;
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return $this->breed;
    }

    /**
     * breedのValidationチェック
     *
     * @param string $breed
     * @return bool
     */
    private function isBreed(string $breed): bool
    {
        return Validator::make([$breed], ['string'])->passes();
    }
}
