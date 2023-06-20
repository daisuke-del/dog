<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use App\Repositories\ReactionsRepository;


class ChoiceService
{

    private $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository;

    }

    /**
     * 顔写真ではないボタンを押下時の処理
     *
     * @param string $userId
     * @return void
     * @throw Exception
     */
    public function clickNotDogImageButton(string $userId): void
    {
        $this->usersRepository->upYellowCard($userId);
    }

    /**
     * yellow_card が３回以上になったら
     *
     * @param string $userId
     * @return void
     * @throw Exception
     */
    public function checkYellowCards(string $userId): void
    {
        if ($this->usersRepository->getDogImageVoidFlg($userId) === 0) {
            if ($this->usersRepository->getYellowCard($userId) > 2) {
                $this->usersRepository->updateDogImageVoidFlg($userId, 1);
            }
        }
    }
}
