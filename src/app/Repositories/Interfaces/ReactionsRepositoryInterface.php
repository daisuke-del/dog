<?php

namespace App\Repositories\Interfaces;

use App\Entities\UserEntity;
use App\Entities\ReactionEntity;
use App\Exceptions\MATCHException;
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
     * @throws MATCHException
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
}
