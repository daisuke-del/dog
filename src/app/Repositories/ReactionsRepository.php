<?php

namespace App\Repositories;

use App\Entities\UserEntity;
use App\Entities\ReactionEntity;
use App\Exceptions\MATCHException;
use App\Factories\UsersFactory;
use App\Factories\ReactionsFactory;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Reaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use App\Repositories\Interfaces\ReactionsRepositoryInterface;
use Collator;
use PhpParser\Node\Expr\Cast\Object_;

class ReactionsRepository implements ReactionsRepositoryInterface
{
    /**
     * Entityを生成する
     *
     * @param array $reaction
     * @return ReactionEntity
     * @throws MATCHException
     */
    public function new(array $reaction): ReactionEntity
    {
        return (new Reaction())->make(
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
     * お気に入りに追加
     *
     * @param string $toUserId
     * @param string $fromUserId
     * @return ReactionEntity
     * @throws MATCHException
     */
    public function addFavorite($toUserId, $fromUserId): ReactionEntity
    {
        return (new ReactionsFactory)->make(
            $toUserId,
            $fromUserId
        );
    }

    /**
     * お気に入りから削除
     *
     * @param string $toUserId
     * @param string $fromUserId
     * @return void
     * @throws MATCHException
     */
    public function deleteFavorite($toUserId, $fromUserId): void
    {
        // return (new Reaction)
        //     ->where('to_user_id', $toUserId)
        //     ->where('from_user_id', $fromUserId)
        //     ->delete();

        Reaction::where('to_user_id', $toUserId)->where('from_user_id', $fromUserId)->delete();
    }
}
