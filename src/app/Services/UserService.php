<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Entities\UserEntity;
use App\Exceptions\MATCHException;
use App\Repositories\ReactionsRepository;
use App\ValueObjects\User\Age;
use App\ValueObjects\User\AuthCode;
use App\ValueObjects\User\CreateDate;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\FacebookId;
use App\ValueObjects\User\FaceImage;
use App\ValueObjects\User\FacePoint;
use App\ValueObjects\User\Gender;
use App\ValueObjects\User\Height;
use App\ValueObjects\User\InstagramId;
use App\ValueObjects\User\Password;
use App\ValueObjects\User\Salary;
use App\ValueObjects\User\TwitterId;
use App\ValueObjects\User\UpdateFaceAt;
use App\ValueObjects\User\UserId;
use App\ValueObjects\User\Weight;
use App\ValueObjects\User\YellowCard;
use App\Traits\ValidateEmail;
use Carbon\Carbon;
use Exception;
use Throwable;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Repositories\UsersRepository;
use App\Services\MypageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService
{
    use ValidateEmail;

    private $mypageService;
    private $usersRepository;
    private $reactionsRepository;

    public function __construct()
    {
        $this->mypageService = new MypageService;
        $this->usersRepository = new UsersRepository;
        $this->reactionsRepository = new ReactionsRepository;
    }

    /**
     * 会員登録
     *
     * @param Request $request
     * @throws Exception
     */
    public function signup(Request $request)
    {
        // userをemailで検索
        $email = (new Email($request->input('email')))->get();
        if ($this->containUppercase($email)) {
            throw new MATCHException(config('const.ERROR.USER.EMAIL_CONTAIN_UPPERCASE'), 400);
        }
        // emailが登録済かどうかチェック
        $registerd = $this->checkEmailRegisterd($email);
        if (!$registerd) {
            throw new MATCHException(config('const.ERROR.USER.EXISTS_EMAIL'), 400);
        }
        $storeInfo = $this->getCalculation($request);
        $faceImage = $this->storeFaceImage($request->input('faceImage'));

        $requestArr = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'gender' => $request->input('gender'),
            'height' => $storeInfo['height'],
            'weight' => $storeInfo['weight'],
            'age' => $storeInfo['age'],
            'salary' => $storeInfo['salary'],
            'face_point' => $storeInfo['facePoint'],
            'height2' => $storeInfo['height2'],
            'weight2' => $storeInfo['weight2'],
            'age2' => $storeInfo['age2'],
            'salary2' => $storeInfo['salary2'],
            'face_point2' => $storeInfo['facePoint2'],
            'face_image' => $faceImage,
            'facebook_id' => $request->input('facebookId'),
            'instagram_id' => $request->input('instagramId'),
            'twitter_id' => $request->input('twitterId'),
        ];

        $response = $this->insertUsers($requestArr);

        if (empty($response)) {
            throw new MATCHException(config('const.ERROR.USER.FAILED_REGISTERD'), 400);
        }
        if (!Auth::attempt($request->only(['email', 'password']), true)) {
            throw new MATCHException(config('const.ERROR.USER.FAILED_REGISTERD'), 400);
        }

        if (Auth::check()) {
            return Auth::user();
        }
    }

    /**
     * メールアドレスが登録済かどうか確認
     *
     * @param $email
     * @return bool
     */
    public function checkEmailRegisterd(String $email)
    {
        if ($this->usersRepository->existsEmail($email)) {
            return false;
        }
        return true;
    }

    /**
     * ログイン
     *
     * @param Request $request
     * @throws Exception
     * @throws Throwable
     */
    public function login(Request $request)
    {
        // userをemailで検索
        $email = (new Email($request->input('email')))->get();
        $user = $this->usersRepository->getUser($email);
        if (is_null($user)) {
            throw new MATCHException(config('const.ERROR.USER.LOGIN_FAILED'), 401);
        }

        if (Auth::attempt($request->only(['email', 'password']), true)) {
            return Auth::user();
        }
        throw new MATCHException(config('const.ERROR.USER.LOGIN_FAILED'), 401);
    }

    /**
     * 管理画面ログイン
     *
     * @param Request $request
     * @throws Exception
     * @throws Throwable
     */
    public function adminLogin(Request $request)
    {
        // userをemailで検索
        $email = $request->input('email');
        $user = $this->usersRepository->getAdminUser($email);
        if (is_null($user)) {
            throw new MATCHException(config('const.ERROR.AUTH.LOGIN_FAILED'), 401);
        }

        if (Auth::guard('admin')->attempt($request->only(['email', 'password']), true)) {
            return Auth::guard('admin')->user();
        }
        throw new MATCHException(config('const.ERROR.AUTH.LOGIN_FAILED'), 401);
    }

    /**
     * ログアウト
     *
     * @return array
     */
    public function adminLogout()
    {
        Auth::guard('admin')->logout();
    }

    /**
     * ログアウト
     *
     * @return array
     */
    public function logout()
    {
        Auth::logout();
    }

    /**
     * 会員情報変更 - email
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateEmail(Request $request): array
    {
        $userId = Auth::id();
        $password = $request->input('password');
        $email = (new Email($request->input('email')))->get();
        if ($this->containUppercase($email)) {
            throw new MATCHException(config('const.ERROR.USER.EMAIL_CONTAIN_UPPERCASE'), 400);
        }
        if ($this->usersRepository->existsEmail($email)) {
            throw new MATCHException(config('const.ERROR.USER.EXISTS_EMAIL'), 400);
        }
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        if (!$this->checkPassword($user, $password)) {
            // パスワードが異なる
            throw new MATCHException(config('const.ERROR.USER.PASSWORD_DIFFERENT'), 401);
        }
        $user['email'] = $email;
        $user['password'] = $password;
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateEmail($users);
        return [];
    }

    /**
     * 退会
     *
     */
    public function leave(): bool
    {
        $userId = Auth::id();
        Auth::logout();
        $result = $this->usersRepository->deleteUser($userId);
        return $result;
    }

    /**
     * 会員情報変更 - name
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateName(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $user['name'] = $request->input('name');
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateName($users);
        return [
            'name' => $users->getName()
        ];
    }

    /**
     * 会員情報変更 - height
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateHeight(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $height = $request->input('height');
        if ($user['gender'] === 'male') {
            $height2 = ($height - 150) * 2;
        } else {
            $height2 = 30;
        }
        $user['height'] = $height;
        $user['height2'] = $height2;
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateHeight($users);
        return [
            'height' => $users->getHeight(),
            'height2' => $users->getHeight2()
        ];
    }

    /**
     * 会員情報変更 - weight
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateWeight(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $weight = $request->input('weight');
        $height = $user['height'];
        if ($user['gender'] === 'male') {
            $weight2 = abs($weight / ($height * $height / 10000) - 20) * 3;
        } else {
            $weight2 = ($weight / ($height * $height / 10000) - 20) * 3;
        }
        $user['weight'] = $weight;
        $user['weight2'] = $weight2;
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateWeight($users);
        return [
            'weight' => $users->getWeight(),
            'weight2' => $users->getWeight2()
        ];
    }

    /**
     * 会員情報変更 - age
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateAge(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $age = $request->input('age');
        if ($user['gender'] === 'male') {
            $age2 = abs($age - 27);
        } else {
            $age2 = $age - 23;
        }
        $user['age'] = $age;
        $user['age2'] = $age2;
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateAge($users);
        return [
            'age' => $users->getAge(),
            'age2' => $users->getAge2()
        ];
    }

    /**
     * 会員情報変更 - salary
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateSalary(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $salary2 = $request->input('salary2');
        $salary2 = $salary2 / 10 - 30;
        $user['salary'] = $request->input('salary');
        $user['salary2'] = $salary2;
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateSalary($users);
        return [
            'salary' => $users->getSalary(),
            'salary2' => $users->getSalary2()
        ];
    }

    /**
     * 会員情報変更 - facebook_id
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateFacebook(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $user['facebook_id'] = $request->input('facebook');
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateFacebook($users);
        return [
            'facebook_id' => $users->getFacebookId()
        ];
    }

    /**
     * 会員情報変更 - instagram_id
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateInstagram(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $user['instagram_id'] = $request->input('instagram');
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateInstagram($users);
        return [
            'instagram_id' => $users->getInstagramId()
        ];
    }

    /**
     * 会員情報変更 - twitter_id
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateTwitter(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $user['twitter_id'] = $request->input('twitter');
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateTwitter($users);
        return [
            'twitter_id' => $users->getTwitterId()
        ];
    }

    /**
     * ランダムにUserIdを生成する
     *
     * @return string
     */
    private function createUserId(): string
    {
        $userId = '';
        $isUnique = false;
        while ($isUnique === false) {
            $userId = Uuid::uuid4()->toString();
            if ($this->usersRepository->existsusers($userId) === false) {
                $isUnique = true;
            }
        }
        return $userId;
    }

    /**
     * Userテーブルの登録を行う (レコードが存在していたら更新)
     *
     * @param array $users
     * @param array $request
     * @return array
     * @throws Exception
     */
    private function registerUsers(array $users, array $request)
    {
        if ($this->usersRepository->existsUsers($users['uid'])) {
            $user = $this->usersRepository->selectUsersById($users['uid']);
            $users = array_merge($user->toArray(), $users);
            $now = new Carbon();
            $authCode = mt_rand(100000, 999999);
            $users['auth_code'] = $authCode;
            $userEntity = $this->usersRepository->new($users);
            $this->usersRepository->updateUsers($userEntity);
            return [
                'user_id' => $users['uid'],
                'auth_code' => $authCode
            ];
        }

        $entityParam = $this->getRegisterEntityParam($request, $users['uid']);
        $userEntity = $this->usersRepository->new($entityParam);
        $this->usersRepository->saveUsers($userEntity);
        return [
            'user_id' => $users['uid'],
            'auth_code' => $entityParam['auth_code']
        ];
    }

    /**
     * 登録時に必要なパラメーターを取得する
     *
     * @param array $request
     * @param string|null $userId
     * @return array
     * @throws Exception
     */
    private function getRegisterEntityParam(array $request, string $userId = null)
    {
        if (is_null($userId)) {
            $userId = $this->createUserId();
        }
        $now = new Carbon();
        $orderNumber = mt_rand(0, 10000);
        return [
            'user_id' => $userId,
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'gender' => $request['gender'],
            'height' => $request['height'],
            'weight' => $request['weight'],
            'age' => $request['age'],
            'salary' => $request['salary'],
            'face_point' => $request['face_point'],
            'height2' => $request['height2'],
            'weight2' => $request['weight2'],
            'age2' => $request['age2'],
            'salary2' => $request['salary2'],
            'face_point2' => $request['face_point2'],
            'face_image' => $request['face_image'],
            'facebook_id' => $request['facebook_id'],
            'instagram_id' => $request['instagram_id'],
            'twitter_id' => $request['twitter_id'],
            'yellow_card' => 0,
            'create_date' => $now->format('Y-m-d H:i:s'),
            'update_face_at' => $now->format('Y-m-d H:i:s'),
            'face_image_void_flg' => 0,
            'order_number' => $orderNumber
        ];
    }

    /**
     * user_idをもとにusersテーブルから取得
     *
     * @param string $userId
     * @return array
     * @throws Exception
     */
    public function getUsersById(string $userId): array
    {
        $users = $this->usersRepository->selectusersById($userId)->toArray();
        if (empty($users)) {
            // ユーザー情報が取得できない
            $error = [
                'error_code' => config('const.ERROR_CODE.SETTLEMENT.NO_USER'),
                'user_id' => $userId
            ];
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404, $error);
        }
        return $users;
    }

    /**
     * 会員登録でusersに登録する
     *
     * @param array $request
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    private function insertUsers(array $request): array
    {
        $entityParam = $this->getRegisterEntityParam($request);
        $users = $this->usersRepository->new($entityParam);
        // usersテーブルに新規追加
        $this->usersRepository->save($users);
        // レスポンス
        return $entityParam;
    }

    /**
     * パスワードの生成に使用したメールアドレスを特定する
     *
     * @param array $users
     * @param string $password
     * @return bool
     * @throws Exception
     */
    private function checkPassword(array $users, string $password): bool
    {
        $email = $users['email'];
        $hashPass = (new Password($password))->get();
        if (is_null($this->usersRepository->existsUsersByPass($email, $hashPass))) {
            return false;
        }
        return true;
    }

    /**
     * choiceの２画像を取得
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function upDownFacePoint(Request $request): array
    {
        $this->usersRepository->upFacePoint($request->input('upUser'));
        $this->usersRepository->downFacePoint($request->input('downUser'));

        $responseInfo = [];
        $gender = $request->input('gender');
        while (count($responseInfo) < 2) {
            $responseInfo = $this->getChoiceInfo($gender);
        }

        return $responseInfo;
    }

    /**
     * choice用画像を取得
     *
     *@param string $gender
     *@return array
     */
    private function getChoiceInfo($gender): array
    {
        $maxNum = $this->usersRepository->getMaxFacePoint($gender);
        $randNum = mt_rand(1, $maxNum['face_point']);
        $response = $this->usersRepository->getTwoUsersByFacePoint($randNum, $gender);

        return $response->toArray();
    }

    /**
     * yellow_cardを更新
     *
     * @param string $userId
     * @param int $num
     * @return bool
     * @throws Exception
     */
    private function updateYellowCard($userId, $num): bool
    {
        return $this->usersRepository->updateYellowCard($userId, $num);
    }

    /**
     * yellow_cardを更新して、choice用画像を取得
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateYellowAndGetFace(Request $request): array
    {
        $this->updateAndCheckYellowCard($request->input('userId'));
        $gender = $request->input('gender');
        return $this->getChoiceInfo($gender);
    }

    /**
     * yellowCardを更新して、face_image_void_flgを更新
     *
     * @param string $upOrDown
     * @param string $userId
     * @return void
     * @throws Exception
     */
    private function updateAndCheckYellowCard(string $userId): void
    {
        $this->usersRepository->upYellowCard($userId);
        $yellowCard = $this->usersRepository->getYellowCard($userId);
        if ($yellowCard > 2) {
            $this->usersRepository->updateFaceImageVoidFlg($userId, 1);
        }
    }

    /**
     * order方法をランダムに決定。
     *
     * @return string
     * @throws Exception
     */
    public function decideOrderProcess(): string
    {
        $randomNumber = mt_rand(1, 2);
        switch ($randomNumber) {
            case 1:
                return 'desc';
            default:
                return 'asc';
        }
    }

    /**
     * faceImageをdecodeして保存する。
     *
     * @param string $faceImage
     * @return string
     */
    public function storeFaceImage($faceImage): string
    {
        try {
            preg_match('/data:image\/(\w+);base64,/', $faceImage, $matches);
            $extension = $matches[1];

            $img = preg_replace('/^data:image.*base64,/', '', $faceImage);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);

            $fileName = md5($img);
            $path = $fileName . '.' . $extension;

            Storage::disk('local')->put($path, $fileData);

            return $path;
        } catch (Exception $e) {
            Log::error($e);
            throw new MATCHException('画像の保存に失敗しました', 400);
        }
    }

    /**
     * face_imageとface_pointを30件取得
     *
     * @param Request $request
     * @return array
     */
    public function getFace(Request $request): array
    {
        $gender = $request->input('gender');
        $sort = ['asc', 'desc'];
        $key = array_rand($sort, 1);
        $response = $this->usersRepository->getFace($gender, $sort[$key], 30)->toArray();

        if (!$response) {
            throw new MATCHException(config('スライダー画像の取得に失敗しました'), 400);
        }

        $sortFacePoint = array_column($response, 'face_point');

        array_multisort($sortFacePoint, SORT_ASC, $response);

        return $response;
    }

    /**
     * 顔写真を更新
     *
     * @param Request $request
     * @return array
     */
    public function updateFaceImage(Request $request): array
    {
        $userId = Auth::id();
        $userInfo = $this->usersRepository->selectUsersById($userId)->toArray();
        $oldImage = $userInfo['face_image'];
        try {
            $this->deleteFaceImage($oldImage);
            $newImage = $this->storeFaceImage($request->input('faceImage'));
            $this->usersRepository->updateFace($userId, $newImage);
            $continuationScore = $this->mypageService->getContinuationScore($userInfo['update_face_at']);
            $rank = $this->mypageService->getFaceStatus($userId, $continuationScore);
            return [
                'user_id' => $userInfo['user_id'],
                'gender' => $userInfo['gender'],
                'name' => $userInfo['name'],
                'void_flg' => $userInfo['face_image_void_flg'],
                'rank' => $rank,
                'face_image' => $newImage,
                'face_point' => $userInfo['face_point'],
                'score' => $continuationScore,
            ];
        } catch (Exception $e) {
            Log::error($e);
            throw new MATCHException('画像の更新に失敗しました', 400);
        }
    }

    /**
     * @param string $imagePath
     * @return bool
     */
    public function deleteFaceImage($imagePath): bool
    {
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
            return true;
        }
        return false;
    }

    /**
     * emailが登録済かどうかをチェックする
     *
     * @param string $email
     * @return void
     * @throws Exception
     * @throws Throwable
     */
    public function checkEmail(string $email): void
    {
        $checkedEmail = (new Email($email))->get();
        if ($this->containUppercase($checkedEmail)) {
            throw new MATCHException(config('const.ERROR.USER.EMAIL_CONTAIN_UPPERCASE'), 400);
        }

        $result = $this->usersRepository->getUserByMail($checkedEmail);
        if (isset($result)) {
            throw new MATCHException(config('const.ERROR.USER.ALREADY_REGISTERED'), 400);
        }
    }

    /**
     * match結果を取得
     *
     * @param Request $request
     * @return array
     */
    public function getResult(Request $request): array
    {
        $userInfo = $this->getCalculation($request);
        if ($request->input('gender') === 'male') {
            $genderSort = 'female';
        } else {
            $genderSort = 'male';
        }
        $params = ['genderSort' => $genderSort, 'height2' => $userInfo['height2'], 'weight2' => $userInfo['weight2'], 'age2' => $userInfo['age2'], 'salary2' => $userInfo['salary2'], 'facePoint2' => $userInfo['facePoint2']];
        $place = $request->input('place');

        $results = $this->usersRepository->getMatchResult($params, $place)->toArray();
        $arrayResults = json_decode(json_encode($results), true);
        if (Auth::check()) {
            $userId = Auth::id();
            $resultAddFavorite = $this->checkFavorite($userId, $arrayResults);
            if (isset($resultAddFavorite['onesideLoveId'])) {
                $i = 0;
                foreach ($arrayResults as $result) {
                    $i++;
                    $n = $i - 1;
                    if (in_array($result['user_id'], $resultAddFavorite['onesideLoveId'])) {
                        $arrayResults[$n]['onesideLove'] = 1;
                        if (in_array($result['user_id'], $resultAddFavorite['mutualLoveId'])) {
                            $arrayResults[$n]['mutualLove'] = 1;
                        } else {
                            $arrayResults[$n]['mutualLove'] = 0;
                        }
                    } else {
                        $arrayResults[$n]['onesideLove'] = 0;
                        $arrayResults[$n]['mutualLove'] = 0;
                    }
                }
            }
        }

        $choice = [];
        while (count($choice) < 2) {
            $choice = $this->getChoiceInfo($genderSort);
        }

        $response = ['result' => $arrayResults, 'choice' => $choice];

        return $response;
    }

    /**
     * 診断指標の計算関数
     *
     * @param Request $request
     * @return array
     */
    public function getCalculation(Request $request): array
    {
        $gender = $request->input('gender');
        $height = (int) $request->input('height');
        $weight = (int) $request->input('weight');
        $age = (int) $request->input('age');
        $salary = (int) $request->input('salary');
        $salary2 = $salary / 10 - 30;
        $facePoint = (int) $request->input('facePoint');
        $facePoint2 = $facePoint * 2;

        if ($gender === 'male') {
            $height2 = ($height - 150) * 2;
            $weight2 = abs($weight / ($height * $height / 10000) - 20) * 3;
            $age2 = abs($age - 27);
        } else {
            $height2 = 30;
            $weight2 = ($weight / ($height * $height / 10000) - 20) * 3;
            $age2 = $age - 23;
        }

        return [
            'height' => $height,
            'weight' => $weight,
            'age' => $age,
            'salary' => $salary,
            'facePoint' => $facePoint,
            'height2' => $height2,
            'weight2' => $weight2,
            'age2' => $age2,
            'salary2' => $salary2,
            'facePoint2' => $facePoint2
        ];
    }

    /**
     * お気に入りしているか確認
     *
     * @param array $users
     * @return array
     */
    private function checkFavorite($userId, $results): array
    {
        $onesideLoversIds = [];
        $mutualLoversIds = [];
        foreach ($results as $result) {
            $resultIds[] = $result['user_id'];
        }
        $onesideLovers = $this->reactionsRepository->getResultFavorite($userId, $resultIds);
        if (isset($onesideLovers)) {
            $onesideLoversIds = [];
            foreach ($onesideLovers as $onesideLover) {
                $onesideLoversIds[] = $onesideLover['to_user_id'];
            }
            $mutualLovers = $this->reactionsRepository->getResultBeFavorited($userId, $onesideLoversIds);
            if (empty($mutualLovers)) {
                return [
                    'onesideLoveId' => $onesideLoversIds
                ];
            }
            foreach ($mutualLovers->toArray() as $mutualLover) {
                $mutualLoversIds[] = $mutualLover['user_id'];
            }
            if ($mutualLovers) {
                return [
                    'onesideLoveId' => $onesideLoversIds,
                    'mutualLoveId' => $mutualLoversIds
                ];
            }
            return [
                'onesideLoveId' => $onesideLoversIds
            ];
        }

        return false;
    }

    /**
     * 画像を保存
     *
     * @param Request $request
     * @return null|array
     */
    public function storeImage($request): ?array
    {
        $img = $request->input('faceImage');
        $newImage = $this->storeFaceImage($img);
        return ['newImage' => $newImage];
    }

    /**
     * 不正な画像を削除してデフォルトの画像パスを設定する
     *
     * @param Request $request
     * @return bool
     */
    public function deleteVoidImage($request): bool
    {
        $userId = $request->input('userId');
        $userInfo = $this->usersRepository->selectUsersById($userId);
        $faceImage = $userInfo['face_image'];
        try {
            if (!Storage::exists($faceImage)) {
                throw new MATCHException(config('const.ERROR.ADMIN.NO_IMAGE'), 400);
            }
            $this->usersRepository->updateFace($userId, 'no-user-image-icon.jpeg', 2);
            Storage::delete($faceImage);
        } catch (Exception $e) {
            Log::error($e);
            throw new MATCHException(config('const.ERROR.ADMIN.FAILED'), 400);
        }
        return true;
    }

    /**
     * 不正な画像のユーザーを取得
     *
     * @return object
     */
    public function getVoidUsers(): object
    {
        return $this->usersRepository->getVoidUsers();
    }

    /**
     * 不正状態をキャンセル
     *
     * @param Request $request
     * @return void
     */
    public function cancelVoidUser(Request $request): void
    {
        $userId = $request->input('userId');
        if ($this->updateYellowCard($userId, 0)) {
            $this->usersRepository->updateFaceImageVoidFlg($userId, 0);
        }
    }
}
