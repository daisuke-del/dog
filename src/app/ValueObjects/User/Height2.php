<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class Height2
{
    private $height2;

    public function __construct(string $height2)
    {
        if ($this->isHeight2($height2) === false) {
            throw new MATCHException('validation.height2', 422);
        }
        $this->height2 = $height2;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->height2;
    }

    /**
     * height2のValidationチェック
     *
     * @param string $height2
     * @return bool
     */
    private function isHeight2(string $height2): bool
    {
        return Validator::make([$height2], ['required|integer'])->passes();
    }
}
