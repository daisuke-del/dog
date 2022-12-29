<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class FaceImage
{
    private $faceImage;

    public function __construct(string $faceImage)
    {
        if ($this->isFaceImage($faceImage) === false) {
            throw new MATCHException('validation.face_image', 422);
        }
        $this->faceImage = $faceImage;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->faceImage;
    }

    /**
     * facebook_idのValidationチェック
     *
     * @param string $faceImage
     * @return bool
     */
    private function isFaceImage(string $faceImage): bool
    {
        return Validator::make([$faceImage], ['required|string'])->passes();
    }
}
