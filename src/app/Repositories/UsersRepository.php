<?php

namespace App\Repositories;

use App\Entities\UserEntity;
use App\Exceptions\DOGException;
use App\Factories\UsersFactory;
use App\Models\Reaction;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UsersRepository implements UsersRepositoryInterface
{
    /**
     * Entityを生成する
     *
     * @param array $user
     * @return UserEntity
     * @throws DOGException
     */
    public function new(array $user): UserEntity
    {
        return (new UsersFactory)->make(
            $user['user_id'],
            $user['name'],
            $user['email'],
            $user['password'],
            $user['sex'],
            $user['weight'],
            $user['dog_point'],
            $user['dog_image1'],
            $user['dog_image2'],
            $user['dog_image3'],
            $user['breed1'],
            $user['breed2'],
            $user['instagram_id'],
            $user['twitter_id'],
            $user['tiktok_id'],
            $user['blog_id'],
            $user['birthday'],
            $user['location'],
            $user['comment'],
            $user['yellow_card'],
            $user['update_dog_at'],
            $user['create_date'],
            $user['dog_image_void_flg']
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
     * ログイン情報からadminsテーブル情報を取得する
     *
     * @param string $email
     * @return object|null
     */
    public function getAdminUser(string $email): ?object
    {
        return DB::table('admins')
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
            'sex' => $user->getSex(),
            'weight' => $user->getWeight(),
            'dog_point' => $user->getDogPoint(),
            'dog_image1' => $user->getDogImage1(),
            'dog_image2' => $user->getDogImage2(),
            'dog_image3' => $user->getDogImage3(),
            'breed1' => $user->getBreed1(),
            'breed2' => $user->getBreed2(),
            'instagram_id' => $user->getInstagramId(),
            'twitter_id' => $user->getTwitterId(),
            'tiktok_id' => $user->getTiktokId(),
            'blog_id' => $user->getBlogId(),
            'location' => $user->getLocation(),
            'birthday' => $user->getLocation(),
            'comment' => $user->getComment(),
            'yellow_card' => $user->getYellowCard(),
            'update_dog_at' => $user->getUpdateDogAt(),
            'created_date' => $user->getCreateDate()
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
            'sex' => $user->getSex(),
            'weight' => $user->getWeight(),
            'dog_point' => $user->getDogPoint(),
            'dog_image1' => $user->getDogImage1(),
            'dog_image2' => $user->getDogImage2(),
            'dog_image3' => $user->getDogImage3(),
            'breed1' => $user->getBreed1(),
            'breed2' => $user->getBreed2(),
            'instagram_id' => $user->getInstagramId(),
            'twitter_id' => $user->getTwitterId(),
            'tiktok_id' => $user->getTiktokId(),
            'blog_id' => $user->getBlogId(),
            'location' => $user->getLocation(),
            'birthday' => $user->getBirthday(),
            'dog_image_void_flg' => $user->getDogImageVoidFlg(),
            'comment' => $user->getComment(),
            'yellow_card' => $user->getYellowCard(),
            'update_dog_at' => $user->getUpdateDogAt(),
            'created_date' => $user->getCreateDate()
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
                'sex' => $user->getSex(),
                'weight' => $user->getWeight(),
                'dog_point' => $user->getDogPoint(),
                'dog_image1' => $user->getDogImage1(),
                'dog_image2' => $user->getDogImage2(),
                'dog_image3' => $user->getDogImage3(),
                'breed1' => $user->getBreed1(),
                'breed2' => $user->getBreed2(),
                'instagram_id' => $user->getInstagramId(),
                'twitter_id' => $user->getTwitterId(),
                'tiktok_id' => $user->getTiktokId(),
                'blog_id' => $user->getBlogId(),
                'location' => $user->getLocation(),
                'birthday' => $user->getBirthday(),
                'comment' => $user->getComment(),
                'yellow_card' => $user->getYellowCard(),
                'update_dog_at' => $user->getUpdateDogAt(),
                'created_date' => $user->getCreateDate()
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
     * usersのbreedを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateBreed(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'breed1' => $user->getBreed1(),
                'breed2' => $user->getBreed2()
            ]);
    }

     /**
     * usersのbirthdayを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateBirthday(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'birthday' => $user->getBirthday()
            ]);
    }

    /**
     * usersのlocationを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateLocation(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'location' => $user->getLocation()
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
     * usersのtiktok_idを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateTiktok(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'tiktok_id' => $user->getTiktokId()
            ]);
    }

    /**
     * usersのtiktok_idを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateBlog(UserEntity $user): bool
    {
        return (new User)
            ->where('user_id', $user->getUserId())
            ->update([
                'blog_id' => $user->getBlogId()
            ]);
    }

    /**
     * face_image,update_face_at,face_image_void_flgを更新する
     *
     * @param stirng $userId
     * @param string $dogImage
     * @param string $column
     * @param int $num
     * @return bool
     */
    public function updateImage($userId, $dogImage=null, $column, $num=1): bool
    {
        $now = new Carbon();
        return (new User())
            ->where('user_id', $userId)
            ->update([
                $column => $dogImage,
                'update_dog_at' => $now->format('Y-m-d H:i:s'),
                'dog_image_void_flg' => $num
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
     * dog_pointを引数にランダムなユーザーを取得
     *
     * @param int $num
     * @return Collection
     */
    public function getTwoUsersByDogPoint(int $num): Collection
    {
        return (new User)
            ->where('dog_image_void_flg', 0)
            ->orderBy('dog_point')
            ->skip($num)
            ->limit(2)
            ->get();
    }

    /**
     * user数を取得
     *
     * @return int
     */
    public function getDogCnt(): int
    {
        $cnt = DB::table('users')
            ->where('dog_image_void_flg', 0)
            ->count();

        return json_decode(json_encode($cnt), true);
    }

    /**
     * dog_pointを1上げる
     *
     * @param string $userId
     * @return void
     */
    public function upDogPoint(string $userId): void
    {
        DB::table('users')
            ->where('user_id', $userId)
            ->increment('dog_point');
    }

    /**
     * dog_pointを1下げる
     *
     * @param string $userId
     * @return void
     */
    public function downDogPoint(string $userId): void
    {
        DB::table('users')
            ->where('user_id', $userId)
            ->decrement('dog_point');
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
     * yellow_cardを任意の数に更新
     *
     * @param string $userId
     * @param int $num
     * @return bool
     */
    public function updateYellowCard(string $userId, int $num): bool
    {
       return DB::table('users')
            ->where('user_id', $userId)
            ->update(['yellow_card' => $num]);
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
     * userIdを引数にupdate_dog_atを取得
     *
     * @param string $userId
     * @return User
     */
    public function getUpdateDogAt(string $userId): User
    {
        return (new User)
            ->where('user_id', $userId)
            ->select('update_dog_at')
            ->first();
    }

    /**
     * userIdを引数にdog_image_void_flgを取得
     *
     * @param string $userId
     * @return User
     */
    public function getDogImageVoidFlg(string $userId): User
    {
        return (new User)
            ->where('user_id', $userId)
            ->select('dog_image_void_flg')
            ->first();
    }

    /**
     * dog_image_void_flgをupdateする
     *
     * @param string $userId
     * @param int $num
     * @return void
     */
    public function updateDogImageVoidFlg(string $userId, int $num): void
    {
        DB::table('users')
            ->where('user_id', $userId)
            ->update(['dog_image_void_flg' => $num]);
    }

    /**
     * diagnosis結果を取得
     *
     * @param int $minWeight
     * @param int $maxWeight
     * @param string $face
     * @param int $personality1
     * @param int $personality2
     * @param int $personality3
     * @param string $holiday
     * @return object
     */
    public function getDiagnosisResult(int $minWeight, int $maxWeight, string $face, int $personality1, int $personality2, int $personality3, string $holiday): object
    {
        $result = DB::table('breeds')
            ->where(function ($query) use ($minWeight) {
                $query->where('min_weight', '>', $minWeight)
                      ->orWhereNull('min_weight');
            })
            ->where(function ($query) use ($maxWeight) {
                $query->where('max_weight', '<', $maxWeight)
                      ->orWhereNull('max_weight');
            })
            ->where('face', $face)
            ->orderByRaw("abs(? - personality1) + abs(? - personality2) + abs(? - personality3)", [$personality1, $personality2, $personality3])
            ->limit(1)
            ->get();

        return $result;
    }

    /**
     * diagnosis結果を取得
     *
     * @param string $face
     * @param int $personality1
     * @param int $personality2
     * @param int $personality3
     * @param string $holiday
     * @return object
     */
    public function getDiagnosisResultAgain(string $face, int $personality1, int $personality2, int $personality3, string $holiday): object
    {
        $result = DB::table('breeds')
            ->where('face', $face)
            ->orderByRaw("abs(? - personality1) + abs(? - personality2) + abs(? - personality3)", [$personality1, $personality2, $personality3])
            ->limit(1)
            ->get();

        return $result;
    }

    /**
     * ユーザーを削除
     *
     * @param $userId
     * @return bool
     */
    public function deleteUser(string $userId): bool
    {
        return User::destroy($userId);
    }

    /**
     * 不正な画像のユーザーを取得
     *
     * @return object
     */
    public function getVoidUsers(): object
    {
        return (new User)
            ->where('dog_image_void_flg', 1)
            ->get();
    }

    /**
     * 画像レベル上位三匹を取得
     *
     * @return object
     */
    public function getRanking(): object
    {
        $dt = new Carbon();
        $date = $dt->subDay(1);
        return (new User)
            ->where('dog_image_void_flg', 0)
            ->where('update_dog_at', '<', $date)
            ->orderBy('dog_point', 'desc')
            ->orderBy('update_dog_at')
            ->limit(11)
            ->get();
    }

    /**
     * 全てのユーザー取得
     *
     * @param ?int $offset
     * @return Collection
     */
    public function getUsersAll(?int $offset = null): Collection
    {
        return (new User)
            ->where('dog_image_void_flg', 0)
            ->offset($offset)
            ->limit(20)
            ->get();
    }

    /**
     * ランダムに4ユーザー取得
     *
     * @return Collection
     */
    public function getUserRandom(): Collection
    {
        return User::inRandomOrder()
            ->where('dog_iamge_void_flg', 0)
            ->limit(4)
            ->get();
    }

    /**
     * フレンド情報を加えてユーザー取得
     *
     * @param $userId
     * @param ?int $offset
     * @return object
     */
    public function getUsersAllWithFriends($userId, ?int $offset = null): object
    {
        return DB::table('users')
            ->leftJoin('reactions as m1', function ($join) use ($userId) {
                $join->on('users.user_id', '=', 'm1.to_user_id')
                    ->where('m1.from_user_id', $userId);
            })
            ->leftJoin('reactions as m2', function ($join) use ($userId) {
                $join->on('users.user_id', '=', 'm2.from_user_id')
                    ->where('m2.to_user_id', $userId);
            })
            ->select('users.*', 'm1.to_user_id', 'm2.from_user_id', DB::raw('IF(m1.from_user_id IS NOT NULL AND m2.to_user_id IS NOT NULL, 1, 0) as is_matched'))
            ->where('dog_image_void_flg', 0)
            ->offset($offset)
            ->limit(20)
            ->get();
    }

    /**
     * フレンド取得
     *
     * @param $userId
     * @return object
     */
    public function getFriends($userId): object
    {
        return DB::table('users')
        ->Join('reactions as m1', 'users.user_id', '=', 'm1.to_user_id')
        ->Join('reactions as m2', 'users.user_id', '=', 'm2.from_user_id')
        ->where('m1.from_user_id', $userId)
        ->where('m2.to_user_id', $userId)
        ->select('users.*', 'm1.to_user_id', 'm2.from_user_id', DB::raw('IF(m1.from_user_id IS NOT NULL AND m2.to_user_id IS NOT NULL, 1, 0) as is_matched'))
        ->where('dog_image_void_flg', 0)
        ->get();
    }

    /**
     * いいねされているユーザーを取得
     *
     * @param $userId
     * @return object
     */
    public function getGiven($userId): object
    {
        return DB::table('users')
            ->leftJoin('reactions as m1', function ($join) use ($userId) {
                $join->on('users.user_id', '=', 'm1.to_user_id')
                    ->where('m1.from_user_id', $userId);
            })
            ->leftJoin('reactions as m2', function ($join) use ($userId) {
                $join->on('users.user_id', '=', 'm2.from_user_id')
                    ->where('m2.to_user_id', $userId);
            })
            ->whereNull('m1.from_user_id')
            ->whereNotNull('m2.to_user_id')
            ->where('dog_image_void_flg', 0)
            ->select('*')
            ->get();
    }

    /**
     * 特定のユーザーの情報を取得
     *
     * @param $toUserId
     * @param $fromUserId
     * @return object
     */
    public function getUserInfo($toUserId, $fromUserId): object
    {
        return DB::table('users')
            ->leftJoin('reactions as m1', function ($join) use ($fromUserId) {
                $join->on('users.user_id', '=', 'm1.to_user_id')
                    ->where('m1.from_user_id', $fromUserId);
            })
            ->leftJoin('reactions as m2', function ($join) use ($fromUserId) {
                $join->on('users.user_id', '=', 'm2.from_user_id')
                    ->where('m2.to_user_id', $fromUserId);
            })
            ->select('users.*', 'm1.to_user_id', 'm2.from_user_id', DB::raw('IF(m1.from_user_id IS NOT NULL AND m2.to_user_id IS NOT NULL, 1, 0) as is_matched'))
            ->where('users.user_id', '=', $toUserId)
            ->where('dog_image_void_flg', 0)
            ->first();
    }
}



