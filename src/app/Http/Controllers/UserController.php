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
     * 退会
     *
     *
     */
    public function leave()
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
     * 会員情報変更 - height
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateHeight(Request $request)
    {
        $response = $this->userService->updateHeight($request);
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
     * 会員情報変更 - age
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateAge(Request $request)
    {
        $response = $this->userService->updateAge($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - salary
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateSalary(Request $request)
    {
        $response = $this->userService->updateSalary($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - face_image
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateFaceImage(Request $request)
    {
        $response = $this->userService->updateFaceImage($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 会員情報変更 - facebook
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    public function updateFacebook(Request $request)
    {
        $response = $this->userService->updateFacebook($request);
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
            throw new MATCHException(config('const.ERROR.USER.EXISTS_EMAIL'), 400);
        }
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
