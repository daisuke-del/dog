<?php

namespace App\Services;

use App\Exceptions\MARIGOLDException;
use Carbon\Carbon;
use App\Repositories\UsersRepository;
use App\Repositories\ReactionsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


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
     * @throws MARIGOLDException
     */
    public function index(): array
    {
        $userId = Auth::id();
        if (is_null($userId)) {
            throw new MARIGOLDException(config('const.ERROR.USER.NO_REGISTERED'), 401);
        }

        $userInfo = $this->usersRepository->selectUsersById($userId)->toArray();
        if (is_null($userInfo)) {
            throw new MARIGOLDException(config('const.ERROR.USER.NO_REGISTERED'), 401);
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
            'user_id' => $userInfo['user_id'],
            'email' => $userInfo['email'],
            'gender' => $userInfo['gender'],
            'name' => $userInfo['name'],
            'height' => $userInfo['height'],
            'weight' => $userInfo['weight'],
            'age' => $userInfo['age'],
            'salary' => $userInfo['salary'],
            'rank' => $rank,
            'face_image' => $userInfo['face_image'],
            'face_point' => $userInfo['face_point'],
            'score' => $continuationScore,
            'void_flg' => $userInfo['face_image_void_flg'],
            'friends' => $friends ? $friends : null,
            'facebook_id' => $userInfo['facebook_id'],
            'instagram_id' => $userInfo['instagram_id'],
            'twitter_id' => $userInfo['twitter_id']
        ];
    }



    /**
     * userIdから全てのマッチングを取得
     *
     * @param string $userId
     * @return ?array
     * @throw Exception
     */
    public function getMatchAll(string $userId): ?array
    {
        $onesideLove = $this->reactionsRepository->selectMatchById($userId);
        $result = [];
        if (empty($onesideLove)) {
            return $result;
        }
        foreach($onesideLove->toArray() as $friend) {
            $friendInfo = $this->reactionsRepository->checkMatchById($friend['to_user_id'], $userId);
            if ($friendInfo) {
                $result[] = $friendInfo->toArray();
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
            return 'Gold';
        } elseif ($facePoint >= 70 && ($continuationScore === 'S' || $continuationScore === 'A' || $continuationScore === 'B')) {
            return 'Silver';
        } elseif ($facePoint >= 30 && ($continuationScore === 'S' || $continuationScore === 'A' || $continuationScore === 'B' || $continuationScore === 'C')) {
            return 'Blond';
        } else {
            return 'Nomal';
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
            throw new MARIGOLDException(config('const.ERROR.USER.NO_USER'), 404, $error);
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

    /**
     * お気に入りに追加
     *
     * @param Request $request
     * @return array
     */
    public function addFavorite(Request $request): array
    {
        $toUserId = $request->input('toUserId');
        $fromUserId = Auth::id();
        $requestArr = [
            'to_user_id' => $toUserId,
            'from_user_id' => $fromUserId ];
        $this->insertRections($requestArr);
        return [];
    }

    /**
     * お気に入りから削除
     *
     * @param Request $request
     * @return object|null
     */
    public function deleteFavorite(Request $request): ?object
    {
        $toUserId = $request->input('toUserId');
        $fromUserId = Auth::id();
        $this->reactionsRepository->deleteFavorite($toUserId, $fromUserId);
        $friendIds = $this->getMatchAll($fromUserId);
        if (isset($friendIds)) {
            $userIds = [];
            foreach($friendIds as $friendId) {
                $userIds[] = $friendId['from_user_id'];
            }
            $friends = $this->usersRepository->getUsersByIds($userIds);
        }
        return $friends;
    }

    /**
     * reactionsにレコードを登録する
     *
     * @param array $request
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    private function insertRections(array $request): array
    {
        $users = $this->reactionsRepository->new($request);
        // usersテーブルに新規追加
        $this->reactionsRepository->save($users);
        // レスポンス
        return [];
    }
}
