<?php

namespace App\Factories;

use App\Entities\UserEntity;
use App\ValueObjects\User\Age;
use App\ValueObjects\User\AuthCode;
use App\ValueObjects\User\CreateDate;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\FacebookId;
use App\ValueObjects\User\FaceImage;
use App\ValueObjects\User\FacePoint;
use App\ValueObjects\User\Gender;
use App\ValueObjects\User\Height;
use App\ValueObjects\User\InstagramId;
use App\ValueObjects\User\Password;
use App\ValueObjects\User\Salary;
use App\ValueObjects\User\TwitterId;
use App\ValueObjects\User\UpdateFaceAt;
use App\ValueObjects\User\UserId;
use App\ValueObjects\User\Weight;
use App\ValueObjects\User\YellowCard;
use App\ValueObjects\User\Name;
use App\ValueObjects\User\FaceImageVoidFlg;
use Exception;

class UsersFactory
{
    /**
     * Entityを作成する
     *
     * @param int $age
     * @param string $authCode
     * @param string $createDate
     * @param string $email
     * @param string $userId
     * @param string $password
     * @param string $facebookId
     * @param string $instagramId
     * @param string $twitterId
     * @param string $facePoint
     * @param string $faceImage
     * @param string $gender
     * @param int $height
     * @param int $salary
     * @param int $weight
     * @param int $yellowCard
     * @param string $updateFaceAt
     * @param string $name
     * @param int $faceImageVoidFlg
     * @return UserEntity
     * @throws Exception
     */
    public function make(
     int $age,
     string $authCode,
     string $createDate,
     string $email,
     string $userId,
     string $password,
     string $facebookId,
     string $instagramId,
     string $twitterId,
     string $facePoint,
     string $faceImage,
     string $gender,
     int $height,
     int $salary,
     int $weight,
     int $yellowCard,
     string $updateFaceAt,
     string $name,
     int $faceImageVoidFlg
    ): UserEntity {
        return UserEntity::getUserEntityInstance(
            new Age($age),
            new AuthCode($authCode),
            new CreateDate($createDate),
            new Email($email),
            new Password($password),
            new UserId($userId),
            new FacebookId($facebookId),
            new InstagramId($instagramId),
            new TwitterId($twitterId),
            new FacePoint($facePoint),
            new FaceImage($faceImage),
            new Gender($gender),
            new Height($height),
            new Salary($salary),
            new Weight($weight),
            new YellowCard($yellowCard),
            new UpdateFaceAt($updateFaceAt),
            new Name($name),
            new FaceImageVoidFlg($faceImageVoidFlg)
        );
    }
}
