<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class InstagramId
{
    private $instagramId;

    public function __construct(?string $instagramId)
    {
        $this->instagramId = $instagramId;
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return $this->instagramId;
    }
}
