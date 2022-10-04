<?php

namespace App\ValueObjects\User;

use App\Exceptions\MUCHException;
use Illuminate\Support\Facades\Validator;

class TwitterId
{
    private $twitterId;

    public function __construct(string $twitterId)
    {
        if ($this->isTwitterId($twitterId) === false) {
            throw new MUCHException('validation.twitter_id', 422);
        }
        $this->twitterId = $twitterId;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->twitterId;
    }

    /**
     * facebook_idのValidationチェック
     *
     * @param string $twitterId
     * @return bool
     */
    private function isTwitterId(string $twitterId): bool
    {
        return Validator::make([$twitterId], ['required|string'])->passes();
    }
}
