<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class Breed1
{
    private $breed1;

    public function __construct(?string $breed1)
    {
        if ($this->isBreed1($breed1) === false) {
            throw new DOGException('validation.breed1', 422);
        }
        $this->breed1 = $breed1;
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return $this->breed1;
    }

    /**
     * breedのValidationチェック
     *
     * @param string $breed1
     * @return bool
     */
    private function isBreed1(string $breed1): bool
    {
        return Validator::make([$breed1], ['string'])->passes();
    }
}
