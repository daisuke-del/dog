<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\DOGException;
use App\Http\Requests\UserRequest;
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;


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
        $dogImage = $this->storeDogImage($request->input('dogImage'));

        $requestArr = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'sex' => $request->input('sex'),
            'weight' => (int) $request->input('weight'),
            'breed1' => $request->input('breed1'),
            'breed2' => $request->input('breed2') ?: null,
            'dog_image' => $dogImage,
            'instagram_id' => $request->input('instagramId') ?: null,
            'twitter_id' => $request->input('twitterId') ?: null,
            'tiktok_id' => $request->input('tiktokId') ?: null,
            'blog_id' => $request->input('blogId') ?: null,
            'comment' => $request->input('comment') ?: null,
            'birthday' => $request->input('birthday'),
            'location' => $request->input('location') ?: null
        ];

        $response = $this->insertUsers($requestArr);

        if (empty($response)) {
            throw new DOGException(config('const.ERROR.USER.FAILED_REGISTERD'), 400);
        }
        if (!Auth::attempt($request->only(['email', 'password']), true)) {
            throw new DOGException(config('const.ERROR.USER.FAILED_REGISTERD'), 400);
        }

        return $this->usersRepository->getUser($email);
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
        Log::debug($userId);
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
        $user['weight'] = $weight;
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateWeight($users);
        return [
            'weight' => $users->getWeight(),
        ];
    }

    /**
     * 会員情報変更 - breed
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateBreed(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $breed1 = $request->input('breed1');
        $breed2 = $request->input('breed2');
        $user['breed1'] = $breed1;
        $user['breed2'] = $breed2;
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateBreed($users);
        return [
            'breed1' => $users->getBreed1(),
            'breed2' => $users->getBreed2()
        ];
    }

    /**
     * 会員情報変更 - breed
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateBirthday(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');
        $dateString = $user['birthday'];
        $yeraString = Carbon::parse($dateString)->format('Y');
        $dateMonth = Carbon::parse($dateString)->format('m');
        $monthString = sprintf('%02d', $dateMonth);
        $dateDay = Carbon::parse($dateString)->day;
        $dayString = sprintf('%02d', $dateDay);
        if ($year && $month && $day) {
            $birthday = $year . '-' . $month . '-' . $day . ' 00:00:00';
        } else if ($year && $month) {
            $birthday = $year . '-' . $month . '-' . $dayString . ' 00:00:00';
        } else if ($month && $day) {
            $birthday = $yeraString . '-' . $month . '-' . $day . ' 00:00:00';
        } else if ($year && $day) {
            $birthday = $year . '-' . $monthString . '-' . $day . ' 00:00:00';
        } else if ($year) {
            $birthday = $year . '-' . $monthString . '-' . $dayString . ' 00:00:00';
        } else if ($month) {
            $birthday = $yeraString . '-' . $month . '-' . $dayString . ' 00:00:00';
        } else if ($day) {
            $birthday = $yeraString . '-' . $monthString . '-' . $day . ' 00:00:00';
        }
        Log::debug($birthday);
        $user['birthday'] = $birthday;
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateBirthday($users);
        return [
            'birthday' => $users->getBirthday()
        ];
    }

    /**
     * 会員情報変更 - location
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function updateLocation(Request $request): array
    {
        $userId = Auth::id();
        $user = $this->getUsersById($userId);
        if (is_null($user)) {
            // ユーザーが取得できない
            throw new DOGException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $location = $request->input('location');
        $user['location'] = $location;
        $users = $this->usersRepository->new($user);
        $this->usersRepository->updateLocation($users);
        return [
            'location' => $users->getLocation()
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
        $weight = intval($request['weight']);
        return [
            'user_id' => $userId,
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'sex' => $request['sex'],
            'weight' => (int) $weight,
            'dog_point' => 0,
            'dog_image1' => $request['dog_image'],
            'dog_image2' => null,
            'dog_image3' => null,
            'breed1' => $request['breed1'],
            'breed2' => $request['breed2'] ?: null,
            'instagram_id' => $request['instagram_id'],
            'twitter_id' => $request['twitter_id'],
            'tiktok_id' => $request['tiktok_id'],
            'blog_id' => $request['blog_id'],
            'birthday' => $request['birthday'],
            'location' => $request['location'],
            'comment' => null,
            'yellow_card' => 0,
            'update_dog_at' => $now->format('Y-m-d H:i:s'),
            'create_date' => $now->format('Y-m-d H:i:s'),
            'dog_image_void_flg' => 0
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
        $this->usersRepository->upDogPoint($request->input('upDog'));
        $this->usersRepository->downDogPoint($request->input('downDog'));

        $responseInfo = [];
        while (count($responseInfo) < 2) {
            $responseInfo = $this->getChoiceInfo();
        }

        return $responseInfo;
    }

    /**
     * choice用画像を取得
     *
     *@return array
     */
    private function getChoiceInfo(): array
    {
        $userCnt = $this->usersRepository->getDogCnt();
        $randNum = mt_rand(2, $userCnt);
        $response = $this->usersRepository->getTwoUsersByDogPoint($randNum)->toArray();

        return $response;
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
        return $this->getChoiceInfo();
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

            $randomString = Str::random(10);
            $fileName = md5($img) . $randomString;
            $path = $fileName . '.' . $extension;

            Storage::disk('local')->put($path, $fileData);

            return $path;
        } catch (Exception $e) {
            Log::error($e);
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
        $imageNum = $request->input('num');
        if ($imageNum === 1) {
            $oldImage = $userInfo['dog_image1'];
            $column = 'dog_image1';
        } else if ($imageNum === 2) {
            $oldImage = $userInfo['dog_image2'];
            if (is_null($userInfo['dog_image1'])) {
                $column = 'dog_image1';
            } else {
                $column = 'dog_image2';
            }
        } else if ($imageNum === 3) {
            $oldImage = $userInfo['dog_image3'];
            if (is_null($userInfo['dog_image1'])) {
                $column = 'dog_image1';
            } else if (is_null($userInfo['dog_image2'])) {
                $column = 'dog_image2';
            } else {
                $column = 'dog_image3';
            }
        }
        try {
            $this->deleteDogImage($oldImage);
            $this->usersRepository->updateImage($userId, null, $column);
            $newImage = $this->storeDogImage($request->input('dogImage'));
            $this->usersRepository->updateImage($userId, $newImage, $column);
            return [
                'void_flg' => $userInfo['dog_image_void_flg'],
                $column => $newImage,
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
        $gender = $request->input('gender');
        $weight = $request->input('weight');
        $face = $request->input('face');
        $personality1 = $request->input('personality1');
        $personality2 = $request->input('personality2');
        $personality3 = $request->input('personality3');
        $holiday = $request->input('holiday');

        if ($gender === 'male') {
            if ($weight > 100) {
                $minWeight = 20000;
                $maxWeight = 100000;
            } else if ($weight > 70) {
                $minWeight = 8000;
                $maxWeight = 70000;
            } else if ($weight > 60) {
                $minWeight = 4000;
                $maxWeight = 50000;
            } else {
                $minWeight = 0;
                $maxWeight = 10000;
            }
        } else {
            if ($weight > 85) {
                $minWeight = 20000;
                $maxWeight = 100000;
            } else if ($weight > 60) {
                $minWeight = 8000;
                $maxWeight = 70000;
            } else if ($weight > 45) {
                $minWeight = 4000;
                $maxWeight = 50000;
            } else {
                $minWeight = 0;
                $maxWeight = 10000;
            }
        }
        $result = $this->usersRepository->getDiagnosisResult($minWeight, $maxWeight, $face, $personality1, $personality2, $personality3, $holiday)->toArray();
        if (empty($result)) {
            $result = $this->usersRepository->getDiagnosisResultAgain($minWeight, $maxWeight, $face, $personality1, $personality2, $personality3, $holiday)->toArray();
        }

        $choice = [];
        while (count($choice) < 2) {
            $choice = $this->getChoiceInfo();
        }

        $response = ['result' => $result, 'choice' => $choice];

        return $response;
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
        Log::debug($userInfo);
        $dogImage1 = $userInfo['dog_image1'];
        $dogImage2 = $userInfo['dog_image2'];
        $dogImage3 = $userInfo['dog_image3'];
        try {
            if (empty($dogImage3) === false) {
                if (!Storage::exists($dogImage3)) {
                    throw new DOGException(config('const.ERROR.ADMIN.NO_IMAGE'), 400);
                }
                $this->usersRepository->updateImage($userId, null, 'dog_image3', 0);
                Storage::delete($dogImage3);
            }
            if (empty($dogImage2) === false) {
                $userInfo2 = $this->usersRepository->selectUsersById($userId);
                if ($userInfo2['dog_image3']) {
                    if (!Storage::exists($dogImage2)) {
                        throw new DOGException(config('const.ERROR.ADMIN.NO_IMAGE'), 400);
                    }
                    $this->usersRepository->updateImage($userId, $userInfo2['dog_image3'], 'dog_image2', 0);
                    $this->usersRepository->updateImage($userId, null, 'dog_image3', 0);
                    Storage::delete($dogImage2);
                } else {
                    if (!Storage::exists($dogImage2)) {
                        throw new DOGException(config('const.ERROR.ADMIN.NO_IMAGE'), 400);
                    }
                    $this->usersRepository->updateImage($userId, null, 'dog_image2', 0);
                    Storage::delete($dogImage2);
                }
            }
            if (empty($dogImage1) === false) {
                $userInfo2 = $this->usersRepository->selectUsersById($userId);
                if ($userInfo2['dog_image2']) {
                    if (!Storage::exists($dogImage1)) {
                        throw new DOGException(config('const.ERROR.ADMIN.NO_IMAGE'), 400);
                    }
                    $this->usersRepository->updateImage($userId, $userInfo2['dog_image2'], 'dog_image1', 0);
                    Storage::delete($dogImage1);
                    if ($userInfo2['dog_image3']) {
                        $this->usersRepository->updateImage($userId, $userInfo2['dog_image3'], 'dog_image2', 0);
                        $this->usersRepository->updateImage($userId, null, 'dog_image3', 0);
                    } else {
                        $this->usersRepository->updateImage($userId, null, 'dog_image2', 0);
                    }
                } else {
                    if ($userInfo2['dog_image1']) {
                        if (!Storage::exists($dogImage1)) {
                            throw new DOGException(config('const.ERROR.ADMIN.NO_IMAGE'), 400);
                        }
                        $this->usersRepository->updateImage($userId, 'no-user-image-icon.png', 'dog_image1', 2);
                        Storage::delete($dogImage1);
                    }
                }
            }
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
        $voidUsers = $this->usersRepository->getVoidUsers();
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
        return $this->usersRepository->getRanking()->toArray();
    }

    /**
     * 全ユーザーを取得
     *
     * @return object
     */
    public function getUsers(?int $offset = null): object
    {
        $result = [];
        if (Auth::id()) {
            $userId = Auth::id();
            $result = $this->usersRepository->getUsersAllWithFriends($userId, $offset);
        } else {
            $result = $this->usersRepository->getUsersAll($offset);
        }
        return $result;
    }

    /**
     * 上位3匹のランキングを取得
     *
     * @return Collection
     */
    public function random(): Collection
    {
        return $this->usersRepository->getUserRandom();
    }
}
