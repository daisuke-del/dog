<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class InstagramId
{
    private $instagramId;

    public function __construct(?string $instagramId)
    {
        if ($this->isInstagramId($instagramId) === false) {
            throw new DOGException('validation.dog_image', 422);
        }
        $this->instagramId = $instagramId;
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return $this->instagramId;
    }

    /**
     * instagram_idのValidationチェック
     *
     * @param string $instagramId
     * @return bool
     */
    private function isInstagramId(string $instagramId): bool
    {
        return Validator::make([$instagramId], ['string'])->passes();
    }
}
