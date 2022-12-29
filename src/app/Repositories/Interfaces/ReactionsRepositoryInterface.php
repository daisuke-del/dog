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
     * マッチを全てを取得する
     *
     * @param string $userId
     * @return Reaction
     */
    public function selectMATCHById(string $userId): Reaction;

}
