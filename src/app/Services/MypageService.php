<?php

namespace App\Services;

use App\Exceptions\MATCHException;
use Carbon\Carbon;
use App\Repositories\UsersRepository;
use App\Repositories\ReactionsRepository;
use Illuminate\Support\Facades\Auth;
use Exceptions;
use Illuminate\Support\Facades\Log;

class MypageService
{

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
     * @throws MATCHException
     */
    public function index(): array
    {
        $userId = Auth::id();
        if (is_null($userId)) {
            throw new MATCHException(config('const.ERROR.USER.NO_REGISTERED'), 401);
        }

        $userInfo = $this->usersRepository->selectUsersById($userId)->toArray();
        if (is_null($userInfo)) {
            throw new MATCHException(config('const.ERROR.USER.NO_REGISTERED'), 401);
        }
        $continuationScore = $this->getContinuationScore($userInfo['update_face_at']);
        $rank = $this->getFaceStatus($userInfo['face_point'], $continuationScore);
        $friendIds = $this->getMatchAll($userId);
        if (isset($friendIds)) {
            $userIds = [];
            foreach($friendIds as $friendId) {
                $userIds[] = $friendId['from_user_id'];
            }
            $friends = $this->usersRepository->getUsersByIds($userIds);
        }
        return [
            'gender' => $userInfo['gender'],
            'name' => $userInfo['name'],
            'rank' => $rank,
            'face_image' => $userInfo['face_image'],
            'face_point' => $userInfo['face_point'],
            'score' => $continuationScore,
            'void_flg' => $userInfo['face_image_void_flg'],
            'friends' => $friends ? $friends : null
        ];
    }



    /**
     * userIdから全てのマッチングを取得
     *
     * @param string $userId
     * @return ?array
     * @throw Exception
     */
    private function getMatchAll(string $userId): ?array
    {
        $onsideLove = $this->reactionsRepository->selectMatchById($userId)->toArray();
        $result = [];
        foreach($onsideLove as $friend) {
            $friendInfo = $this->reactionsRepository->checkMatchById($friend['to_user_id'], $userId)->toArray();
            if ($friendInfo) {
                $result[] = $friendInfo;
            }
        }
        return $result;
    }

    /**
     * face_pointとupdate_face_atからステータスを取得
     *
     * @param int $facePoint
     * @param string $continuationScore
     * @return string
     * @throw Exception
     */
    public function getFaceStatus($facePoint, $continuationScore): string
    {
        if ($facePoint >= 90 && ($continuationScore === 'S' || $continuationScore ==='A')) {
            return 'gold';
        } elseif ($facePoint >= 70 && ($continuationScore === 'S' || $continuationScore === 'A' || $continuationScore === 'B')) {
            return 'silver';
        } elseif ($facePoint >= 30 && ($continuationScore === 'S' || $continuationScore === 'A' || $continuationScore === 'B' || $continuationScore === 'C')) {
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
    public function getContinuationScore($updateFaceAt): string
    {
        $oldDay = new Carbon($updateFaceAt);
        if (empty($updateFaceAt)) {
            // ユーザー情報が取得できない
            $error = [
                'error_code' => config('const.ERROR_CODE.SETTLEMENT.NO_USER')
            ];
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404, $error);
        }

        $now = Carbon::now();
        $continuationDate = $oldDay->diffInDays($now);

        if ($continuationDate > 90) {
            return 'S';
        } elseif ($continuationDate >= 60) {
            return 'A';
        } elseif ($continuationDate >= 30) {
            return 'B';
        } elseif ($continuationDate >= 10) {
            return 'C';
        } else {
            return 'D';
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
        $friendDetail = $this->usersRepository->selectUsersById($userId);
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
