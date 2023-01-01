<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class FacePoint2
{
    private $facePoint2;

    public function __construct(int $facePoint2)
    {
        if ($this->isFacePoint2($facePoint2) === false) {
            throw new MATCHException('validation.face_point', 422);
        }
        $this->facePoint2 = $facePoint2;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->facePoint2;
    }

    /**
     * facePoint2のValidationチェック
     *
     * @param int $facePoint2
     * @return bool
     */
    private function isFacePoint2(int $facePoint2): bool
    {
        return Validator::make([$facePoint2], ['required|integer'])->passes();
    }
}
