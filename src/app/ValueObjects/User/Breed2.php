<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class Breed2
{
    private $breed2;

    public function __construct(?string $breed2)
    {
        if ($this->isBreed2($breed2) === false) {
            throw new DOGException('validation.breed2', 422);
        }
        $this->breed2 = $breed2;
    }

    /**
     * @return ?string
     */
    public function get(): ?string
    {
        return $this->breed2;
    }

    /**
     * breedのValidationチェック
     *
     * @param string $breed2
     * @return bool
     */
    private function isBreed2(?string $breed2): bool
    {
        return Validator::make([$breed2], ['string|nullable'])->passes();
    }
}
