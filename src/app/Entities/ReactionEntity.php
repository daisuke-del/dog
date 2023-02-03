<?php

namespace App\Entities;

use App\ValueObjects\Reaction\ToUserId;
use App\ValueObjects\Reaction\FromUserId;


class ReactionEntity
{

    // reaction
    private $toUserId;
    private $fromUserId;

    private function __construct()
    {
    }

    /**
     * UserEntityインスタンスを生成する
     *
     * @param ToUserId $toUserId
     * @param FromUserId $fromUserId
     * @return ReactionEntity
     */
    public static function getReactionEntityInstance(
        ToUserId   $toUserId,
        FromUserId $fromUserId
    )
    {
        $reaction = new self();
        $reaction->toUserId = $toUserId;
        $reaction->fromUserId = $fromUserId;
        return $reaction;
    }

    /**
     * to_user_idを取得する
     *
     * @return string
     */
    public function getToUserId(): string
    {
        return $this->toUserId->get();
    }

    /**
     * from_user_idを取得する
     *
     * @return string
     */
    public function getFromUserId(): string
    {
        return $this->fromUserId->get();
    }
}
