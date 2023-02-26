<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class MatchController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * マッチング結果を取得
     *
     * @param Request $request
     * @return false|string
     */
    public function result(Request $request)
    {
        $response = $this->userService->getResult($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * マッチング結果を取得
     *
     * @param Request $request
     * @return false|string
     */
    public function choice(Request $request)
    {
        $response = $this->userService->upDownFacePoint($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 適切ではない写真をクリックした際の処理（yellowCard ＋１）
     *
     * @param Request $request
     * @return false|string
     */
    public function alert(Request $request)
    {
        $response = $this->userService->updateYellowAndGetFace($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
