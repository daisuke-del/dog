<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class Height
{
    private $height;

    public function __construct(int $height)
    {
        if ($this->isHeight($height) === false) {
            throw new MARIGOLDException('validation.height', 422);
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
     * @param int $height
     * @return bool
     */
    private function isHeight(int $height): bool
    {
        return Validator::make([$height], ['required|integer'])->passes();
    }
}
