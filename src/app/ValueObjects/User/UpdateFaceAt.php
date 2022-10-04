<?php

namespace App\ValueObjects\User;

use App\Exceptions\MUCHException;
use Illuminate\Support\Facades\Validator;

class UpdateFaceAt
{
    private $updateFaceAt;

    public function __construct(string $updateFaceAt)
    {
        if ($this->isUpdateFaceAt($updateFaceAt) === false) {
            throw new MUCHException('validation.update_face_at', 422);
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
        return Validator::make([$updateFaceAt], ['required|date_format:Y-m-d\TH:i:s.u\Z'])->passes();
    }
}
