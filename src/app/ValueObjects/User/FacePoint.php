<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class FacePoint
{
    private $facePoint;

    public function __construct(int $facePoint)
    {
        if ($this->isFacePoint($facePoint) === false) {
            throw new MATCHException('validation.face_point', 422);
        }
        $this->facePoint = $facePoint;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->facePoint;
    }

    /**
     * facePointのValidationチェック
     *
     * @param int $facePoint
     * @return bool
     */
    private function isFacePoint(int $facePoint): bool
    {
        return Validator::make([$facePoint], ['required|integer'])->passes();
    }
}
