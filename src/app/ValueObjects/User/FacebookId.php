<?php

namespace App\ValueObjects\User;

use App\Exceptions\MATCHException;
use Illuminate\Support\Facades\Validator;

class FacebookId
{
    private $facebookId;

    public function __construct(string $facebookId)
    {
        if ($this->isFacebookId($facebookId) === false) {
            throw new MATCHException('validation.Facebook_id', 422);
        }
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->facebookId;
    }

    /**
     * facebook_idのValidationチェック
     *
     * @param string $facebookId
     * @return bool
     */
    private function isFacebookId(string $facebookId): bool
    {
        return Validator::make([$facebookId], ['required|string'])->passes();
    }
}
