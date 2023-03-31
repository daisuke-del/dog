<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class UpdateDogAt
{
    private $updateDogAt;

    public function __construct(string $updateDogAt)
    {
        if ($this->isUpdateDogAt($updateDogAt) === false) {
            throw new DOGException('validation.update_dog_at', 422);
        }
        $this->updateDogAt = $updateDogAt;
    }

    /**
     * create_dateを取得する
     *
     * @return string
     */
    public function get(): string
    {
        return $this->updateDogAt;
    }

    /**
     * create_dateのValidationチェック
     *
     * @param string $updateDogAt
     * @return bool
     */
    private function isUpdateDogAt(string $updateDogAt): bool
    {
        return Validator::make([$updateDogAt], ['required|date_format:Y-m-d H:i:s'])->passes();
    }
}
