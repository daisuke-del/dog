<?php

namespace App\ValueObjects\User;

use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Validator;

class BlogId
{
    private $blogId;

    public function __construct(?string $blogId)
    {
        if ($this->isBlogId($blogId) === false) {
            throw new DOGException('validation.dog_image', 422);
        }
        $this->blogId = $blogId;
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return $this->blogId;
    }

    /**
     * blog_idのValidationチェック
     *
     * @param string $blogId
     * @return bool
     */
    private function isBlogId(string $blogId): bool
    {
        return Validator::make([$blogId], ['string'])->passes();
    }
}
