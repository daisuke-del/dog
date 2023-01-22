<?php

namespace App\Services;

use App\Exceptions\MATCHException;
use Carbon\Carbon;
use App\Repositories\UsersRepository;
use App\Repositories\ReactionsRepository;
use Illuminate\Support\Facades\Auth;
use Exceptions;
use Illuminate\Support\Facades\Log;

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
     * @throws MATCHException
     */
    public function index(): array
    {
        $userInfo = Auth::user();
        $session = session()->all();
        Log::info('$userInfo');
        Log::debug($userInfo);
        return [$userInfo, $session];
        // $userId = Auth::id();
        // if (is_null($userInfo) || is_null($userId)) {
        //     throw new MATCHException(config('const.ERROR.USER.NO_REGISTERED'), 401);
        // }

        // $status = $this->getFaceStatus($userId);
        // $continuationScore = $this->getContinuationScore($userId);
        // $friendIds = $this->getMatchAll($userId);
        // $friends = $this->usersRepository->getUserByIds($friendIds);
        // return [
        //     'name' => $userInfo->name,
        //     'status' => $status,
        //     'face_image' => $userInfo->face_image,
        //     'face_point' => $userInfo->face_point,
        //     'score' => $continuationScore,
        //     'friends' => $friends
        // ];
    }



    /**
     * userIdから全てのマッチングを取得
     *
     * @param string $userId
     * @return array
     * @throw Exception
     */
    private function getMatchAll(string $userId): array
    {
        return $this->reactionsRepository->selectMatchById($userId)->toArray();
    }

    /**
     * face_pointとupdate_face_atからステータスを取得
     *
     * @param string $userId
     * @return string
     * @throw Exception
     */
    public function getFaceStatus(string $userId): string
    {
        $user = Auth::user();
        if (empty($user)) {
            // ユーザー情報が取得できない
            $error = [
                'error_code' => config('const.ERROR_CODE.SETTLEMENT.NO_USER'),
                'user_id' => $userId
            ];
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404, $error);
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
    public function getContinuationScore(string $userId): string
    {
        $updateFaceAt = $this->usersRepository->getUpdateFaceAt($userId);
        if (empty($updateFaceAt)) {
            // ユーザー情報が取得できない
            $error = [
                'error_code' => config('const.ERROR_CODE.SETTLEMENT.NO_USER'),
                'user_id' => $userId
            ];
            throw new MATCHException(config('const.ERROR.USER.NO_USER'), 404, $error);
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

