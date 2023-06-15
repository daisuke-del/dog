<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class YellowCard
{
    private $yellowCard;

    public function __construct(int $yellowCard)
    {
        if ($this->isYellowCard($yellowCard) === false) {
            throw new DOGException('validation.yellow_card', 422);
        }
        $this->yellowCard = $yellowCard;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->yellowCard;
    }

    /**
     * yellowCardのValidationチェック
     *
     * @param string $yellowCard
     * @return bool
     */
    private function isYellowCard(int $yellowCard): bool
    {
        return Validator::make([$yellowCard], ['required|integer'])->passes();
    }
}
