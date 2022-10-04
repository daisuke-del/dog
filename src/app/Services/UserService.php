<?php

namespace App\Services;

use App\Entities\UserEntity;
use App\Exceptions\MUCHException;
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
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Repositories\UsersRepository;
use function PHPUnit\Framework\isNull;
use function Psy\debug;
use Illuminate\Support\Facades\Log;
use Illuminate\Session\Store;

class UserService
{
    use ValidateEmail;

    private $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository;
    }

    /**
     * 会員登録
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     */
    public function signup(UserRequest $request): array
    {
        $requestArr = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),

        ];
        $email = (new Email($requestArr['email']))->get();
        if ($this->containUppercase($email)) {
            throw new MUCHException(config('const.ERROR.USER.EMAIL_CONTAIN_UPPERCASE'), 400);
        }

        $response = $this->insertUsers($requestArr);

        if (empty($response)) {
            throw new MUCHException(config('const.ERROR.USER.ALREADY_REGISTERED'), 400);
        }
        // メール送信
        Mail::to($email)->send(new AuthCodeEmail($response['auth_code']));
        $request->session()->put('sigunup_user_id', $response['user_id']);
        return[];
    }

    /**
     * 会員認証
     *r
     * @param UserRequest $request
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function auth(UserRequest $request): array
    {
        // usersテーブル検索
        $userId = $request->session()->get('sigunup_user_id');
        $authCode = (new AuthCode($request->input('auth_code')))->get();
        $users = $this->checkAuthCode($userId, $authCode);
        // usersを本登録に更新
        $user = $this->usersRepository->selectuserById($userId);
        if (is_null($users) || is_null($user)) {
            // ユーザー情報が取得できない
            throw new MUCHException(config('const.ERROR.USER.NO_TEMP_REGISTERED'), 404);
        }
        $users = array_merge($users, $user->toArray());
        if ($users['email_confirm_flg'] === 1) {
            // 既に本登録が済んでいる
            throw new MUCHException(config('const.ERROR.USER.ALREADY_REGISTERED'), 400);
        }
        $users['email_confirm_flg'] = 1;
        $userEntity = $this->usersRepository->new($users);
        $this->usersRepository->updateuserConfirm($userEntity);
        // メール送信
        Mail::to($users['pc_email'])->send(new RegisteredEmail($userEntity));
        auth()->loginUsingId($userId);
        $request->session()->forget('sigunup_user_id');
        $this->saveSessionData($request, $user['uid']);

        // 正常終了
        return [];
    }

    /**
     * ログイン
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function login(UserRequest $request): array
    {
        // userをemailとpasswordで検索
        $email = (new Email($request->input('email')))->get();
        $password = (new Password($request->input('password'), $email))->get();
        $user = $this->usersRepository->getUser($email, $password);
        if (is_null($user)) {
            // 会員情報が存在しない ログイン失敗
            throw new MUCHException(config('const.ERROR.USER.LOGIN_FAILED'), 401);
        }
        $user = $user->toArray();
        if ($this->usersRepository->existsUsers($user['uid']) === false) {
            $users = array_merge(
                $user,
                ['user_id' => $user['uid']],
                ['auth_code' => null],

            );
            $userEntity = $this->usersRepository->new($users);
            $this->usersRepository->saveUsers($userEntity);
        }

        auth()->loginUsingId($user['uid']);
        $this->saveSessionData($request, $user['uid']);

        return [];
    }

    /**
     * ログアウト
     *
     * @return array
     */
    public function logout()
    {
        auth()->logout();
        return [];
    }

    /**
     * 会員情報変更 - email
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     */
    public function updateEmail(UserRequest $request): array
    {
        $userId = auth()->id();
        $email = (new Email($request->input('email')))->get();
        if ($this->containUppercase($email)) {
            throw new MUCHException(config('const.ERROR.USER.EMAIL_CONTAIN_UPPERCASE'), 400);
        }
        if ($this->usersRepository->existsEmail($email, $userId)) {
            throw new MUCHException(config('const.ERROR.USER.EXISTS_EMAIL'), 400);
        }
        $users = $this->getUsersById($userId);
        $users['auth_code'] = rand(100000, 999999);
        $now = new Carbon();
        $users = $this->usersRepository->new($users);
        $this->usersRepository->updateUsers($users);
        // メール送信
        Mail::to($email)->send(new UpdateAddressAuthCodeEmail($users->getAuthCode()));
        // セッションにメールアドレスを保持
        $request->session()->put('email', $email);
        return [];
    }

    /**
     * 会員情報変更 - email - 認証
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     */
    public function updateEmailAuth(UserRequest $request): array
    {
        $userId = auth()->id();
        $authCode = (new AuthCode($request->input('auth_code')))->get();
        $email = $request->input('email');
        $password = $request->input('password');
        $sessionEmail = $request->session()->get('email');
        // 前回入力して認証コード送信したメールアドレスとリクエストのメールアドレスが一致しなければException
        if ($email !== $sessionEmail) {
            throw new MUCHException(config('const.ERROR.USER.SESSION_EMAIL_NO_MATCH'), 400);
        }
        if ($this->usersRepository->existsEmail($sessionEmail, $userId)) {
            throw new MUCHException(config('const.ERROR.USER.EXISTS_EMAIL'), 400);
        }
        $user = $this->checkAuthCode($userId, $authCode);
        $users = $this->usersRepository->selectusersById($userId);
        if (is_null($user) || is_null($users)) {
            // ユーザーが取得できない
            throw new MUCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $users = $users->toArray();
        if (is_null($this->getEmail($users, $password))) {
            // パスワードが異なる
            throw new MUCHException(config('const.ERROR.USER.PASSWORD_DIFFERENT'), 401);
        }
        $users['email'] = $email;
        $users['password'] = $password;
        $users = $this->usersRepository->new($users);
        $this->usersRepository->updateEmail($users);
        // 新メールアドレスにメールアドレス変更しましたメール送信
        $sendEmail = $users->getEmail();
        Mail::to($sendEmail)->send(new UpdateAddressEmail($email));
        $request->session()->forget('email');
        return [
            'email' => $email
        ];
    }

    /**
     * 会員情報変更 - password
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     */
    public function updatePassword(UserRequest $request): array
    {
        $userId = auth()->id();
        $user = $this->usersRepository->selectUsersById($userId);
        $users = $this->usersRepository->selectusersById($userId);
        if (is_null($user) || is_null($users)) {
            // ユーザー情報を取得できない
            throw new MUCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $users = $users->toArray();
        $email = $users['email'];
        $passwordNew = $request->input('new_password');
        // 新パスワードと再入力パスワードが一致しない
        if ($passwordNew !== $request->input('new_password_again')) {
            throw new MUCHException(config('const.ERROR.USER.PASSWORD_NOT_MATCH'), 401);
        }
        // パスワード生成したメールアドレスでパスワード生成 (メールアドレス自体の更新はしない)
        $users['password'] = $passwordNew;
        $users = $this->usersRepository->new($users);
        $this->usersRepository->updatePassword($users);
        // メールアドレスにパスワード変更しましたメールを送信 パスワードは返却しない
        Mail::to($email)->send(new UpdatePasswordEmail($users));
        // パスワードは返却しない
        return [
            'message' => 'パスワードを更新しました'
        ];
    }

    /**
     * 会員情報変更 - name
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     */
    public function updateName(UserRequest $request): array
    {
        $userId = auth()->id();
        $users = $this->getUsersById($userId);
        $users['name'] = $request->input('name');
        $users = $this->usersRepository->new($users);
        $this->usersRepository->updateName($users);
        return [
            'name' => $users->getName()
        ];
    }

    /**
     * パスワード忘れました - メールアドレス入力
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     */
    public function forgetPasswordEmail(UserRequest $request)
    {
        $email = (new Email($request->input('email')))->get();
        $users = $this->usersRepository->getUserByMail($email);
        if (empty($users)) {
            throw new MUCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        $response = $this->registerUsers($users->toArray(), [
            'email' => $email,
            'password' => $users['password']
        ]);
        // メール送信
        Mail::to($email)->send(new ForgetPasswordAuthCodeEmail($response['auth_code']));
        $request->session()->put('forget_password_sigunup_user_id', $users['uid']);
        return [];
    }

    /**
     * パスワード忘れました - 認証コード入力
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     */
    public function forgetPasswordAuth(UserRequest $request)
    {
        $userId = $request->session()->get('forget_password_sigunup_user_id');
        $authCode = (new AuthCode($request->input('auth_code')))->get();
        $users = $this->checkAuthCode($userId, $authCode);
        if (is_null($users)) {
            throw new MUCHException(config('const.ERROR.USER.NO_USER'), 404);
        }
        return [];
    }

    /**
     * パスワード忘れました - パスワード更新
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     */
    public function forgetPasswordUpdate(UserRequest $request)
    {
        $userId = $request->session()->get('forget_password_sigunup_user_id');
        $password = $request->input('password');
        // 新パスワードと再入力パスワードが一致しない
        if ($password !== $request->input('password_again')) {
            throw new MUCHException(config('const.ERROR.USER.PASSWORD_NOT_MATCH'), 400);
        }
        $users = $this->getUsersById($userId);
        $email = $users['email'];
        // パスワード生成したメールアドレスでパスワード生成 (メールアドレス自体の更新はしない)
        $users['password'] = $password;
        $usersEntity = $this->usersRepository->new($users);
        $this->usersRepository->updatePassword($usersEntity);
        // メール送信
        Mail::to($email)->send(new ForgetPasswordEmail($usersEntity));
        $request->session()->forget('forget_password_sigunup_user_id');
        return [];
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
            $authCode = rand(100000, 999999);
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
        $authCode = rand(100000, 999999);
        $now = new Carbon();
        return [
            'auth_code' => $authCode,
            'user_id' => $userId,
            'uid' => $userId,
            'email' => $request['email'],
            'password' => $request['password'],
            'name' => $request['name'],
            'gender' => $request['gender'],
            'age' => $request['age'],
            'salary' => $request['salary'],
            'height' => $request['height'],
            'weight' => $request['weight'],
            'face_point' => $request['facePoint'],
            'face_image' => $request['faceImage'],
            'facebook_id' => $request['facebookId'],
            'instagram_id' => $request['instagramId'],
            'twitter_id' => $request['twitterId'],
            'created_at' => $now->format('Y-m-d\TH:i:s.u\Z'),
            'update_face_at' => $now->format('Y-m-d H:i:s.u'),
            'yellow_card' => $request['yellowCard'],
            'email_confirm_flg' => 0,
        ];
    }

    /**
     * 認証コードと期限をチェックして、認証成功ならusersモデルを返却する
     *
     * @param string $userId
     * @param int $authCode
     * @return array|null
     * @throws Exception
     */
    private function checkAuthCode(string $userId, int $authCode): ?array
    {
        $users = $this->usersRepository->selectUsersById($userId);
        if (is_null($users)) {
            return null;
        }
        $users = $users->toArray();
        // 認証コード一致チェック
        $now = new Carbon();
        if ($authCode !== $users['auth_code']) {
            // 認証コード不一致
            throw new MUCHException(config('const.ERROR.USER.AUTH_CODE_NO_MATCH'), 400);
        }
        return $users;
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
            throw new MUCHException(config('const.ERROR.USER.NO_USER'), 404, $error);
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
        return [
            'user_id' => $entityParam['user_id'],
            'auth_code' => $entityParam['auth_code']
        ];
    }

    /**
     * パスワードの生成に使用したメールアドレスを特定する
     *
     * @param array $users
     * @param string $password
     * @return string|null
     * @throws Exception
     */
    private function getEmail(array $users, string $password): ?string
    {
        $email = $users['email'];
        $hashPass = (new Password($password, $email))->get();
        if ($hashPass === $users['password']) {
            return $email;
        }
        return null;
    }

    /**
     * face_pointを更新
     *
     * @param string $upOrDown
     * @param string $userId
     * @return void
     * @throws Exception
     */
    private function updateFacePint(string $upOrDown, string $userId): void
    {
        if ($upOrDown === 'up') {
            $this->usersRepository->upFacePoint($userId);
        }
        if ($upOrDown === 'down') {
            $this->usersRepository->downFacePoint($userId);
        }
    }

//    /**
//     * face_pointを更新
//     *
//     * @param string $upOrDown
//     * @param string $userId
//     * @return void
//     * @throws Exception
//     */
//    private function updateAndCheckYellowCard(string $userId): void
//    {
//        $this->usersRepository->upYellowCard($userId);
//        $yellowCard = $this->usersRepository->getYellowCard($userId);
//        if ($yellowCard > 2) {
//
//        }
//    }

    /**
     * genderをsessionに追加
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function gender(Request $request): array
    {
        $gender = $request->gender;
        $request->session()->put('gender', $gender);
        return [];
    }

    /**
     * heightをsessionに追加
     *
     * @param UserRequest $request
     * @return array
     * @throws Exception
     */
    public function height(Request $request): array
    {
        $height = $request->height;
        Log::debug($height);
        $request->session()->put('height', $height);
        return [];
    }

    /**
     * weightをsessionに追加
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function weight(Request $request): array
    {
        $weight= $request->weight;
        Log::debug($weight);
        $request->session()->put('weight', $weight);
        return [];
    }

    /**
     * ageをsessionに追加
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function age(Request $request): array
    {
        $gender = $request->session()->get('gender');
        Log::debug($gender);
        $age = $request->age;
        Log::debug($age);
        $request->session()->put('age', $age);
        return [];
    }

    /**
     * salaryをsessionに追加
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function salary(Request $request): array
    {
        $salary = $request->salary;
        Log::debug($salary);
        $request->session()->put('salary', $salary);
        return [];
    }

    /**
     * face_pointをsessionに追加
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function facePoint(Request $request): array
    {
        $facePoint = $request->facePoint;
        Log::debug($facePoint);
        $request->session()->put('face_point', $facePoint);
        return [];
    }

    /**
     * ランダムに30名取得。
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function getFaceList(Request $request): array
    {
        $gender = $request->session()->get('gender');
        Log::debug($gender);
        $order = $this->decideOrderProcess();
        $num = 30;
        $faceList = $this->usersRepository->getFaceAndFacePoint($gender, $num, $order);
        array_multisort(array_column($faceList, 'face_point'), SORT_ASC, $faceList);
        return $faceList;
    }

    /**
     * order方法をランダムに決定。
     *
     * @return string
     * @throws Exception
     */
    public function decideOrderProcess(): string
    {
        $randomNumber = rand(1,2);
        switch ($randomNumber) {
            case 1:
                return 'desc';
            default:
                return 'asc';
        }
    }

}
