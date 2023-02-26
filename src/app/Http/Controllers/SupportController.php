<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupportService;

class SupportController extends Controller
{
    protected SupportService $supportService;

    public function __construct(SupportService $supportService)
    {
        $this->supportService = $supportService;
    }

    /**
     * @return false|string
     */
    public function get(Request $request) {
        $list = $this->supportService->getSupports($request);
        return json_encode($list, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return false|string
     */
    public function send(Request $request) {
        $list = $this->supportService->sendSupport($request);
        return json_encode($list, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function resolve(Request $request) {
        $list = $this->supportService->resolveSupport($request);
        return json_encode($list, JSON_UNESCAPED_UNICODE);
    }
}