<?php

namespace App\ValueObjects\User;

use App\Exceptions\MUCHException;
use Illuminate\Support\Facades\Validator;

class Weight
{
    private $weight;

    public function __construct(string $weight)
    {
        if ($this->isWeight($weight) === false) {
            throw new MUCHException('validation.weight', 422);
        }
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->weight;
    }

    /**
     * weightのValidationチェック
     *
     * @param string $weight
     * @return bool
     */
    private function isWeight(string $weight): bool
    {
        return Validator::make([$weight], ['required|integer'])->passes();
    }
}
