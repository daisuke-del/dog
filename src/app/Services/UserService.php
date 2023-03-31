<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\DOGException;
use App\Repositories\ReactionsRepository;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\Password;
use App\Traits\ValidateEmail;
use Carbon\Carbon;
use Exception;
use Throwable;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Repositories\UsersRepository;
use App\Services\SupportService;
use App\Services\MypageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService
{
    use ValidateEmail;

    private $mypageService;
    private $supportService;
    private $usersRepository;
    private $reactionsRepository;

    public function __construct()
    {
        $this->mypageService = new MypageService;
        $this->supportService = new SupportService;
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
            throw new DOGException(config('const.ERROR.USER.EMAIL_CONTAIN_UPPERCASE'), 400);
        }
        // emailが登録済かどうかチェック
        $registerd = $this->checkEmailRegisterd($email);
        if (!$registerd) {
            throw new DOGException(config('const.ERROR.USER.EXISTS_EMAIL'), 400);
        }
        $storeInfo = $this->getCalculation($request);
        $dogImage = $this->storeDogImage($request->input('dogImage'));

        $requestArr = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'sex' => $request->input('sex'),
            'height' => $storeInfo['height'],
            'weight' => $storeInfo['weight'],
            'age' => $storeInfo['age'],
            'salary' => $storeInfo['salary'],
            'dog_point' => $storeInfo['dogPoint'],
            'height2' => $storeInfo['height2'],
            'weight2' => $storeInfo['weight2'],
            'age2' => $storeInfo['age2'],
            'salary2' => $storeInfo['salary2'],
            'dog_point2' => $storeInfo['dogPoint2'],
            'dog_image' => $dogImage,
            'facebook_id' => $request->input('facebookId'),
            'instagram_id' => $request->input('instagramId'),
            'twitter_id' => $request->input('twitterId'),
        ];

        $response = $this->insertUsers($requestArr);

        if (empty($response)) {
            throw new DOGException(config('const.ERROR.USER.FAILED_REGISTERD'), 400);
        }
        if (!Auth::attempt($request->only(['email', 'password']), true)) {
            throw new DOGException(config('const.ERROR.USER.FAILED_REGISTERD'), 400);
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
            throw new DOGException(config('const.ERROR.USER.LOGIN_FAILED'), 401);
        }

        if (Auth::attempt($request->only(['email', 'password']), true)) {
            return Auth::user();
        }
        throw new DOGException(config('const.ERROR.USER.LOGIN_FAILED'), 401);
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
            throw new DOGException(config('const.ERROR.AUTH.LOGIN_FAILED'), 401);
        }

        if (Auth::guard('admin')->attempt($request->only(['email', 'password']), true)) {
            return Auth::guard('admin')->user();
        }
        throw new DOGException(config('const.ERROR.AUTH.LOGIN_FAILED'), 401);
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
            throw new DOGException(config('const.ERROR.USER.EMAIL_CONTAIN_UPPERCASE'), 400);
        }
        if ($this->usersRepository->existsEmail($email)) {
            throw new DOGException(config('const.ERROR.USER.EXISTS_EMAIL'), 400);
        }
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        if (!$this->checkPassword($user, $password)) {
            // パスワードが異なる
            throw new DOGException(config('const.ERROR.USER.PASSWORD_DIFFERENT'), 401);
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
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
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
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $height = $request->input('height');
        if ($user['sex'] === 'male') {
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
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $weight = $request->input('weight');
        $height = $user['height'];
        if ($user['sex'] === 'male') {
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
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $age = $request->input('age');
        if ($user['sex'] === 'male') {
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
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
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
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $user['twitter_id'] = $request->input('twitter');
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateTwitter($users);
        return [
            'twitter_id' => $users->getTwitterId()
        ];
    }

    /**
     * 会員情報変更 - tiktok_id
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateTiktok(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $user['tiktok_id'] = $request->input('tiktok');
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateTiktok($users);
        return [
            'tiktok_id' => $users->getTiktokId()
        ];
    }

    /**
     * 会員情報変更 - blog_id
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateBlog(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $user['blog_id'] = $request->input('blog');
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateBlog($users);
        return [
            'blog_id' => $users->getBlogId()
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
            'sex' => $request['sex'],
            'weight' => $request['weight'],
            'birthday' => $request['birthday'],
            'salary' => $request['salary'],
            'dog_point' => $request['dog_point'],
            'dog_image' => $request['dog_image'],
            'dog_image2' => $request['dog_image2'],
            'dog_image3' => $request['dog_image3'],
            'instagram_id' => $request['instagram_id'],
            'twitter_id' => $request['twitter_id'],
            'tiktok_id' => $request['tiktok_id'],
            'blog_id' => $request['blog_id'],
            'yellow_card' => 0,
            'create_date' => $now->format('Y-m-d H:i:s'),
            'update_dog_at' => $now->format('Y-m-d H:i:s'),
            'dog_image_void_flg' => 0,
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
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404, $error);
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
    public function upDownDogPoint(Request $request): array
    {
        $this->usersRepository->upDogPoint($request->input('upUser'));
        $this->usersRepository->downDogPoint($request->input('downUser'));

        $responseInfo = [];
        $sex = $request->input('sex');
        while (count($responseInfo) < 2) {
            $responseInfo = $this->getChoiceInfo($sex);
        }

        return $responseInfo;
    }

    /**
     * choice用画像を取得
     *
     *@param string $sex
     *@return array
     */
    private function getChoiceInfo($sex): array
    {
        $maxNum = $this->usersRepository->getMaxDogPoint($sex);
        $randNum = mt_rand(1, $maxNum['dog_point']);
        $response = $this->usersRepository->getTwoUsersByDogPoint($randNum, $sex);

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
        $sex = $request->input('sex');
        return $this->getChoiceInfo($sex);
    }

    /**
     * yellowCardを更新して、dog_image_void_flgを更新
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
        if ($yellowCard['yellow_card'] > 2) {
            $this->usersRepository->updateDogImageVoidFlg($userId, 1);
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
     * dogImageをdecodeして保存する。
     *
     * @param string $dogImage
     * @return string
     */
    public function storeDogImage($dogImage): string
    {
        try {
            preg_match('/data:image\/(\w+);base64,/', $dogImage, $matches);
            $extension = $matches[1];

            $img = preg_replace('/^data:image.*base64,/', '', $dogImage);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);

            $fileName = md5($img);
            $path = $fileName . '.' . $extension;

            Storage::disk('local')->put($path, $fileData);

            return $path;
        } catch (Exception $e) {
            Log::error($e);
            throw new DOGException('画像の保存に失敗しました', 400);
        }
    }

    /**
     * 顔写真を更新
     *
     * @param Request $request
     * @return array
     */
    public function updateDogImage(Request $request): array
    {
        $userId = Auth::id();
        $userInfo = $this->usersRepository->selectUsersById($userId)->toArray();
        $oldImage = $userInfo['dog_image'];
        try {
            $this->deleteDogImage($oldImage);
            $newImage = $this->storeDogImage($request->input('dogImage'));
            $this->usersRepository->updateFace($userId, $newImage);
            $continuationScore = $this->mypageService->getContinuationScore($userInfo['update_dog_at']);
            $rank = $this->mypageService->getFaceStatus($userId, $continuationScore);
            return [
                'user_id' => $userInfo['user_id'],
                'sex' => $userInfo['sex'],
                'name' => $userInfo['name'],
                'void_flg' => $userInfo['dog_image_void_flg'],
                'rank' => $rank,
                'dog_image' => $newImage,
                'dog_point' => $userInfo['dog_point'],
                'score' => $continuationScore,
            ];
        } catch (Exception $e) {
            Log::error($e);
            throw new DOGException('画像の更新に失敗しました', 400);
        }
    }

    /**
     * @param string $imagePath
     * @return bool
     */
    public function deleteDogImage($imagePath): bool
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
            throw new DOGException(config('const.ERROR.USER.EMAIL_CONTAIN_UPPERCASE'), 400);
        }

        $result = $this->usersRepository->getUserByMail($checkedEmail);
        if (isset($result)) {
            throw new DOGException(config('const.ERROR.USER.ALREADY_REGISTERED'), 400);
        }
    }

    /**
     * diagnosis結果を取得
     *
     * @param Request $request
     * @return array
     */
    public function getResult(Request $request): array
    {
        $userInfo = $this->getCalculation($request);
        if ($request->input('sex') === 'male') {
            $sexSort = 'female';
        } else {
            $sexSort = 'male';
        }
        $params = ['sexSort' => $sexSort, 'height2' => $userInfo['height2'], 'weight2' => $userInfo['weight2'], 'age2' => $userInfo['age2'], 'salary2' => $userInfo['salary2'], 'dogPoint2' => $userInfo['dogPoint2']];
        $place = $request->input('place');

        $results = $this->usersRepository->getDiagnosisResult($params, $place)->toArray();
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
            $choice = $this->getChoiceInfo($sexSort);
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
        $sex = $request->input('sex');
        $height = (int) $request->input('height');
        $weight = (int) $request->input('weight');
        $age = (int) $request->input('age');
        $salary = (int) $request->input('salary');
        $salary2 = $salary / 10 - 30;
        $dogPoint = (int) $request->input('dogPoint');
        $dogPoint2 = $dogPoint * 2;

        if ($sex === 'male') {
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
            'dogPoint' => $dogPoint,
            'height2' => $height2,
            'weight2' => $weight2,
            'age2' => $age2,
            'salary2' => $salary2,
            'dogPoint2' => $dogPoint2
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
                $mutualLoversIds[] = $mutualLover['from_user_id'];
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
        $img = $request->input('dogImage');
        $newImage = $this->storeDogImage($img);
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
        $dogImage = $userInfo['dog_image'];
        try {
            if (!Storage::exists($dogImage)) {
                throw new DOGException(config('const.ERROR.ADMIN.NO_IMAGE'), 400);
            }
            $this->usersRepository->updateFace($userId, 'no-user-image-icon.jpeg', 2);
            Storage::delete($dogImage);
        } catch (Exception $e) {
            Log::error($e);
            throw new DOGException(config('const.ERROR.ADMIN.FAILED'), 400);
        }
        return true;
    }

    /**
     * 不正な画像のユーザーを取得
     *
     * @return array
     */
    public function getAdminPageInfo(): array
    {
        $voidUsers =  $this->usersRepository->getVoidUsers();
        $supports = $this->supportService->getSupports();
        return [
            'voidUsers' => $voidUsers,
            'supports' => $supports
        ];
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
            $this->usersRepository->updateDogImageVoidFlg($userId, 0);
        }
    }

    /**
     * 上位3匹のランキングを取得
     *
     * @return array
     */
    public function getRanking(): array
    {
        $dogs = $this->usersRepository->getRanking();

        return [
            'dogs' => $dogs,
        ];
    }
}
