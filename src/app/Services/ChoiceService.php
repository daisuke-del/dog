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
     * ランダムに２ユーザーを取得
     *
     * @param  string $gender
     * @param int $searchFacePoint
     * @return array
     * @throw Exception
     */
    public function  getChoiceFace(string $gender, int $searchFacePoint = 101): array
    {
        if ($gender === 'man') {
            $searchGender = 'woman';
        }
        if ($gender === 'woman') {
            $searchGender = 'man';
        }
        if ( $searchFacePoint === 101 ) {
            $randomNum = mt_rand(1,99);
            return $this->usersRepository->getTwoUsersByFacePoint($searchGender, $randomNum)->toArray();
        }
        return $this->usersRepository->getTwoUsersByFacePoint($searchGender, $searchFacePoint)->toArray();
    }

    /**
     * 顔写真ではないボタンを押下時の処理
     *
     * @param string $userId
     * @return void
     * @throw Exception
     */
    public function clickNotFaceImageButton(string $userId): void
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
        if ( $this->usersRepository->getFaceImageVoidFlg($userId) == 0){
            if ( $this->usersRepository->getYellowCard($userId) > 2 ) {
                $this->usersRepository->updateFaceImageVoidFlg($userId, 1);
            }
        }
    }
}
