<?php

namespace App\Repositories\Interfaces;

use App\Entities\UserEntity;
use App\Exceptions\MARIGOLDException;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

interface UsersRepositoryInterface
{
    /**
     * Entityを生成する
     *
     * @param array $user
     * @return UserEntity
     * @throws MARIGOLDException
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
     * usersのheightを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateHeight(UserEntity $user): bool;

    /**
     * usersのweightを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateWeight(UserEntity $user): bool;

    /**
     * usersのageを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateAge(UserEntity $user): bool;

    /**
     * usersのsalaryを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateSalary(UserEntity $user): bool;

    /**
     * usersのfacebook_idを更新する
     *
     * @param UserEntity $user
     * @return bool
     */
    public function updateFacebook(UserEntity $user): bool;

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
     * face_image,update_face_at,face_image_void_flgを更新する
     *
     * @param stirng $userId
     * @return bool
     */
    public function updateFace($userId, $faceImage, $num = 0): bool;

    /**
     * 引数のemailが一致するusersテーブル情報を取得する
     *
     * @param string $email
     * @return User
     */
    public function getUserByMail(string $email): ?User;

    /**
     * face_pointを引数にランダムなユーザーを取得
     *
     * @param int $facePoint
     * @param string $gender
     * @return Collection
     */
    public function getTwoUsersByFacePoint(int $facePoint, string $gender): Collection;

    /**
     * face_pointの最大値を取得
     *
     * @param int $facePoint
     * @param string $gender
     * @return array
     */
    public function getMaxFacePoint(string $gender): array;

    /**
     * face_pointを1上げる
     *
     * @param string $userId
     * @return void
     */
    public function upFacePoint(string $userId): void;

    /**
     * face_pointを1下げる
     *
     * @param string $userId
     * @return void
     */
    public function downFacePoint(string $userId): void;

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
     * userIdを引数にupdate_face_atを取得
     *
     * @param string $userId
     * @return User
     */
    public function getUpdateFaceAt(string $userId): User;

    /**
     * userIdを引数にface_image_void_flgを取得
     *
     * @param string $userId
     * @return User
     */
    public function getFaceImageVoidFlg(string $userId): User;

    /**
     * face_image_void_flgをupdateする
     *
     * @param string $userId
     * @param int $num
     * @return void
     */
    public function updateFaceImageVoidFlg(string $userId, int $num): void;

    /**
     * 引数の数値分のface_imageとface_pointを取得
     *
     * @param string $gender
     * @param string $sort
     * @param int $num
     * @return Collection
     */
    public function getFace(string $gender, string $sort, int $num): Collection;

    /**
     * match結果を取得
     *
     * @param array $matchInfo
     * @param string $place
     * @return object
     */
    public function getMatchResult(array $matchInfo, string $place): object;

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
     * @param $gender
     * @return object
     */
    public function getRanking(string $gender): object;
}


