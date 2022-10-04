<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Http\Requests\UserRequest;
use App\Services\UserService;

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
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function signup(UserRequest $request)
    {
        $response = $this->userService->signup($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員認証
     *
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function auth(UserRequest $request)
    {
        $response = $this->userService->auth($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * ログイン
     *
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function login(UserRequest $request)
    {
        $response = $this->userService->login($request);
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
     * 会員情報変更 - email
     *
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     */
    public function updateEmail(UserRequest $request)
    {
        $response = $this->userService->updateEmail($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - email - 認証
     *
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     */
    public function updateEmailAuth(UserRequest $request)
    {
        $response = $this->userService->updateEmailAuth($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - password
     *
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     */
    public function updatePassword(UserRequest $request)
    {
        $response = $this->userService->updatePassword($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - handle_name
     *
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     */
    public function updateName(UserRequest $request)
    {
        $response = $this->userService->updateName($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * パスワード忘れました - メールアドレス入力
     *
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     */
    public function forgetPasswordEmail(UserRequest $request)
    {
        $response = $this->userService->forgetPasswordEmail($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * パスワード忘れました - 認証コード入力
     *
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     */
    public function forgetPasswordAuth(UserRequest $request)
    {
        $response = $this->userService->forgetPasswordAuth($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * パスワード忘れました - パスワード更新
     *
     * @param UserRequest $request
     * @return false|string
     * @throws Exception
     */
    public function forgetPasswordUpdate(UserRequest $request)
    {
        $response = $this->userService->forgetPasswordUpdate($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

}
