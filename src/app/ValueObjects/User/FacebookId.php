<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class FacebookId
{
    private $facebookId;

    public function __construct(?string $facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return $this->facebookId;
    }
}
