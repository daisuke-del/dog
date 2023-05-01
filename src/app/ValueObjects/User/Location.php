<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class Location
{
    private $location;

    public function __construct(?string $location)
    {
        if ($this->isLocation($location) === false) {
            throw new DOGException('validation.location', 422);
        }
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return $this->location;
    }

    /**
     * locationのValidationチェック
     *
     * @param string $location
     * @return bool
     */
    private function isLocation(string $location): bool
    {
        return Validator::make([$location], ['string'])->passes();
    }
}
