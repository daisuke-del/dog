<?php

namespace App\Services;

use App\Exceptions\DOGException;
use App\Repositories\UsersRepository;
use App\Repositories\ReactionsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * @throws DOGException
     */
    public function index(): array
    {
        $userId = Auth::id();
        if (is_null($userId)) {
            throw new DOGException(config('const.ERROR.USER.NO_REGISTERED'), 401);
        }

        $userInfo = $this->usersRepository->selectUsersById($userId)->toArray();
        if (is_null($userInfo)) {
            throw new DOGException(config('const.ERROR.USER.NO_REGISTERED'), 401);
        }
        $friends = [];
        $friends = $this->usersRepository->getFriends($userId);
        $given = [];
        $given = $this->usersRepository->getGiven($userId);
        $dogPoint = $userInfo['dog_point'] + count($friends) * 3;
        return [
            'user_id' => $userInfo['user_id'],
            'email' => $userInfo['email'],
            'sex' => $userInfo['sex'],
            'name' => $userInfo['name'],
            'weight' => $userInfo['weight'],
            'dog_image1' => $userInfo['dog_image1'],
            'dog_image2' => $userInfo['dog_image2'] ?: null,
            'dog_image3' => $userInfo['dog_image3'] ?: null,
            'dog_point' => $dogPoint,
            'void_flg' => $userInfo['dog_image_void_flg'],
            'friends' => $friends,
            'givens' => $given,
            'instagram_id' => $userInfo['instagram_id'] ?: null,
            'twitter_id' => $userInfo['twitter_id'] ?: null,
            'tiktok_id' => $userInfo['tiktok_id'] ?: null,
            'blog_id' => $userInfo['blog_id'] ?: null,
            'location' => $userInfo['location'],
            'birthday' => $userInfo['birthday'],
            'breed1' => $userInfo['breed1'],
            'breed2' => $userInfo['breed2']
        ];
    }

    /**
     * お気に入りに追加
     *
     * @param Request $request
     * @return object
     */
    public function addFavorite(Request $request): object
    {
        $toUserId = $request->input('toUserId');
        $fromUserId = Auth::id();
        $requestArr = [
            'to_user_id' => $toUserId,
            'from_user_id' => $fromUserId
        ];
        $this->insertRections($requestArr);
        return $this->usersRepository->getUserInfo($toUserId, $fromUserId);
    }

    /**
     * お気に入りから削除
     *
     * @param Request $request
     * @return object
     */
    public function deleteFavorite(Request $request): object
    {
        $toUserId = $request->input('toUserId');
        $fromUserId = Auth::id();
        $this->reactionsRepository->deleteFavorite($toUserId, $fromUserId);
        return $this->usersRepository->getUserInfo($toUserId, $fromUserId);
    }

    /**
     * お気に入りに追加
     *
     * @param Request $request
     * @return array
     */
    public function addFavoriteFromMypage(Request $request): array
    {
        $toUserId = $request->input('toUserId');
        $fromUserId = Auth::id();
        $requestArr = [
            'to_user_id' => $toUserId,
            'from_user_id' => $fromUserId
        ];
        $this->insertRections($requestArr);
        $friends = [];
        $friends = $this->usersRepository->getFriends($fromUserId);
        $given = [];
        $given = $this->usersRepository->getGiven($fromUserId);
        $dogInfo = [];
        $dogInfo = $this->usersRepository->getUserInfo($toUserId, $fromUserId);
        return [
            'givens' => $given,
            'friends' => $friends,
            'dog_info' => $dogInfo
        ];
    }

    /**
     * お気に入りから削除
     *
     * @param Request $request
     * @return array
     */
    public function deleteFavoriteFromMypage(Request $request): array
    {
        $toUserId = $request->input('toUserId');
        $fromUserId = Auth::id();
        $this->reactionsRepository->deleteFavorite($toUserId, $fromUserId);
        $friends = [];
        $friends = $this->usersRepository->getFriends($fromUserId);
        $given = [];
        $given = $this->usersRepository->getGiven($fromUserId);
        $dogInfo = [];
        $dogInfo = $this->usersRepository->getUserInfo($toUserId, $fromUserId);
        return [
            'givens' => $given,
            'friends' => $friends,
            'dog_info' => $dogInfo
        ];
    }

    private function insertRections(array $request): bool
    {
        DB::beginTransaction();
        try {
            $users = $this->reactionsRepository->new($request);
            $result = $this->reactionsRepository->save($users);
            DB::commit();
            return $result;
        } catch (DOGException $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
