<?php

namespace App\Factories;

use App\Entities\UserEntity;
use App\ValueObjects\User\UserId;
use App\ValueObjects\User\Name;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\Password;
use App\ValueObjects\User\Sex;
use App\ValueObjects\User\Height;
use App\ValueObjects\User\Weight;
use App\ValueObjects\User\Age;
use App\ValueObjects\User\Salary;
use App\ValueObjects\User\DogPoint;
use App\ValueObjects\User\Height2;
use App\ValueObjects\User\Weight2;
use App\ValueObjects\User\Age2;
use App\ValueObjects\User\Salary2;
use App\ValueObjects\User\DogPoint2;
use App\ValueObjects\User\DogImage;
use App\ValueObjects\User\FacebookId;
use App\ValueObjects\User\InstagramId;
use App\ValueObjects\User\TwitterId;
use App\ValueObjects\User\YellowCard;
use App\ValueObjects\User\UpdateDogAt;
use App\ValueObjects\User\CreateDate;
use App\ValueObjects\User\DogImageVoidFlg;
use App\ValueObjects\User\OrderNumber;
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
     * @param int $height
     * @param int $weight
     * @param int $age
     * @param int $salary
     * @param int $dogPoint
     * @param int $height2
     * @param int $weight2
     * @param int $age2
     * @param int $salary2
     * @param int $dogPoint2
     * @param string $dogImage
     * @param string $facebookId
     * @param string $instagramId
     * @param string $twitterId
     * @param int $yellowCard
     * @param string $updateDogAt
     * @param string $createDate
     * @param int $dogImageVoidFlg
     * @param int $orderNumber
     * @return UserEntity
     * @throws Exception
     */
    public function make(
        string $userId,
        string $name,
        string $email,
        string $password,
        string $sex,
        int $height,
        int $weight,
        int $age,
        int $salary,
        string $dogPoint,
        int $height2,
        int $weight2,
        int $age2,
        int $salary2,
        int $dogPoint2,
        ?string $dogImage,
        ?string $facebookId,
        ?string $instagramId,
        ?string $twitterId,
        int $yellowCard,
        ?string $updateDogAt,
        string $createDate,
        int $dogImageVoidFlg,
        ?int $orderNumber
    ): UserEntity {
        return UserEntity::getUserEntityInstance(
            new UserId($userId),
            new Name($name),
            new Email($email),
            new Password($password),
            new Sex($sex),
            new Height($height),
            new Weight($weight),
            new Age($age),
            new Salary($salary),
            new DogPoint($dogPoint),
            new Height2($height2),
            new Weight2($weight2),
            new Age2($age2),
            new Salary2($salary2),
            new DogPoint2($dogPoint2),
            new DogImage($dogImage),
            new FacebookId($facebookId),
            new InstagramId($instagramId),
            new TwitterId($twitterId),
            new YellowCard($yellowCard),
            new UpdateDogAt($updateDogAt),
            new CreateDate($createDate),
            new DogImageVoidFlg($dogImageVoidFlg),
            new OrderNumber($orderNumber)
        );
    }
}
