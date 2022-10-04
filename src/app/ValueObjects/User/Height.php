<?php

namespace App\ValueObjects\User;

use App\Exceptions\MUCHException;
use Illuminate\Support\Facades\Validator;

class Height
{
    private $height;

    public function __construct(string $height)
    {
        if ($this->isHeight($height) === false) {
            throw new MUCHException('validation.height', 422);
        }
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->height;
    }

    /**
     * heightのValidationチェック
     *
     * @param string $height
     * @return bool
     */
    private function isHeight(string $height): bool
    {
        return Validator::make([$height], ['required|integer'])->passes();
    }
}
