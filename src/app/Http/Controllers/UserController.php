<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Exceptions\MATCHException;

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
     * 会員情報変更 - email - 認証
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateEmailAuth(Request $request)
    {
        $response = $this->userService->updateEmailAuth($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - password
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updatePassword(Request $request)
    {
        $response = $this->userService->updatePassword($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - handle_name
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
     * パスワード忘れました - メールアドレス入力
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function forgetPasswordEmail(Request $request)
    {
        $response = $this->userService->forgetPasswordEmail($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * パスワード忘れました - 認証コード入力
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function forgetPasswordAuth(Request $request)
    {
        $response = $this->userService->forgetPasswordAuth($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * パスワード忘れました - パスワード更新
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function forgetPasswordUpdate(Request $request)
    {
        $response = $this->userService->forgetPasswordUpdate($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * face_imageとface_pointをorder_number順に30件取得
     *
     * @param Request $request
     * @return false|string
     */
    public function slider(Request $request)
    {
        $response = $this->userService->getFace($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員登録時のスライダー画像を取得。登録emailのチェック
     *
     * @param Request $request
     * @return false|string
     */
    public function signupSlider(Request $request)
    {
        $email = $request->input('email');
        $this->userService->checkEmail($email);
        $response = $this->userService->getFace($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
