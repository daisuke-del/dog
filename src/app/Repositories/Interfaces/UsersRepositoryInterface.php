<?php

namespace App\Repositories\Interfaces;

use App\Entities\UserEntity;
use App\Exceptions\DOGException;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

interface UsersRepositoryInterface
{
    /**
     * Entityを生成する
     *
     * @param array $user
     * @return UserEntity
     * @throws DOGException
     */
    public function new(array $user): UserEntity;

    /**
     * Usersテーブルの全レコードを取得する
     *
     * @return Collection
     */
    public function get(): Collection;

    /**
     * ログイン情報からusersテーブル情報を取得する
     *
     * @param string $email
     * @return User|null
     */
    public function getUser(string $email): ?User;

    /**
     * ログイン情報からadminsテーブル情報を取得する
     *
     * @param string $email
     * @return object|null
     */
    public function getAdminUser(string $email): ?object;

    /**
     * usersテーブルにレコードを挿入する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function saveUsers(UserEntity $user): bool;

    /**
     * usersテーブルのレコードを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateUsers(UserEntity $user): bool;

    /**
     * 引数のuser_idがtableのuser_idに一致するusersテーブル情報の有無を確認する
     *
     * @param string $userId
     * @return bool
     */
    public function existsUsers(string $userId): bool;

    /**
     * email, password一致するusersテーブル情報の有無を確認する
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function existsUsersByPass(string $email, string $password): bool;

    /**
     * 引数のメールアドレスが自身以外に存在するか確認する
     *
     * @param string $email
     * @return bool
     */
    public function existsEmail(string $email): bool;

    /**
     * UserIDでusersテーブルのレコードを取得する
     *
     * @param string $userId
     * @return User
     */
    public function selectUsersById(string $userId): User;

    /**
     * usersテーブルを複数のuidで検索し、退会していないユーザーのメールアドレスを取得する
     *
     * @param array $userIds
     * @return Collection|null
     */
    public function getUsersByIds(array $userIds): ?Collection;

    /**
     * usersのemailを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateEmail(UserEntity $user): bool;

    /**
     * usersのpasswordを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updatePassword(UserEntity $user): bool;

    /**
     * usersのnameを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateName(UserEntity $user): bool;

    /**
     * usersのweightを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateWeight(UserEntity $user): bool;

    /**
     * usersのinstagram_idを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateInstagram(UserEntity $user): bool;

    /**
     * usersのtwitter_idを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateTwitter(UserEntity $user): bool;

    /**
     * dog_image,update_dog_at,dog_image_void_flgを更新する
     *
     * @param stirng $userId
     * @return bool
     */
    public function updateImage($userId, $dogImage, $column): bool;

    /**
     * 引数のemailが一致するusersテーブル情報を取得する
     *
     * @param string $email
     * @return User
     */
    public function getUserByMail(string $email): ?User;

    /**
     * dog_pointを引数にランダムなユーザーを取得
     *
     * @param int $dogPoint
     * @return Collection
     */
    public function getTwoUsersByDogPoint(int $dogPoint): Collection;

    /**
     * user数を取得
     *
     * @return int
     */
    public function getDogCnt(): int;

    /**
     * dog_pointを1上げる
     *
     * @param string $userId
     * @return void
     */
    public function upDogPoint(string $userId): void;

    /**
     * dog_pointを1下げる
     *
     * @param string $userId
     * @return void
     */
    public function downDogPoint(string $userId): void;

    /**
     * yellow_cardを1増加
     *
     * @param string $userId
     * @return void
     */
    public function upYellowCard(string $userId): void;

    /**
     * yellow_cardを取得
     *
     * @param string $userId
     * @return User
     */
    public function getYellowCard(string $userId): User;

    /**
     * userIdを引数にupdate_dog_atを取得
     *
     * @param string $userId
     * @return User
     */
    public function getUpdateDogAt(string $userId): User;

    /**
     * userIdを引数にdog_image_void_flgを取得
     *
     * @param string $userId
     * @return User
     */
    public function getDogImageVoidFlg(string $userId): User;

    /**
     * dog_image_void_flgをupdateする
     *
     * @param string $userId
     * @param int $num
     * @return void
     */
    public function updateDogImageVoidFlg(string $userId, int $num): void;

    /**
     * 引数の数値分のdog_imageとdog_pointを取得
     *
     * @param string $sex
     * @param string $sort
     * @param int $num
     * @return Collection
     */
    public function getFace(string $sex, string $sort, int $num): Collection;

    /**
     * diagnosis結果を取得
     *
     * @param int $maxWeight
     * @param int $minWeight
     * @param string $face
     * @param int $personality1
     * @param int $personality2
     * @param int $personality3
     * @param string $holiday
     * @return object
     */
    public function getDiagnosisResult(int $maxWeight, int $minWeight, string $face, int $personality1, int $personality2, int $personality3, string $holiday): object;

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
    public function getDiagnosisResultAgain(string $face, int $personality1, int $personality2, int $personality3, string $holiday): object;

    /**
     * ユーザーを削除
     *
     * @param $userId
     * @return bool
     */
    public function deleteUser(string $userId): bool;

    /**
     * 不正な画像のユーザーを取得
     *
     * @return object
     */
    public function getVoidUsers(): object;

    /**
     * 顔面レベル上位三名を取得
     *
     * @return object
     */
    public function getRanking(): object;

    /**
     * ランダムに4ユーザー取得
     *
     * @return Collection
     */
    public function getUserRandom(): Collection;

    /**
     * フレンド情報を加えてユーザー取得
     *
     * @param $userId
     * @param ?int $offset
     * @return object
     */
    public function getUsersAllWithFriends($userId, ?int $offset = null): object;

    /**
     * フレンド取得
     *
     * @param $userId
     * @return object
     */
    public function getFriends($userId): object;

   /**
     * 特定のユーザーの情報を取得
     *
     * @param $toUserId
     * @param $fromUserId
     * @return object
     */
    public function getUserInfo($toUserId, $fromUserId): object;

  /**
   * 全てのユーザー取得
   *
   * @param ?int $offset
   * @return Collection
   */
  public function getUsersAll(?int $offset = null): Collection;
}