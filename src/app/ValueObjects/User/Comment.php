<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class Comment
{
    private $comment;

    public function __construct(?string $comment)
    {
        if ($this->isName($comment) === false) {
            throw new DOGException('validation.comment', 422);
        }
        $this->comment = $comment;
    }

    /**
     * @return ?string
     */
    public function get(): ?string
    {
        return $this->comment;
    }

    /**
     * facebook_idのValidationチェック
     *
     * @param ?string $comment
     * @return bool
     */
    private function isName(?string $comment): bool
    {
        return Validator::make([$comment], ['string|nullable'])->passes();
    }
}
