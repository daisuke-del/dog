<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class MatchController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * マッチング診断 -入力値genderをsessionに格納
     *
     * @param Request $request
     * @throws Exception
     */
    public function gender(Request $request) {
        $preGender = session('gender');
        Log::debug($preGender);
        $response = $this->userService->gender($request);
        $gender = session('gender');
        Log::debug($gender);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * マッチング診断 -入力値heightをsessionに格納
     *
     * @param Request $request
     * @throws Exception
     */
    public function height(Request $request)
    {
        $response = $this->userService->height($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * マッチング診断 -入力値weightをsessionに格納
     *
     * @param Request $request
     * @throws Exception
     */
    public function weight(Request $request)
    {
        $response = $this->userService->weight($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * マッチング診断 -入力値ageをsessionに格納
     *
     * @param Request $request
     * @throws Exception
     */
    public function age(Request $request)
    {
        $preAge = session('age');
        Log::debug($preAge);
        $response = $this->userService->age($request);
        $age= session('age');
        Log::debug($age);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * マッチング診断 -入力値salaryをsessionに格納
     *
     * @param Request $request
     * @throws Exception
     */
    public function salary(Request $request)
    {
        $response = $this->userService->salary($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * マッチング診断 -入力値face_pointをsessionに格納
     *
     * @param Request $request
     * @throws Exception
     */
    public function facePoint(Request $request)
    {
        $response = $this->userService->facePoint($request);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * face_point 自己診断スライダー用の画像を生成。
     *
     * @param Request $request
     * @throws Exception
     */
    public function sliderFace(Request $request)
    {
        $gender = session('gender');
        $all = $request->session()->all();
        Log::debug(print_r($all));
        Log::debug($gender);
        $response = $this->userService->getFaceList($request);

        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }


}
