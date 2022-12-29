<?php

namespace App\ValueObjects\Reaction;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class ToUserId
{
    private $toUserId;

    public function __construct(string $toUserId)
    {
        if ($this->istoUserId($toUserId) === false) {
            throw new MATCHException('validation.toUserId', 422);
        }
        $this->toUserId = $toUserId;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->toUserId;
    }

    /**
     * toUserIdのValidationチェック
     *
     * @param string $toUserId
     * @return bool
     */
    private function istoUserId(string $toUserId): bool
    {
        return Validator::make([$toUserId], ['required|uuid'])->passes();
    }
}
