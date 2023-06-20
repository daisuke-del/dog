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
     * お気に入りに追加
     *
     * @param Request
     * @return false|string
     */
    public function addFavorite(Request $request)
    {
        $result = $this->mypageService->addFavorite($request);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * お気に入りに削除
     *
     * @param Request $request
     * @return false|string
     */
    public function deleteFavorite(Request $request)
    {
        $result = $this->mypageService->deleteFavorite($request);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * マイページからお気に入りに追加
     *
     * @param Request
     * @return false|string
     */
    public function addFavoriteFromMypage(Request $request)
    {
        $result = $this->mypageService->addFavoriteFromMypage($request);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * マイページからお気に入りに削除
     *
     * @param Request $request
     * @return false|string
     */
    public function deleteFavoriteFromMypage(Request $request)
    {
        $result = $this->mypageService->deleteFavoriteFromMypage($request);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
