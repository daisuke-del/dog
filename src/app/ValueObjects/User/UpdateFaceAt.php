<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class UpdateFaceAt
{
    private $updateFaceAt;

    public function __construct(string $updateFaceAt)
    {
        if ($this->isUpdateFaceAt($updateFaceAt) === false) {
            throw new MARIGOLDException('validation.update_face_at', 422);
        }
        $this->updateFaceAt = $updateFaceAt;
    }

    /**
     * create_dateを取得する
     *
     * @return string
     */
    public function get(): string
    {
        return $this->updateFaceAt;
    }

    /**
     * create_dateのValidationチェック
     *
     * @param string $updateFaceAt
     * @return bool
     */
    private function isUpdateFaceAt(string $updateFaceAt): bool
    {
        return Validator::make([$updateFaceAt], ['required|date_format:Y-m-d H:i:s'])->passes();
    }
}
