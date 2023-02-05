<?php

namespace App\Repositories;

use App\Entities\UserEntity;
use App\Exceptions\MATCHException;
use App\Factories\UsersFactory;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Log;

class UsersRepository implements UsersRepositoryInterface
{
    /**
     * Entityを生成する
     *
     * @param array $user
     * @return UserEntity
     * @throws MATCHException
     */
    public function new(array $user): UserEntity
    {
        return (new UsersFactory)->make(
            $user['user_id'],
            $user['name'],
            $user['email'],
            $user['password'],
            $user['gender'],
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
            $user['face_image_void_flg'],
            $user['order_number']
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
     * @return User|null
     */
    public function getUser(string $email): ?User
    {
        return (new User)
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
            'user_id' => $user->getUserId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'gender' => $user->getGender(),
            'height' => $user->getHeight(),
            'weight' => $user->getWeight(),
            'age' => $user->getAge(),
            'salary' => $user->getSalary(),
            'face_point' => $user->getFacePoint(),
            'height2' => $user->getHeight2(),
            'weight2' => $user->getWeight2(),
            'age2' => $user->getAge2(),
            'salary2' => $user->getSalary2(),
            'face_point2' => $user->getFacePoint2(),
            'face_image' => $user->getFaceImage(),
            'facebook_id' => $user->getFacebookId(),
            'instagram_id' => $user->getInstagramId(),
            'twitter_id' => $user->getUserId(),
            'yellow_card' => $user->getYellowCard(),
            'update_face_at' => $user->getUpdateFaceAt(),
            'created_date' => $user->getCreateDate(),
            'order_number' => $user->getOrderNumber()
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
        DB::connection('mysql')->beginTransaction();
        $isSaveUsers = (new User([
            'user_id' => $user->getUserId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'gender' => $user->getGender(),
            'height' => $user->getHeight(),
            'weight' => $user->getWeight(),
            'age' => $user->getAge(),
            'salary' => $user->getSalary(),
            'face_point' => $user->getFacePoint(),
            'height2' => $user->getHeight2(),
            'weight2' => $user->getWeight2(),
            'age2' => $user->getAge2(),
            'salary2' => $user->getSalary2(),
            'face_point2' => $user->getFacePoint2(),
            'face_image' => $user->getFaceImage(),
            'facebook_id' => $user->getFacebookId(),
            'instagram_id' => $user->getInstagramId(),
            'twitter_id' => $user->getUserId(),
            'yellow_card' => $user->getYellowCard(),
            'created_date' => $user->getCreateDate(),
            'update_face_at' => $user->getUpdateFaceAt(),
            'order_number' => $user->getOrderNumber()
        ]))->save();
        if ($isSaveUsers) {
            DB::commit();
            DB::connection('mysql')->commit();
            return true;
        }
        DB::rollBack();
        DB::connection('mysql')->rollBack();
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
                'user_id' => $user->getUserId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'gender' => $user->getGender(),
                'height' => $user->getHeight(),
                'weight' => $user->getWeight(),
                'age' => $user->getAge(),
                'salary' => $user->getSalary(),
                'face_point' => $user->getFacePoint(),
                'height2' => $user->getHeight2(),
                'weight2' => $user->getWeight2(),
                'age2' => $user->getAge2(),
                'salary2' => $user->getSalary2(),
                'face_point2' => $user->getFacePoint2(),
                'face_image' => $user->getFaceImage(),
                'facebook_id' => $user->getFacebookId(),
                'instagram_id' => $user->getInstagramId(),
                'twitter_id' => $user->getUserId(),
                'yellow_card' => $user->getYellowCard(),
                'update_face_at' => $user->getUpdateFaceAt(),
                'created_date' => $user->getCreateDate(),
                'order_number' => $user->getOrderNumber()
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
     * email, password一致するusersテーブル情報の有無を確認する
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function existsUsersByPass(string $email, string $password): bool
    {
        return (new User)
            ->where('email', $email)
            ->where('password', $password)
            ->exists();
    }

    /**
     * 引数のメールアドレスが自身以外に存在するか確認する
     *
     * @param string $email
     * @return bool
     */
    public function existsEmail(string $email): bool
    {
        return (new User)
            ->where('email', $email)
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
     * usersテーブルを複数のuidで検索し、退会していないユーザーのメールアドレスを取得する
     *
     * @param array $userIds
     * @return Collection|null
     */
    public function getUsersByIds(array $userIds): ?Collection
    {
        return (new User)
            ->whereIn('user_id', $userIds)
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
     * usersのheightを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateHeight(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'height' => $user->getHeight()
            ]);
    }

    /**
     * usersのweightを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateWeight(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'weight' => $user->getWeight()
            ]);
    }

    /**
     * usersのageを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateAge(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'age' => $user->getAge()
            ]);
    }

    /**
     * usersのsalaryを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateSalary(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'salary' => $user->getSalary()
            ]);
    }

    /**
     * usersのfacebook_idを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateFacebook(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'facebook_id' => $user->getFacebookId()
            ]);
    }

    /**
     * usersのinstagram_idを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateInstagram(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'instagram_id' => $user->getInstagramId()
            ]);
    }

    /**
     * usersのtwitter_idを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateTwitter(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'twitter_id' => $user->getTwitterId()
            ]);
    }

    /**
     * face_imageとupdate_face_atを更新する
     *
     * @param stirng $userId
     * @return bool
     */
    public function updateFace($userId, $faceImage): bool
    {
        $now = new Carbon();
        return (new User())
            ->where('user_id', $userId)
            ->update([
                'face_image' => $faceImage,
                'update_face_at' => $now->format('Y-m-d H:i:s.u'),
            ]);
    }

    /**
     * 引数のemailが一致するusersテーブル情報を取得する
     *
     * @param string $email
     * @return User
     */
    public function getUserByMail(string $email): ?User
    {
        return (new User)
            ->where('email', $email)
            ->first();
    }

    /**
     * face_pointを引数にランダムなユーザーを取得
     *
     * @param int $facePoint
     * @param string $gender
     * @return Collection
     */
    public function getTwoUsersByFacePoint(int $facePoint, string $gender): Collection
    {
        return (new User)
            ->where('gender', $gender)
            ->where('face_point', '>=', $facePoint)
            ->orderBy('face_point')
            ->limit(2)
            ->get();
    }

    /**
     * face_pointの最大値を取得
     *
     * @param int $facePoint
     * @param string $gender
     * @return array
     */
    public function getMaxFacePoint(string $gender): array
    {
        $facePoint = DB::table('users')
            ->where('gender', $gender)
            ->orderBy('face_point', 'desc')
            ->first();

        return json_decode(json_encode($facePoint), true);
    }

    /**
     * face_pointを1上げる
     *
     * @param string $userId
     * @return void
     */
    public function upFacePoint(string $userId): void
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
    public function downFacePoint(string $userId): void
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
    public function upYellowCard(string $userId): void
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
     * userIdを引数にupdate_face_atを取得
     *
     * @param string $userId
     * @return User
     */
    public function getUpdateFaceAt(string $userId): User
    {
        return (new User)
            ->where('user_id', $userId)
            ->select('update_face_at')
            ->first();
    }

    /**
     * userIdを引数にface_image_void_flgを取得
     *
     * @param string $userId
     * @return User
     */
    public function getFaceImageVoidFlg(string $userId): User
    {
        return (new User)
            ->where('user_id', $userId)
            ->select('face_image_void_flg')
            ->first();
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
            ->update(['face_image_void_flg', $num]);
    }

    /**
     * 引数の数値分のface_imageとface_pointを取得
     *
     * @param string $gender
     * @param string $sort
     * @param int $num
     * @return Collection
     */
    public function getFace(string $gender, string $sort, int $num): Collection
    {
        $dt = new Carbon();
        $date = $dt->subDay(30);
        return (new User)
            ->where('gender', $gender)
            ->where('update_face_at', '<', $date)
            ->select('face_image', 'face_point')
            ->orderBy('order_number', $sort)
            ->limit($num)
            ->get();
    }

    /**
     * match結果を取得
     *
     * @param aray $matchInfo
     * @param string $place
     * @return object
     */
    public function getMatchResult($matchInfo, $place): object
    {

        if ($matchInfo['genderSort'] === 'male') {
            //requestユーザーはfemale
            if ($place === 'workplace') {
                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(4 * ?+ 2 * ?- ?+ ?- ?) > (3.5 * face_point2 + 3 * salary2 - 1.5 * age2 + 2 * height2 - weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'introduction') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(3.5 * ?+ 2 * ?- ?+ ?- ?) > (3 * face_point2 + 2 * salary2 - 1.5 * age2 + 2 * height2 - weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'jointparty') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(4 * ?+ 2 * ?- ?+ ?- ?) > (3.5 * face_point2 + 3 * salary2 - 1.5 * age2 + 2 * height2 - weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'club') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(8 * ?- 2 * ?+ ?- ?) > (6 * face_point2 + 2 * salary2 - 2 * age2 + 4 * height2 -2 * weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'pairs') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(6.5 * ?+ 4 * ?- 3 * ?+ 3 * ?- ?) > (8 * face_point2 + salary2 - 4 * age2 + 2 * height2 - 4 * weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'tinder') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(9 * ?+ ?- 2 * ?+ 2 * ?- 2 * ?) > (7 * face_point2 + salary2 - 2 * age2 + 2 * height2 - weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(4 * ?+ 2 * ?- ?+ ?- ?) > (3.5 * face_point2 + 3 * salary2 - 1.5 * age2 + 2 * height2 - weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            }

        } else {
            //requestユーザーはmale
            if ($place === 'workplace') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(3.5 * ? + 3 * ? - 1.5 * ? + 2 * ? - ?) > (4 * face_point2 + 2 * salary2 - age2 + 2 * height2 - weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'introduction') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(3 * ?+ 2 * ?- 1.5 * ?+ 2 * ?- ?) > (3.5 * face_point2 + 2 * salary2 - age2 + height2 - weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'jointparty') {
                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(6.5 * ?+ 1.5 * ?- 4 * ?+ 3 * ?- 2 * ?) > (7 * face_point2 + salary2 - 2 * age2 + 2 * height2 - 2 * weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'club') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(6 * ?+ 2 * ?- 2 * ?+ 4 * ?- 2 * ?) > (8 * face_point2 - 2 * age2 + height2 - weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'pairs') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(7 * ?+ ?- 2 * ?+ 2 * ?- ?) > (9 * face_point2 + salary2 - 2 * age2 + 2 * height2 - 2 * weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else if ($place === 'tinder') {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(7 * ?+ ?- 2 * ?+ 2 * ?- ?) > (9 * face_point2 + salary2 - 2 * age2 + 2 * height2 - 2 * weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            } else {

                $result = DB::table('users')
                ->where('gender', $matchInfo['genderSort'])
                ->whereRaw("(3.5 * ?+ 3 * ?- 1.5 * ?+ 2 * ?- ?) > (4 * face_point2 + 2 * salary2 - age2 + 2 * height2 - weight2)", [$matchInfo['facePoint2'], $matchInfo['salary2'], $matchInfo['age2'], $matchInfo['height2'], $matchInfo['weight2']])
                ->orderBy('face_point', 'desc')
                ->limit(10)
                ->get();

            }
        }

        return $result;
    }
}
