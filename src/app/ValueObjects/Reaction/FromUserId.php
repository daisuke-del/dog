<?php

namespace App\ValueObjects\Reaction;

use App\Exceptions\MUCHException;
use Illuminate\Support\Facades\Validator;

class FromUserId
{
    private $fromUserId;

    public function __construct(string $fromUserId)
    {
        if ($this->isFromUserId($fromUserId) === false) {
            throw new MUCHException('validation.fromUserId', 422);
        }
        $this->fromUserId = $fromUserId;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->fromUserId;
    }

    /**
     * fromUserIdのValidationチェック
     *
     * @param string $fromUserId
     * @return bool
     */
    private function isFromUserId(string $fromUserId): bool
    {
        return Validator::make([$fromUserId], ['required|uuid'])->passes();
    }
}
