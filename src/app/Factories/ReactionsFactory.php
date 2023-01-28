<?php

namespace App\Factories;

use App\Entities\ReactionEntity;
use App\ValueObjects\Reaction\toUserId;
use App\ValueObjects\Reaction\fromUserId;
use Exception;

class ReactionsFactory
{
    /**
     * Entityを作成する
     *
     * @param string $toUserId
     * @param string $fromUserId
     * @return ReactionEntity
     * @throws Exception
     */
    public function make(
        string $toUserId,
        string $fromUserId,
    ): ReactionEntity {
        return ReactionEntity::getReactionEntityInstance(
            new ToUserId($toUserId),
            new FromUserId($fromUserId),
        );
    }
}
