<?php

namespace App\Factories;

use App\Entities\UserEntity;
use App\ValueObjects\User\UserId;
use App\ValueObjects\User\Name;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\Password;
use App\ValueObjects\User\Sex;
use App\ValueObjects\User\Weight;
use App\ValueObjects\User\DogPoint;
use App\ValueObjects\User\DogImage1;
use App\ValueObjects\User\DogImage2;
use App\ValueObjects\User\DogImage3;
use App\ValueObjects\User\Breed1;
use App\ValueObjects\User\Breed2;
use App\ValueObjects\User\InstagramId;
use App\ValueObjects\User\TwitterId;
use App\ValueObjects\User\TiktokId;
use App\ValueObjects\User\BlogId;
use App\ValueObjects\User\Location;
use App\ValueObjects\User\Birthday;
use App\ValueObjects\User\Comment;
use App\ValueObjects\User\YellowCard;
use App\ValueObjects\User\UpdateDogAt;
use App\ValueObjects\User\CreateDate;
use App\ValueObjects\User\DogImageVoidFlg;
use Exception;

class UsersFactory
{
    /**
     * Entityを作成する
     *
     * @param string $userId
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $sex
     * @param int $weight
     * @param int $dogPoint
     * @param string $dogImage1
     * @param string $dogImage2
     * @param string $dogImage3
     * @param string $breed1
     * @param string $breed2
     * @param string $instagramId
     * @param string $twitterId
     * @param string $tiktokId
     * @param string $blogId
     * @param string $birthday
     * @param string $location
     * @param string $comment
     * @param int $yellowCard
     * @param string $updateDogAt
     * @param string $createDate
     * @param int $dogImageVoidFlg
     * @return UserEntity
     * @throws Exception
     */
    public function make(
        string $userId,
        string $name,
        string $email,
        string $password,
        string $sex,
        int $weight,
        int $dogPoint,
        ?string $dogImage1,
        ?string $dogImage2,
        ?string $dogImage3,
        ?string $breed1,
        ?string $breed2,
        ?string $instagramId,
        ?string $twitterId,
        ?string $tiktokId,
        ?string $blogId,
        ?string $birthday,
        ?string $location,
        ?string $comment,
        int $yellowCard,
        ?string $updateDogAt,
        string $createDate,
        int $dogImageVoidFlg
    ): UserEntity {
        return UserEntity::getUserEntityInstance(
            new UserId($userId),
            new Name($name),
            new Email($email),
            new Password($password),
            new Sex($sex),
            new Weight($weight),
            new DogPoint($dogPoint),
            new DogImage1($dogImage1),
            new DogImage2($dogImage2),
            new DogImage3($dogImage3),
            new Breed1($breed1),
            new Breed2($breed2),
            new InstagramId($instagramId),
            new TwitterId($twitterId),
            new TiktokId($tiktokId),
            new BlogId($blogId),
            new Birthday($birthday),
            new Location($location),
            new Comment($comment),
            new YellowCard($yellowCard),
            new UpdateDogAt($updateDogAt),
            new CreateDate($createDate),
            new DogImageVoidFlg($dogImageVoidFlg)
        );
    }
}
