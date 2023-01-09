<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class FaceImageVoidFlg
{
    private $faceImageVoidFlg;

    public function __construct(?string $faceImageVoidFlg)
    {
        if ($this->isFaceImageVoidFlg($faceImageVoidFlg) === false) {
            throw new MATCHException('validation.face_image_void_flg', 422);
        }
        $this->faceImageVoidFlg = $faceImageVoidFlg;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->faceImageVoidFlg;
    }

    /**
     * faceImageVoidFlgのValidationチェック
     *
     * @param string $faceImageVoidFlg
     * @return bool
     */
    private function isFaceImageVoidFlg(?string $faceImageVoidFlg): bool
    {
        return Validator::make([$faceImageVoidFlg], ['integer'])->passes();
    }
}
