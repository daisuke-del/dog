<?php

namespace App\Repositories;

use App\Entities\UserEntity;
use App\Entities\ReactionEntity;
use App\Exceptions\DOGException;
use App\Factories\UsersFactory;
use App\Factories\ReactionsFactory;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Reaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use App\Repositories\Interfaces\ReactionsRepositoryInterface;

class ReactionsRepository implements ReactionsRepositoryInterface
{
    /**
     * Entityを生成する
     *
     * @param array $reaction
     * @return ReactionEntity
     * @throws DOGException
     */
    public function new(array $reaction): ReactionEntity
    {
        return (new ReactionsFactory)->make(
            $reaction['to_user_id'],
            $reaction['from_user_id']
        );
    }

    /**
     * 自分からのいいねを全てを取得する
     *
     * @param string $userId
     * @return Collection|null
     */
    public function selectMatchById(string $userId): ?Collection
    {
        return (new Reaction())
            ->where('from_user_id', $userId)
            ->get();
    }

    /**
     * マッチングしているかチェック
     *
     * @param string $toUserId
     * @param string $fromUserId
     * @return Reaction|null
     */
    public function checkMatchById(string $toUserId, string $fromUserId): ?Reaction
    {
        return (new Reaction())
            ->where('to_user_id', $fromUserId)
            ->where('from_user_id', $toUserId)
            ->first();
    }

    /**
     * お気に入りから削除
     *
     * @param string $toUserId
     * @param string $fromUserId
     * @return void
     * @throws DOGException
     */
    public function deleteFavorite($toUserId, $fromUserId): void
    {

        Reaction::where('to_user_id', $toUserId)->where('from_user_id', $fromUserId)->delete();
    }

    /**
     * 自分がいいねをしているかどうか状況を取得
     *
     * @param string $userId
     * @param array $results
     * @return Collection|null
     */
    public function getResultFavorite(string $userId, array $results): ?Collection
    {
        return (new Reaction())
            ->where('from_user_id', $userId)
            ->whereIn('to_user_id', $results)
            ->get();
    }

    /**
     * 相手からいいねをもらっているかどうか状況を取得
     *
     * @param string $userId
     * @param array $results
     * @return Collection|null
     */
    public function getResultBeFavorited(string $userId, array $results): ?Collection
    {
        return (new Reaction())
            ->whereIn('from_user_id', $results)
            ->where('to_user_id', $userId)
            ->get();
    }

    /**
     * reactionsテーブルにユーザー情報を登録する
     *
     * @param ReactionEntity $user
     * @return bool
     */
    public function save(ReactionEntity $user): bool
    {
        DB::beginTransaction();
        DB::connection('mysql')->beginTransaction();
        $isSaveReactions = (new Reaction([
            'to_user_id' => $user->getToUserId(),
            'from_user_id' => $user->getFromUserId(),
        ]))->save();
        if ($isSaveReactions) {
            DB::commit();
            DB::connection('mysql')->commit();
            return true;
        }
        DB::rollBack();
        DB::connection('mysql')->rollBack();
        return false;
    }
}
