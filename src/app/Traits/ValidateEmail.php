<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait ValidateEmail
{
    public function containUppercase(string $email): bool
    {
        return Str::lower($email) !== $email;
    }
}
