<?php

namespace App\ValueObjects\User;

use App\Exceptions\MUCHException;
use Illuminate\Support\Facades\Validator;

class FacePoint
{
    private $facePoint;

    public function __construct(string $facePoint)
    {
        if ($this->isFacePoint($facePoint) === false) {
            throw new MUCHException('validation.face_point', 422);
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
     * @param string $facePoint
     * @return bool
     */
    private function isFacePoint(string $facePoint): bool
    {
        return Validator::make([$facePoint], ['required|integer'])->passes();
    }
}
