<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class Weight
{
    private $weight;

    public function __construct(int $weight)
    {
        if ($this->isWeight($weight) === false) {
            throw new MARIGOLDException('validation.weight', 422);
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
     * @param int $weight
     * @return bool
     */
    private function isWeight(int $weight): bool
    {
        return Validator::make([$weight], ['required|integer'])->passes();
    }
}
