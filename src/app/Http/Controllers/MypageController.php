<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\MypageService;
use Illuminate\Http\Request;

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

    /**
     * お気に入りに追加
     *
     * @param Request
     * @return void
     */
    public function addFavorite(Request $request)
    {
        $this->mypageService->addFavorite($request);
    }

    /**
     * お気に入りに削除
     *
     * @param Request $request
     * @return false|string
     */
    public function deleteFavorite(Request $request)
    {
        $this->mypageService->deleteFavorite($request);
    }
}
