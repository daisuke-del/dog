<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class DogImageVoidFlg
{
    private $dogImageVoidFlg;

    public function __construct(?int $dogImageVoidFlg)
    {
        if ($this->isDogImageVoidFlg($dogImageVoidFlg) === false) {
            throw new DOGException('validation.dog_image_void_flg', 422);
        }
        $this->dogImageVoidFlg = $dogImageVoidFlg;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->dogImageVoidFlg;
    }

    /**
     * DogImageVoidFlgのValidationチェック
     *
     * @param int $dogImageVoidFlg
     * @return bool
     */
    private function isDogImageVoidFlg(?int $dogImageVoidFlg): bool
    {
        return Validator::make([$dogImageVoidFlg], ['integer'])->passes();
    }
}
