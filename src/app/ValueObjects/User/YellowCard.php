<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class YellowCard
{
    private $yellowCard;

    public function __construct(string $yellowCard)
    {
        if ($this->isYellowCard($yellowCard) === false) {
            throw new MARIGOLDException('validation.yellow_card', 422);
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
    private function isYellowCard(string $yellowCard): bool
    {
        return Validator::make([$yellowCard], ['required|integer'])->passes();
    }
}
