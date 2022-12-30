<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\MATCHException;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class MatchController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
}
