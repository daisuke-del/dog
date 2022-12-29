<?php

namespace App\Repositories\Interfaces;

use App\Entities\UserEntity;
use App\Exceptions\MATCHException;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

interface UsersRepositoryInterface
{
    /**
     * Entityを生成する
     *
     * @param array $user
     * @return UserEntity
     * @throws MATCHException
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
     * @param string $password
     * @return User
     */
    public function getUser(string $email, string $password): User;

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
     * 引数のuidがuser_idに一致するusersテーブル情報の有無を確認する
     *
     * @param string $uid
     * @return bool
     */
    public function existsUid(string $uid): bool;

    /**
     * 引数のメールアドレスが自身以外に存在するか確認する
     *
     * @param string $email
     * @param string $userId
     * @return bool
     */
    public function existsEmail(string $email, string $userId): bool;

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
     * @return Collection
     */
    public function getEmailByIds(array $userIds): Collection;

//    /**
//     * usersのemail_confirm_flgを更新する
//     *
//     * @param UserEntity $user
//     * @return bool
//     */
//    public function updateUserConfirm(UserEntity $user): bool;

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
     * face_pointを引数にランダムなユーザーを取得
     *
     * @param int $facePoint
     * @param string $gender
     * @return User
     */
    public function getTwoUsersByFacePoint(int $facePoint, string $gender): User;

    /**
     * 任意の数のユーザーを取得する。
     *
     * @param string $gender
     * @param int $num
     * @param string $order
     * @return array
     */
    public function getFaceAndFacePoint(string $gender, int $num, string $order): array;
}


