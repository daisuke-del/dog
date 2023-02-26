<?php

namespace App\Repositories\Interfaces;

use App\Entities\UserEntity;
use App\Entities\ReactionEntity;
use App\Exceptions\MARIGOLDException;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use App\Models\Reaction;

interface ReactionsRepositoryInterface
{
    /**
     * Entityを生成する
     *
     * @param array $reaction
     * @return ReactionEntity
     * @throws MARIGOLDException
     */
    public function new(array $reaction): ReactionEntity;

    /**
     * 自分からのいいねを全てを取得する
     *
     * @param string $userId
     * @return Collection|null
     */
    public function selectMatchById(string $userId): ?Collection;

    /**
     * マッチングしているかチェック
     *
     * @param string $toUserId
     * @param string $fromUserId
     * @return Reaction|null
     */
    public function checkMatchById(string $toUserId, string $fromUserId): ?Reaction;

    /**
     * お気に入りから削除
     *
     * @param string $toUserId
     * @param string $fromUserId
     * @return void
     * @throws MARIGOLDException
     */
    public function deleteFavorite($toUserId, $fromUserId): void;

    /**
     * Resultのマッチ状況を取得
     *
     * @param string $userId
     * @param array $results
     * @return Collection|null
     */
    public function getResultFavorite(string $userId, array $results): ?Collection;

    /**
     * 相手からいいねをもらっているかどうか状況を取得
     *
     * @param string $userId
     * @param array $results
     * @return Collection|null
     */
    public function getResultBeFavorited(string $userId, array $results): ?Collection;

    /**
     * reactionsテーブルにユーザー情報を登録する
     *
     * @param ReactionEntity $user
     * @return bool
     */
    public function save(ReactionEntity $user): bool;
}
