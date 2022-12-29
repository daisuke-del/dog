<?php

namespace App\Repositories;

use App\Entities\UserEntity;
use App\Exceptions\MUCHException;
use App\Factories\UsersFactory;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\UsersRepositoryInterface;

class UsersRepository implements UsersRepositoryInterface
{
    /**
     * Entityを生成する
     *
     * @param array $user
     * @return UserEntity
     * @throws MUCHException
     */
    public function new(array $user): UserEntity
    {
        return (new User())->make(
            $user['user_id'],
            $user['gender'],
            $user['name'],
            $user['email'],
            $user['password'],
            $user['height'],
            $user['weight'],
            $user['age'],
            $user['salary'],
            $user['face_point'],
            $user['height2'],
            $user['weight2'],
            $user['age2'],
            $user['salary2'],
            $user['face_point2'],
            $user['face_image'],
            $user['facebook_id'],
            $user['instagram_id'],
            $user['twitter_id'],
            $user['yellow_card'],
            $user['update_face_at'],
            $user['create_date'],
        );
    }

    /**
     * Usersテーブルの全レコードを取得する
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return (new User)->all();
    }

    /**
     * ログイン情報からusersテーブル情報を取得する
     *
     * @param string $email
     * @param string $password
     * @return User
     */
    public function getUser(string $email, string $password): User
    {
        return (new User)
            ->where('email_confirm_flg', 1)
            ->where('password', $password)
            ->where('email', $email)
            ->first();
    }

