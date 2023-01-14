<?php

namespace App\Factories;

use App\Entities\UserEntity;
use App\ValueObjects\User\UserId;
use App\ValueObjects\User\Name;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\Password;
use App\ValueObjects\User\Gender;
use App\ValueObjects\User\Height;
use App\ValueObjects\User\Weight;
use App\ValueObjects\User\Age;
use App\ValueObjects\User\Salary;
use App\ValueObjects\User\FacePoint;
use App\ValueObjects\User\Height2;
use App\ValueObjects\User\Weight2;
use App\ValueObjects\User\Age2;
use App\ValueObjects\User\Salary2;
use App\ValueObjects\User\FacePoint2;
use App\ValueObjects\User\FaceImage;
use App\ValueObjects\User\FacebookId;
use App\ValueObjects\User\InstagramId;
use App\ValueObjects\User\TwitterId;
use App\ValueObjects\User\YellowCard;
use App\ValueObjects\User\UpdateFaceAt;
use App\ValueObjects\User\CreateDate;
use App\ValueObjects\User\FaceImageVoidFlg;
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
     * @param string $gender
     * @param int $height
     * @param int $weight
     * @param int $age
     * @param int $salary
     * @param int $facePoint
     * @param int $height2
     * @param int $weight2
     * @param int $age2
     * @param int $salary2
     * @param int $facePoint2
     * @param string $faceImage
     * @param string $facebookId
     * @param string $instagramId
     * @param string $twitterId
     * @param int $yellowCard
     * @param string $updateFaceAt
     * @param string $createDate
     * @param int $faceImageVoidFlg
     * @param int $orderNumber
     * @return UserEntity
     * @throws Exception
     */
    public function make(
        string $userId,
        string $name,
        string $email,
        string $password,
        string $gender,
        int $height,
        int $weight,
        int $age,
        int $salary,
        string $facePoint,
        int $height2,
        int $weight2,
        int $age2,
        int $salary2,
        int $facePoint2,
        ?string $faceImage,
        ?string $facebookId,
        ?string $instagramId,
        ?string $twitterId,
        int $yellowCard,
        ?string $updateFaceAt,
        string $createDate,
        int $faceImageVoidFlg,
        ?int $orderNumber
    ): UserEntity {
        return UserEntity::getUserEntityInstance(
            new UserId($userId),
            new Name($name),
            new Email($email),
            new Password($password),
            new Gender($gender),
            new Height($height),
            new Weight($weight),
            new Age($age),
            new Salary($salary),
            new FacePoint($facePoint),
            new Height2($height2),
            new Weight2($weight2),
            new Age2($age2),
            new Salary2($salary2),
            new FacePoint2($facePoint2),
            new FaceImage($faceImage),
            new FacebookId($facebookId),
            new InstagramId($instagramId),
            new TwitterId($twitterId),
            new YellowCard($yellowCard),
            new UpdateFaceAt($updateFaceAt),
            new CreateDate($createDate),
            new FaceImageVoidFlg($faceImageVoidFlg),
            new OrderNumber($orderNumber)
        );
    }
}
