<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class TwitterId
{
    private $twitterId;

    public function __construct(?string $twitterId)
    {
        $this->twitterId = $twitterId;
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return $this->twitterId;
    }
}
