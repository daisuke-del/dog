<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Exceptions\DOGException;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 会員登録
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function signup(Request $request)
    {
        $response = $this->userService->signup($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * ログイン
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function login(Request $request)
    {
        $response = $this->userService->login($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 管理画面ログイン
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function adminLogin(Request $request)
    {
        $response = $this->userService->adminLogin($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * ログアウト
     *
     * @return false|string
     */
    public function logout()
    {
        $response = $this->userService->logout();
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 管理者ログアウト
     *
     * @return false|string
     */
    public function adminLogout()
    {
        $response = $this->userService->adminLogout();
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 退会
     *
     *
     */
    public function leave ()
    {
        $response = $this->userService->leave();
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - email
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateEmail(Request $request)
    {
        $response = $this->userService->updateEmail($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - name
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateName(Request $request)
    {
        $response = $this->userService->updateName($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - weight
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateWeight(Request $request)
    {
        $response = $this->userService->updateWeight($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - breed
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateBreed(Request $request)
    {
        $response = $this->userService->updateBreed($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - birthday
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateBirthday(Request $request)
    {
        $response = $this->userService->updateBirthday($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - location
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateLocation(Request $request)
    {
        $response = $this->userService->updateLocation($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - dog_image
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateDogImage(Request $request)
    {
        $response = $this->userService->updateDogImage($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

     /**
     * 会員情報変更 - instagram
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateInstagram(Request $request)
    {
        $response = $this->userService->updateInstagram($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - twitter
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateTwitter(Request $request)
    {
        $response = $this->userService->updateTwitter($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - tiktok
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateTiktok(Request $request)
    {
        $response = $this->userService->updateTiktok($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - blog
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateBlog(Request $request)
    {
        $response = $this->userService->updateBlog($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * メールアドレスが登録済か確認
     *
     * @param Request $request
     * @return false|string
     */
    public function checkEmail(Request $request)
    {
        $response = $this->userService->checkEmailRegisterd($request->input('email'));
        if (!$response) {
            throw new DOGException(config('const.ERROR.USER.EXISTS_EMAIL'), 400);
        }
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 管理画面から不正な画像を削除
     *
     * @param Request $request
     * @return false|string
     */
    public function deleteVoidImage(Request $request)
    {
        $response = $this->userService->deleteVoidImage($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 不正な画像のユーザーを取得
     *
     * @return false|string
     */
    public function getInfo()
    {
        $response = $this->userService->getAdminPageInfo();
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 不正なユーザーをキャンセル
     *
     * @param Request $request
     * @return false|string
     */
    public function updateYellowCard(Request $request)
    {
        $response = $this->userService->cancelVoidUser($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * トップページ用ランキングを取得
     *
     * @return false|string
     */
    public function getRanking()
    {
        $response = $this->userService->getRanking();
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * トップページ用ユーザー画像をランダムに取得
     *
     * @param int|null $offset
     * @return false|string
     */
    public function getUsers(?int $offset = null)
    {
        $response = $this->userService->getUsers($offset);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * フレンド情報を合わせて全てのユーザーを取得。
     *
     * @param int|null $offset
     * @return false|string
     */
    public function getUsersWithFriends(?int $offset = null)
    {
        $response = $this->userService->getUsers($offset);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * トップページ用ユーザー画像をランダムに取得
     *
     * @return false|string
     */
    public function random()
    {
        $response = $this->userService->getRanking();
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
