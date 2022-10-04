<?php

namespace App\Http\Controllers;

use Exception;
use http\Encoding\Stream\Inflate;
use Throwable;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Services\MypageService;

class MypageController extends Controller
{
    protected $mypageService;

    public function __construct(MypageService $mypageService)
    {
        $this->mypageService = $mypageService;
    }

    /**
     * マイページTOP
     *
     * @return false|string
     * @throws Exception
     */
    public function index()
    {
        $list = $this->mypageService->index();
        return json_encode($list, JSON_UNESCAPED_UNICODE);
    }

    /**
     * フレンドの詳細を取得
     *
     * @param string $userId
     * @return false|string
     * @throws Exception
     */
    public function friendDetail(string $userId)
    {
        $details = $this->mypageService->getFriendDetail($userId);
        return json_encode($details, JSON_UNESCAPED_UNICODE);
    }
}
