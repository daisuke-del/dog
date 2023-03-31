<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class TiktokId
{
    private $tiktokId;

    public function __construct(?string $tiktokId)
    {
        if ($this->isTiktokId($tiktokId) === false) {
            throw new DOGException('validation.dog_image', 422);
        }
        $this->tiktokId = $tiktokId;
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return $this->tiktokId;
    }

    /**
     * tiktok_idのValidationチェック
     *
     * @param string $tiktokId
     * @return bool
     */
    private function isTiktokId(string $tiktokId): bool
    {
        return Validator::make([$tiktokId], ['string'])->passes();
    }
}