    /**
     * usersテーブルにレコードを挿入する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function saveUsers(UserEntity $user): bool
    {
        return (new User([
            'age' => $user->getAge(),
            'auth_code' => $user->getAuthCode(),
            'created_date' => $user->getCreateDate(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'user_id' => $user->getUserId(),
            'facebook_id' => $user->getFacebookId(),
            'instagram_id' => $user->getInstagramId(),
            'twitter_id' => $user->getUserId(),
            'face_point' => $user->getFacePoint(),
            'face_image' => $user->getFaceImage(),
            'gender' => $user->getGender(),
            'height' => $user->getHeight(),
            'salary' => $user->getSalary(),
            'weight' => $user->getWeight(),
            'yellow_card' => $user->getYellowCard(),
            'update_face_at' => $user->getUpdateFaceAt(),
            'name' => $user->getName()
        ]))->save();
    }

    /**
     * usersテーブルにユーザー情報を登録する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function save(UserEntity $user): bool
    {
        DB::beginTransaction();
        DB::connection('users')->beginTransaction();
        $isSaveUsers = (new User([
            'age' => $user->getAge(),
            'auth_code' => $user->getAuthCode(),
            'created_date' => $user->getCreateDate(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'user_id' => $user->getUserId(),
            'facebook_id' => $user->getFacebookId(),
            'instagram_id' => $user->getInstagramId(),
            'twitter_id' => $user->getUserId(),
            'face_point' => $user->getFacePoint(),
            'face_image' => $user->getFaceImage(),
            'gender' => $user->getGender(),
            'height' => $user->getHeight(),
            'salary' => $user->getSalary(),
            'weight' => $user->getWeight(),
            'yellow_card' => $user->getYellowCard(),
            'update_face_at' => $user->getUpdateFaceAt(),
            'name' => $user->getName(),
        ]))->save();
        if ($isSaveUsers) {
            DB::commit();
            DB::connection('users')->commit();
            return true;
        }
        DB::rollBack();
        DB::connection('users')->rollBack();
        return false;
    }

    /**
     * usersテーブルのレコードを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateUsers(UserEntity $user): bool
    {
        return (new User())
            ->where('user_id', $user->getUserId())
            ->update([
                'age' => $user->getAge(),
                'auth_code' => $user->getAuthCode(),
                'created_date' => $user->getCreateDate(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'user_id' => $user->getUserId(),
                'facebook_id' => $user->getFacebookId(),
                'instagram_id' => $user->getInstagramId(),
                'twitter_id' => $user->getUserId(),
                'face_point' => $user->getFacePoint(),
                'face_image' => $user->getFaceImage(),
                'gender' => $user->getGender(),
                'height' => $user->getHeight(),
                'salary' => $user->getSalary(),
                'weight' => $user->getWeight(),
                'yellow_card' => $user->getYellowCard(),
                'update_face_at' => $user->getUpdateFaceAt(),
                'name' => $user->getName(),
            ]);
    }

    /**
     * 引数のuser_idがtableのuser_idに一致するusersテーブル情報の有無を確認する
     *
     * @param string $userId
     * @return bool
     */
    public function existsUsers(string $userId): bool
    {
        return (new User)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * 引数のuidがuser_idに一致するusersテーブル情報の有無を確認する
     *
     * @param string $uid
     * @return bool
     */
    public function existsUid(string $uid): bool
    {
        return (new User)
            ->where('user_id', $uid)
            ->exists();
    }

    /**
     * 引数のメールアドレスが自身以外に存在するか確認する
     *
     * @param string $email
     * @param string $userId
     * @return bool
     */
    public function existsEmail(string $email, string $userId): bool
    {
        return (new User)
            ->where(function ($query) use ($email) {
                $query->where('pc_email', $email)
                    ->orWhere('mobile_email', $email);
            })
            ->where('uid', '<>', $userId)
            ->exists();
    }

    /**
     * UserIDでusersテーブルのレコードを取得する
     *
     * @param string $userId
     * @return User
     */
    public function selectUsersById(string $userId): User
    {
        return (new User)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * userIdでusersテーブルのレコードを取得する
     *
     * @param string $userId
     * @return User
     */
    public function selectUserById(string $userId): User
    {
        return (new User)
            ->where('uid', $userId)
            ->first();
    }

    /**
     * usersテーブルを複数のuidで検索し、退会していないユーザーのメールアドレスを取得する
     *
     * @param array $userIds
     * @return Collection
     */
    public function getEmailByIds(array $userIds): Collection
    {
        return (new User)
            ->whereIn('uid', $userIds)
            ->select('email')
            ->get();
    }

    /**
     * usersのemailを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateEmail(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]);
    }

    /**
     * usersのpasswordを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updatePassword(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'password' => $user->getPassword()
            ]);
    }

    /**
     * usersのnameを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateName(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'name' => $user->getName()
            ]);
    }

    /**
     * 引数のemailが一致するusersテーブル情報を取得する
     *
     * @param string $email
     * @return array
     */
    public function getUserByMail(string $email): array
    {
        return (new User)
            ->where('email', '=', $email)
            ->get();
    }

    /**
     * face_pointを引数にランダムなユーザーを取得
     *
     * @param int $facePoint
     * @param string $gender
     * @return User
     */
    public function getTwoUsersByFacePoint(int $facePoint, string $gender): User
    {
        return (new User)
            ->where('gender', $gender)
            ->where('face_point', $facePoint)
            ->orderBy('face_point', 'desc')
            ->limit(2)
            ->get();
    }

    /**
     * face_pointを1上げる
     *
     * @param string $userId
     * @return void
     */
    public function upFacePoint(string $userId)
    {
        DB::table('users')
            ->where('user_id', $userId)
            ->increment('face_point');
    }

    /**
     * face_pointを1下げる
     *
     * @param string $userId
     * @return void
     */
    public function downFacePoint(string $userId)
    {
        DB::table('users')
            ->where('user_id', $userId)
            ->decrement('face_point');
    }

    /**
     * yellow_cardを1増加
     *
     * @param string $userId
     * @return void
     */
    public function upYellowCard(string $userId)
    {
        DB::table('users')
            ->where('user_id', $userId)
            ->decrement('yellow_card');
    }

    /**
     * yellow_cardを取得
     *
     * @param string $userId
     * @return User
     */
    public function getYellowCard(string $userId): User
    {
        return (new User)
            ->where('user_id', $userId)
            ->select('yellow_card')
            ->first();
    }

    /**
     * face_imageをupdate
     *
     * @param string $userId
     * @param string $faceImage
     */
    public function updateFaceImage(string $userId, string $faceImage = 'public/default_face.jpeg')
    {

    }

    /**
     * userIdを引数にupdate_face_atを取得
     *
     * @param string $userId
     * @return string
     */
    public function getUpdateFaceAt(string $userId): string
    {
        return (new User)
            ->where('user_id', $userId)
            ->select('update_face_at')
            ->get();
    }

    /**
     * userIdを引数にface_image_void_flgを取得
     *
     * @param string $userId
     * @return array
     */
    public function getFaceImageVoidFlg(string $userId): array
    {
        return (new User)
            ->where('user_id', $userId)
            ->select('face_image_void_flg')
            ->get();
    }

    /**
     * face_image_void_flgをupdateする
     *
     * @param string $userId
     * @param int $num
     * @return void
     */
    public function updateFaceImageVoidFlg(string $userId, int $num): void
    {
        DB::table('users')
            ->where('user_id', $userId)
            ->update('face_image_void_flg', $num);
    }

    /**
     * 任意の数のユーザーを取得する。
     *
     * @param string $gender
     * @param int $num
     * @param string $order
     * @return array
     */
    public function getFaceAndFacePoint(string $gender, int $num, string $order): array
    {
        $dt = new Carbon();
        $date = $dt->subDay(30);
        $users = DB::table('users')
            ->where('gender', '=', $gender)
            ->where('update_face_at', '<', $date)
            ->where('face_image_void_flg', '=', 0)
            ->select('face_image', 'face_point')
            ->orderByRaw('order_number ' . $order)
            ->limit($num)
            ->get();

        return $users->toArray();
    }

//    /**
//     * user_confirm_flgをupdateする
//     *
//     * @param string $userId
//     * @return void
//     */
//    public function updateUserConfirm(string|UserEntity $userId): void
//    {
//        DB::table('users')
//            ->where('user_id', $userId)
//            ->update('face_image_void_flg' = );
//    }
}
