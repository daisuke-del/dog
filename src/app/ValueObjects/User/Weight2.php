<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class Weight2
{
    private $weight2;

    public function __construct(int $weight2)
    {
        if ($this->isWeight2($weight2) === false) {
            throw new MATCHException('validation.weight2', 422);
        }
        $this->weight2 = $weight2;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->weight2;
    }

    /**
     * weight2のValidationチェック
     *
     * @param int $weight2
     * @return bool
     */
    private function isWeight2(int $weight2): bool
    {
        return Validator::make([$weight2], ['required|integer'])->passes();
    }
}
