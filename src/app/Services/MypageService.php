<?php

namespace App\Services;

use App\Exceptions\MUCHException;
use Carbon\Carbon;
use App\Repositories\UsersRepository;
use App\Repositories\ReactionsRepository;
use Exceptions;


class MypageService {

    private $usersRepository;
    private $reactionsRepository;

    /**
     * @var ReactionsRepository
     */
    public function __construct()
    {
        $this->usersRepository = new UsersRepository;
        $this->reactionsRepository = new ReactionsRepository;

    }

    /**
     * マイページTOP
     *
     * @return array
     * @throws MUCHException
     */
    public function index(): array
    {
        $userId = auth()->id();
        $user = $this->usersRepository->selectUsersById($userId);
        $status = $this->getFaceStatus($userId);
        $continuationScore = $this->getContinuationScore($userId);
        $friends = $this->getMuchAll($userId);
        return [
            'name' => $user['name'],
            'status' => $status,
            'face_image' => $user['face_image'],
            'score' => $continuationScore,
            'friends' => $friends
        ];
    }



    /**
     * userIdから全てのマッチングを取得
     *
     * @param string $userId
     * @return array
     * @throw Exception
     */
    private function getMuchAll(string $userId): array
    {
        return $this->reactionsRepository->selectMuchById($userId)->toArray();
    }

    /**
     * face_pointとupdate_face_atからステータスを取得
     *
     * @param string $userId
     * @return string
     * @throw Exception
     */
    private function getFaceStatus(string $userId): string
    {
        $user = $this->usersRepository->selectUserById($userId);
        if (empty($user)) {
            // ユーザー情報が取得できない
            $error = [
                'error_code' => config('const.ERROR_CODE.SETTLEMENT.NO_USER'),
                'user_id' => $userId
            ];
            throw new MUCHException(config('const.ERROR.USER.NO_USER'), 404, $error);
        }

        $facePoint = $user['face_point'];
        $continuationScore = $this->getContinuationScore($userId);

        if ( $facePoint >= 90 && $continuationScore === 'S' | 'A' ) {
            return 'gold' ;
        }  elseif ( $facePoint >= 70 && $continuationScore === 'S' | 'A' | 'B' ) {
            return 'silver';
        } elseif ( $facePoint >= 30 && $continuationScore === 'S' | 'A' | 'B' | 'C'  ) {
            return 'blond';
        } else {
            return 'normal';
        }
    }

    /**
     * update_face_atから継続スコアを取得
     *
     * @param string $userId
     * @return string
     * @throw Exception
     */
    private function getContinuationScore(string $userId): string
    {
        $updateFaceAt = $this->usersRepository->getUpdateFaceAt($userId);
        if (empty($updateFaceAt)) {
            // ユーザー情報が取得できない
            $error = [
                'error_code' => config('const.ERROR_CODE.SETTLEMENT.NO_USER'),
                'user_id' => $userId
            ];
            throw new MUCHException(config('const.ERROR.USER.NO_USER'), 404, $error);
        }

        $now = Carbon::now();
        $continuationDate = $updateFaceAt->diffInDays($now);

        if ( $continuationDate > 90 ) {
            return 'S' ;
        }  elseif ( $continuationDate >= 60 ) {
            return 'A';
        } elseif ( $continuationDate >= 30 ) {
            return 'B';
        } elseif ( $continuationDate >= 10 ) {
            return 'C';
        } else {
            return 'N';
        }
    }

    /**
     * フレンドの詳細を取得
     *
     * @param string $userId
     * @return array
     * @throw Exception
     */
    public function getFriendDetail(string $userId): array
    {
        $friendDetail = $this->usersRepository->selectUserById($userId);
        return [
            'name' => $friendDetail['name'],
            'face_image' => $friendDetail['face_image'],
            'height' => $friendDetail['height'],
            'salary' => $friendDetail['salary'],
            'facebook_id' => $friendDetail['facebook_id'],
            'instagram_id' => $friendDetail['instagram_id'],
            'twitter_id' => $friendDetail['twitter_id']
        ];
    }
}

