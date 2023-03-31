<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class Name
{
    private $name;

    public function __construct(string $name)
    {
        if ($this->isName($name) === false) {
            throw new DOGException('validation.dog_image', 422);
        }
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->name;
    }

    /**
     * facebook_idのValidationチェック
     *
     * @param string $name
     * @return bool
     */
    private function isName(string $name): bool
    {
        return Validator::make([$name], ['required|string'])->passes();
    }
}
