<?php

namespace App\ValueObjects\Reaction;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class FromUserId
{
    private $fromUserId;

    public function __construct(string $fromUserId)
    {
        if ($this->isFromUserId($fromUserId) === false) {
            throw new MARIGOLDException('validation.fromUserId', 422);
        }
        $this->fromUserId = $fromUserId;
    }

    /**
     * @return string
     */
    public function get(): string
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
