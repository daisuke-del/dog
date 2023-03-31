<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class OrderNumber
{
    private $orderNumber;

    public function __construct(?int $orderNumber)
    {
        if ($this->isOrderNumber($orderNumber) === false) {
            throw new DOGException('validation.dog_point', 422);
        }
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->orderNumber;
    }

    /**
     * orderNumberのValidationチェック
     *
     * @param int $orderNumber
     * @return bool
     */
    private function isOrderNumber(?int $orderNumber): bool
    {
        return Validator::make([$orderNumber], ['integer'])->passes();
    }
}
